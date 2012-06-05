/* -*- Mode: Java; tab-width: 2; indent-tabs-mode: nil; c-basic-offset: 2 -*- */
/* vim: set shiftwidth=2 tabstop=2 autoindent cindent expandtab: */

'use strict';

var globalScope = (typeof window === 'undefined') ? this : window;

var isWorker = (typeof window == 'undefined');

var ERRORS = 0, WARNINGS = 1, TODOS = 5;
var verbosity = WARNINGS;

// The global PDFJS object exposes the API
// In production, it will be declared outside a global wrapper
// In development, it will be declared here
if (!globalScope.PDFJS) {
  globalScope.PDFJS = {};
}

// getPdf()
// Convenience function to perform binary Ajax GET
// Usage: getPdf('http://...', callback)
//        getPdf({
//                 url:String ,
//                 [,progress:Function, error:Function]
//               },
//               callback)
function getPdf(arg, callback) {
  var params = arg;
  if (typeof arg === 'string')
    params = { url: arg };

  var xhr = new XMLHttpRequest();
  xhr.open('GET', params.url);
  xhr.mozResponseType = xhr.responseType = 'arraybuffer';
  var protocol = params.url.indexOf(':') < 0 ? window.location.protocol :
    params.url.substring(0, params.url.indexOf(':') + 1);
  xhr.expected = (protocol === 'http:' || protocol === 'https:') ? 200 : 0;

  if ('progress' in params)
    xhr.onprogress = params.progress || undefined;

  if ('error' in params)
    xhr.onerror = params.error || undefined;

  xhr.onreadystatechange = function getPdfOnreadystatechange(e) {
    if (xhr.readyState === 4) {
      if (xhr.status === xhr.expected) {
        var data = (xhr.mozResponseArrayBuffer || xhr.mozResponse ||
                    xhr.responseArrayBuffer || xhr.response);
        callback(data);
      } else if (params.error) {
        params.error(e);
      }
    }
  };
  xhr.send(null);
}
globalScope.PDFJS.getPdf = getPdf;
globalScope.PDFJS.pdfBug = false;

var Page = (function PageClosure() {
  function Page(xref, pageNumber, pageDict, ref) {
    this.pageNumber = pageNumber;
    this.pageDict = pageDict;
    this.stats = new StatTimer();
    this.stats.enabled = !!globalScope.PDFJS.enableStats;
    this.xref = xref;
    this.ref = ref;

    this.displayReadyPromise = null;
  }

  Page.prototype = {
    getPageProp: function Page_getPageProp(key) {
      return this.pageDict.get(key);
    },
    inheritPageProp: function Page_inheritPageProp(key) {
      var dict = this.pageDict;
      var obj = dict.get(key);
      while (obj === undefined) {
        dict = dict.get('Parent');
        if (!dict)
          break;
        obj = dict.get(key);
      }
      return obj;
    },
    get content() {
      return shadow(this, 'content', this.getPageProp('Contents'));
    },
    get resources() {
      return shadow(this, 'resources', this.inheritPageProp('Resources'));
    },
    get mediaBox() {
      var obj = this.inheritPageProp('MediaBox');
      // Reset invalid media box to letter size.
      if (!isArray(obj) || obj.length !== 4)
        obj = [0, 0, 612, 792];
      return shadow(this, 'mediaBox', obj);
    },
    get view() {
      var cropBox = this.inheritPageProp('CropBox');
      var view = {
        x: 0,
        y: 0,
        width: this.width,
        height: this.height
      };
      if (!isArray(cropBox) || cropBox.length !== 4)
        return shadow(this, 'view', view);

      var mediaBox = this.mediaBox;
      var offsetX = mediaBox[0], offsetY = mediaBox[1];

      // From the spec, 6th ed., p.963:
      // "The crop, bleed, trim, and art boxes should not ordinarily
      // extend beyond the boundaries of the media box. If they do, they are
      // effectively reduced to their intersection with the media box."
      cropBox = Util.intersect(cropBox, mediaBox);
      if (!cropBox)
        return shadow(this, 'view', view);

      var tl = this.rotatePoint(cropBox[0] - offsetX, cropBox[1] - offsetY);
      var br = this.rotatePoint(cropBox[2] - offsetX, cropBox[3] - offsetY);
      view.x = Math.min(tl.x, br.x);
      view.y = Math.min(tl.y, br.y);
      view.width = Math.abs(tl.x - br.x);
      view.height = Math.abs(tl.y - br.y);

      return shadow(this, 'view', view);
    },
    get annotations() {
      return shadow(this, 'annotations', this.inheritPageProp('Annots'));
    },
    get width() {
      var mediaBox = this.mediaBox;
      var rotate = this.rotate;
      var width;
      if (rotate == 0 || rotate == 180) {
        width = (mediaBox[2] - mediaBox[0]);
      } else {
        width = (mediaBox[3] - mediaBox[1]);
      }
      return shadow(this, 'width', width);
    },
    get height() {
      var mediaBox = this.mediaBox;
      var rotate = this.rotate;
      var height;
      if (rotate == 0 || rotate == 180) {
        height = (mediaBox[3] - mediaBox[1]);
      } else {
        height = (mediaBox[2] - mediaBox[0]);
      }
      return shadow(this, 'height', height);
    },
    get rotate() {
      var rotate = this.inheritPageProp('Rotate') || 0;
      // Normalize rotation so it's a multiple of 90 and between 0 and 270
      if (rotate % 90 != 0) {
        rotate = 0;
      } else if (rotate >= 360) {
        rotate = rotate % 360;
      } else if (rotate < 0) {
        // The spec doesn't cover negatives, assume its counterclockwise
        // rotation. The following is the other implementation of modulo.
        rotate = ((rotate % 360) + 360) % 360;
      }
      return shadow(this, 'rotate', rotate);
    },

    startRenderingFromOperatorList:
      function Page_startRenderingFromOperatorList(operatorList, fonts) {
      var self = this;
      this.operatorList = operatorList;

      var displayContinuation = function pageDisplayContinuation() {
        // Always defer call to display() to work around bug in
        // Firefox error reporting from XHR callbacks.
        setTimeout(function pageSetTimeout() {
          self.displayReadyPromise.resolve();
        });
      };

      this.ensureFonts(fonts,
        function pageStartRenderingFromOperatorListEnsureFonts() {
          displayContinuation();
        }
      );
    },

    getOperatorList: function Page_getOperatorList(handler, dependency) {
      if (this.operatorList) {
        // content was compiled
        return this.operatorList;
      }

      this.stats.time('Build IR Queue');

      var xref = this.xref;
      var content = this.content;
      var resources = this.resources;
      if (isArray(content)) {
        // fetching items
        var i, n = content.length;
        for (i = 0; i < n; ++i)
          content[i] = xref.fetchIfRef(content[i]);
        content = new StreamsSequenceStream(content);
      } else if (!content) {
        // replacing non-existent page content with empty one
        content = new Stream(new Uint8Array(0));
      }

      var pe = this.pe = new PartialEvaluator(
                                xref, handler, 'p' + this.pageNumber + '_');

      this.operatorList = pe.getOperatorList(content, resources, dependency);
      this.stats.timeEnd('Build IR Queue');
      return this.operatorList;
    },

    ensureFonts: function Page_ensureFonts(fonts, callback) {
      this.stats.time('Font Loading');
      // Convert the font names to the corresponding font obj.
      for (var i = 0, ii = fonts.length; i < ii; i++) {
        fonts[i] = this.objs.objs[fonts[i]].data;
      }

      // Load all the fonts
      FontLoader.bind(
        fonts,
        function pageEnsureFontsFontObjs(fontObjs) {
          this.stats.timeEnd('Font Loading');

          callback.call(this);
        }.bind(this)
      );
    },

    display: function Page_display(gfx, callback) {
      var stats = this.stats;
      stats.time('Rendering');
      var xref = this.xref;
      var resources = this.resources;
      var mediaBox = this.mediaBox;
      assertWellFormed(isDict(resources), 'invalid page resources');

      gfx.xref = xref;
      gfx.res = resources;
      gfx.beginDrawing({ x: mediaBox[0], y: mediaBox[1],
            width: this.width,
            height: this.height,
            rotate: this.rotate });

      var startIdx = 0;
      var length = this.operatorList.fnArray.length;
      var operatorList = this.operatorList;
      var stepper = null;
      if (PDFJS.pdfBug && StepperManager.enabled) {
        stepper = StepperManager.create(this.pageNumber);
        stepper.init(operatorList);
        stepper.nextBreakPoint = stepper.getNextBreakPoint();
      }

      var self = this;
      function next() {
        startIdx =
          gfx.executeOperatorList(operatorList, startIdx, next, stepper);
        if (startIdx == length) {
          gfx.endDrawing();
          stats.timeEnd('Rendering');
          stats.timeEnd('Overall');
          if (callback) callback();
        }
      }
      next();
    },
    rotatePoint: function Page_rotatePoint(x, y, reverse) {
      var rotate = reverse ? (360 - this.rotate) : this.rotate;
      switch (rotate) {
        case 180:
          return {x: this.width - x, y: y};
        case 90:
          return {x: this.width - y, y: this.height - x};
        case 270:
          return {x: y, y: x};
        case 360:
        case 0:
        default:
          return {x: x, y: this.height - y};
      }
    },
    getLinks: function Page_getLinks() {
      var links = [];
      var annotations = pageGetAnnotations();
      var i, n = annotations.length;
      for (i = 0; i < n; ++i) {
        if (annotations[i].type != 'Link')
          continue;
        links.push(annotations[i]);
      }
      return links;
    },
    getAnnotations: function Page_getAnnotations() {
      var xref = this.xref;
      function getInheritableProperty(annotation, name) {
        var item = annotation;
        while (item && !item.has(name)) {
          item = item.get('Parent');
        }
        if (!item)
          return null;
        return item.get(name);
      }
      function isValidUrl(url) {
        if (!url)
          return false;
        var colon = url.indexOf(':');
        if (colon < 0)
          return false;
        var protocol = url.substr(0, colon);
        switch (protocol) {
          case 'http':
          case 'https':
          case 'ftp':
            return true;
          default:
            return false;
        }
      }

      var annotations = this.annotations || [];
      var i, n = annotations.length;
      var items = [];
      for (i = 0; i < n; ++i) {
        var annotationRef = annotations[i];
        var annotation = xref.fetch(annotationRef);
        if (!isDict(annotation))
          continue;
        var subtype = annotation.get('Subtype');
        if (!isName(subtype))
          continue;
        var rect = annotation.get('Rect');
        var topLeftCorner = this.rotatePoint(rect[0], rect[1]);
        var bottomRightCorner = this.rotatePoint(rect[2], rect[3]);

        var item = {};
        item.type = subtype.name;
        item.x = Math.min(topLeftCorner.x, bottomRightCorner.x);
        item.y = Math.min(topLeftCorner.y, bottomRightCorner.y);
        item.width = Math.abs(topLeftCorner.x - bottomRightCorner.x);
        item.height = Math.abs(topLeftCorner.y - bottomRightCorner.y);
        switch (subtype.name) {
          case 'Link':
            var a = annotation.get('A');
            if (a) {
              switch (a.get('S').name) {
                case 'URI':
                  var url = a.get('URI');
                  // TODO: pdf spec mentions urls can be relative to a Base
                  // entry in the dictionary.
                  if (!isValidUrl(url))
                    url = '';
                  item.url = url;
                  break;
                case 'GoTo':
                  item.dest = a.get('D');
                  break;
                default:
                  TODO('other link types');
              }
            } else if (annotation.has('Dest')) {
              // simple destination link
              var dest = annotation.get('Dest');
              item.dest = isName(dest) ? dest.name : dest;
            }
            break;
          case 'Widget':
            var fieldType = getInheritableProperty(annotation, 'FT');
            if (!isName(fieldType))
              break;
            item.fieldType = fieldType.name;
            // Building the full field name by collecting the field and
            // its ancestors 'T' properties and joining them using '.'.
            var fieldName = [];
            var namedItem = annotation, ref = annotationRef;
            while (namedItem) {
              var parent = namedItem.get('Parent');
              var parentRef = namedItem.getRaw('Parent');
              var name = namedItem.get('T');
              if (name) {
                fieldName.unshift(stringToPDFString(name));
              } else {
                // The field name is absent, that means more than one field
                // with the same name may exist. Replacing the empty name
                // with the '`' plus index in the parent's 'Kids' array.
                // This is not in the PDF spec but necessary to id the
                // the input controls.
                var kids = parent.get('Kids');
                var j, jj;
                for (j = 0, jj = kids.length; j < jj; j++) {
                  var kidRef = kids[j];
                  if (kidRef.num == ref.num && kidRef.gen == ref.gen)
                    break;
                }
                fieldName.unshift('`' + j);
              }
              namedItem = parent;
              ref = parentRef;
            }
            item.fullName = fieldName.join('.');
            var alternativeText = stringToPDFString(annotation.get('TU') || '');
            item.alternativeText = alternativeText;
            var da = getInheritableProperty(annotation, 'DA') || '';
            var m = /([\d\.]+)\sTf/.exec(da);
            if (m)
              item.fontSize = parseFloat(m[1]);
            item.textAlignment = getInheritableProperty(annotation, 'Q');
            item.flags = getInheritableProperty(annotation, 'Ff') || 0;
            break;
          case 'Text':
            var content = annotation.get('Contents');
            var title = annotation.get('T');
            item.content = stringToPDFString(content || '');
            item.title = stringToPDFString(title || '');
            item.name = annotation.get('Name').name;
            break;
          default:
            TODO('unimplemented annotation type: ' + subtype.name);
            break;
        }
        items.push(item);
      }
      return items;
    },
    startRendering: function Page_startRendering(ctx, callback, textLayer)  {
      var stats = this.stats;
      stats.time('Overall');
      // If there is no displayReadyPromise yet, then the operatorList was never
      // requested before. Make the request and create the promise.
      if (!this.displayReadyPromise) {
        this.pdf.startRendering(this);
        this.displayReadyPromise = new Promise();
      }

      // Once the operatorList and fonts are loaded, do the actual rendering.
      this.displayReadyPromise.then(
        function pageDisplayReadyPromise() {
          var gfx = new CanvasGraphics(ctx, this.objs, textLayer);
          try {
            this.display(gfx, callback);
          } catch (e) {
            if (callback)
              callback(e);
            else
              error(e);
          }
        }.bind(this),
        function pageDisplayReadPromiseError(reason) {
          if (callback)
            callback(reason);
          else
            error(reason);
        }
      );
    }
  };

  return Page;
})();

/**
 * The `PDFDocModel` holds all the data of the PDF file. Compared to the
 * `PDFDoc`, this one doesn't have any job management code.
 * Right now there exists one PDFDocModel on the main thread + one object
 * for each worker. If there is no worker support enabled, there are two
 * `PDFDocModel` objects on the main thread created.
 */
var PDFDocModel = (function PDFDocModelClosure() {
  function PDFDocModel(arg, callback) {
    if (isStream(arg))
      init.call(this, arg);
    else if (isArrayBuffer(arg))
      init.call(this, new Stream(arg));
    else
      error('PDFDocModel: Unknown argument type');
  }

  function init(stream) {
    assertWellFormed(stream.length > 0, 'stream must have data');
    this.stream = stream;
    this.setup();
    this.acroForm = this.catalog.catDict.get('AcroForm');
  }

  function find(stream, needle, limit, backwards) {
    var pos = stream.pos;
    var end = stream.end;
    var str = '';
    if (pos + limit > end)
      limit = end - pos;
    for (var n = 0; n < limit; ++n)
      str += stream.getChar();
    stream.pos = pos;
    var index = backwards ? str.lastIndexOf(needle) : str.indexOf(needle);
    if (index == -1)
      return false; /* not found */
    stream.pos += index;
    return true; /* found */
  }

  PDFDocModel.prototype = {
    get linearization() {
      var length = this.stream.length;
      var linearization = false;
      if (length) {
        linearization = new Linearization(this.stream);
        if (linearization.length != length)
          linearization = false;
      }
      // shadow the prototype getter with a data property
      return shadow(this, 'linearization', linearization);
    },
    get startXRef() {
      var stream = this.stream;
      var startXRef = 0;
      var linearization = this.linearization;
      if (linearization) {
        // Find end of first obj.
        stream.reset();
        if (find(stream, 'endobj', 1024))
          startXRef = stream.pos + 6;
      } else {
        // Find startxref by jumping backward from the end of the file.
        var step = 1024;
        var found = false, pos = stream.end;
        while (!found && pos > 0) {
          pos -= step - 'startxref'.length;
          if (pos < 0)
            pos = 0;
          stream.pos = pos;
          found = find(stream, 'startxref', step, true);
        }
        if (found) {
          stream.skip(9);
          var ch;
          do {
            ch = stream.getChar();
          } while (Lexer.isSpace(ch));
          var str = '';
          while ((ch - '0') <= 9) {
            str += ch;
            ch = stream.getChar();
          }
          startXRef = parseInt(str, 10);
          if (isNaN(startXRef))
            startXRef = 0;
        }
      }
      // shadow the prototype getter with a data property
      return shadow(this, 'startXRef', startXRef);
    },
    get mainXRefEntriesOffset() {
      var mainXRefEntriesOffset = 0;
      var linearization = this.linearization;
      if (linearization)
        mainXRefEntriesOffset = linearization.mainXRefEntriesOffset;
      // shadow the prototype getter with a data property
      return shadow(this, 'mainXRefEntriesOffset', mainXRefEntriesOffset);
    },
    // Find the header, remove leading garbage and setup the stream
    // starting from the header.
    checkHeader: function PDFDocModel_checkHeader() {
      var stream = this.stream;
      stream.reset();
      if (find(stream, '%PDF-', 1024)) {
        // Found the header, trim off any garbage before it.
        stream.moveStart();
        return;
      }
      // May not be a PDF file, continue anyway.
    },
    setup: function PDFDocModel_setup(ownerPassword, userPassword) {
      this.checkHeader();
      var xref = new XRef(this.stream,
                          this.startXRef,
                          this.mainXRefEntriesOffset);
      this.xref = xref;
      this.catalog = new Catalog(xref);
    },
    get numPages() {
      var linearization = this.linearization;
      var num = linearization ? linearization.numPages : this.catalog.numPages;
      // shadow the prototype getter
      return shadow(this, 'numPages', num);
    },
    getDocumentInfo: function PDFDocModel_getDocumentInfo() {
      var info;
      if (this.xref.trailer.has('Info')) {
        var infoDict = this.xref.trailer.get('Info');

        info = {};
        infoDict.forEach(function(key, value) {
          info[key] = typeof value !== 'string' ? value :
            stringToPDFString(value);
        });
      }

      return shadow(this, 'getDocumentInfo', info);
    },
    getFingerprint: function PDFDocModel_getFingerprint() {
      var xref = this.xref, fileID;
      if (xref.trailer.has('ID')) {
        fileID = '';
        var id = xref.trailer.get('ID')[0];
        id.split('').forEach(function(el) {
          fileID += Number(el.charCodeAt(0)).toString(16);
        });
      } else {
        // If we got no fileID, then we generate one,
        // from the first 100 bytes of PDF
        var data = this.stream.bytes.subarray(0, 100);
        var hash = calculateMD5(data, 0, data.length);
        fileID = '';
        for (var i = 0, length = hash.length; i < length; i++) {
          fileID += Number(hash[i]).toString(16);
        }
      }

      return shadow(this, 'getFingerprint', fileID);
    },
    getPage: function PDFDocModel_getPage(n) {
      return this.catalog.getPage(n);
    }
  };

  return PDFDocModel;
})();

var PDFDoc = (function PDFDocClosure() {
  function PDFDoc(arg, callback) {
    var stream = null;
    var data = null;

    if (isStream(arg)) {
      stream = arg;
      data = arg.bytes;
    } else if (isArrayBuffer(arg)) {
      stream = new Stream(arg);
      data = arg;
    } else {
      error('PDFDoc: Unknown argument type');
    }

    this.data = data;
    this.stream = stream;
    this.pdfModel = new PDFDocModel(stream);
    this.fingerprint = this.pdfModel.getFingerprint();
    this.info = this.pdfModel.getDocumentInfo();
    this.catalog = this.pdfModel.catalog;
    this.objs = new PDFObjects();

    this.pageCache = [];
    this.fontsLoading = {};
    this.workerReadyPromise = new Promise('workerReady');

    // If worker support isn't disabled explicit and the browser has worker
    // support, create a new web worker and test if it/the browser fullfills
    // all requirements to run parts of pdf.js in a web worker.
    // Right now, the requirement is, that an Uint8Array is still an Uint8Array
    // as it arrives on the worker. Chrome added this with version 15.
    if (!globalScope.PDFJS.disableWorker && typeof Worker !== 'undefined') {
      var workerSrc = PDFJS.workerSrc;
      if (typeof workerSrc === 'undefined') {
        error('No PDFJS.workerSrc specified');
      }

      try {
        var worker;
        if (PDFJS.isFirefoxExtension) {
          // The firefox extension can't load the worker from the resource://
          // url so we have to inline the script and then use the blob loader.
          var bb = new MozBlobBuilder();
          bb.append(document.querySelector('#PDFJS_SCRIPT_TAG').textContent);
          var blobUrl = window.URL.createObjectURL(bb.getBlob());
          worker = new Worker(blobUrl);
        } else {
          // Some versions of FF can't create a worker on localhost, see:
          // https://bugzilla.mozilla.org/show_bug.cgi?id=683280
          worker = new Worker(workerSrc);
        }

        var messageHandler = new MessageHandler('main', worker);

        messageHandler.on('test', function pdfDocTest(supportTypedArray) {
          if (supportTypedArray) {
            this.worker = worker;
            this.setupMessageHandler(messageHandler);
          } else {
            globalScope.PDFJS.disableWorker = true;
            this.setupFakeWorker();
          }
        }.bind(this));

        var testObj = new Uint8Array(1);
        // Some versions of Opera throw a DATA_CLONE_ERR on
        // serializing the typed array.
        messageHandler.send('test', testObj);
        return;
      } catch (e) {
        warn('The worker has been disabled.');
      }
    }
    // Either workers are disabled, not supported or have thrown an exception.
    // Thus, we fallback to a faked worker.
    globalScope.PDFJS.disableWorker = true;
    this.setupFakeWorker();
  }

  PDFDoc.prototype = {
    setupFakeWorker: function PDFDoc_setupFakeWorker() {
      // If we don't use a worker, just post/sendMessage to the main thread.
      var fakeWorker = {
        postMessage: function PDFDoc_postMessage(obj) {
          fakeWorker.onmessage({data: obj});
        },
        terminate: function PDFDoc_terminate() {}
      };

      var messageHandler = new MessageHandler('main', fakeWorker);
      this.setupMessageHandler(messageHandler);

      // If the main thread is our worker, setup the handling for the messages
      // the main thread sends to it self.
      WorkerMessageHandler.setup(messageHandler);
    },


    setupMessageHandler: function PDFDoc_setupMessageHandler(messageHandler) {
      this.messageHandler = messageHandler;

      messageHandler.on('page', function pdfDocPage(data) {
        var pageNum = data.pageNum;
        var page = this.pageCache[pageNum];
        var depFonts = data.depFonts;

        page.stats.timeEnd('Page Request');
        page.startRenderingFromOperatorList(data.operatorList, depFonts);
      }, this);

      messageHandler.on('obj', function pdfDocObj(data) {
        var id = data[0];
        var type = data[1];

        switch (type) {
          case 'JpegStream':
            var imageData = data[2];
            loadJpegStream(id, imageData, this.objs);
            break;
          case 'Image':
            var imageData = data[2];
            this.objs.resolve(id, imageData);
            break;
          case 'Font':
            var name = data[2];
            var file = data[3];
            var properties = data[4];

            if (file) {
              // Rewrap the ArrayBuffer in a stream.
              var fontFileDict = new Dict();
              file = new Stream(file, 0, file.length, fontFileDict);
            }

            // At this point, only the font object is created but the font is
            // not yet attached to the DOM. This is done in `FontLoader.bind`.
            var font = new Font(name, file, properties);
            this.objs.resolve(id, font);
            break;
          default:
            error('Got unkown object type ' + type);
        }
      }, this);

      messageHandler.on('page_error', function pdfDocError(data) {
        var page = this.pageCache[data.pageNum];
        if (page.displayReadyPromise)
          page.displayReadyPromise.reject(data.error);
        else
          error(data.error);
      }, this);

      messageHandler.on('jpeg_decode', function(data, promise) {
        var imageData = data[0];
        var components = data[1];
        if (components != 3 && components != 1)
          error('Only 3 component or 1 component can be returned');

        var img = new Image();
        img.onload = (function messageHandler_onloadClosure() {
          var width = img.width;
          var height = img.height;
          var size = width * height;
          var rgbaLength = size * 4;
          var buf = new Uint8Array(size * components);
          var tmpCanvas = createScratchCanvas(width, height);
          var tmpCtx = tmpCanvas.getContext('2d');
          tmpCtx.drawImage(img, 0, 0);
          var data = tmpCtx.getImageData(0, 0, width, height).data;

          if (components == 3) {
            for (var i = 0, j = 0; i < rgbaLength; i += 4, j += 3) {
              buf[j] = data[i];
              buf[j + 1] = data[i + 1];
              buf[j + 2] = data[i + 2];
            }
          } else if (components == 1) {
            for (var i = 0, j = 0; i < rgbaLength; i += 4, j++) {
              buf[j] = data[i];
            }
          }
          promise.resolve({ data: buf, width: width, height: height});
        }).bind(this);
        var src = 'data:image/jpeg;base64,' + window.btoa(imageData);
        img.src = src;
      });

      setTimeout(function pdfDocFontReadySetTimeout() {
        messageHandler.send('doc', this.data);
        this.workerReadyPromise.resolve(true);
      }.bind(this));
    },

    get numPages() {
      return this.pdfModel.numPages;
    },

    startRendering: function PDFDoc_startRendering(page) {
      // The worker might not be ready to receive the page request yet.
      this.workerReadyPromise.then(function pdfDocStartRenderingThen() {
        page.stats.time('Page Request');
        this.messageHandler.send('page_request', page.pageNumber + 1);
      }.bind(this));
    },

    getPage: function PDFDoc_getPage(n) {
      if (this.pageCache[n])
        return this.pageCache[n];

      var page = this.pdfModel.getPage(n);
      // Add a reference to the objects such that Page can forward the reference
      // to the CanvasGraphics and so on.
      page.objs = this.objs;
      page.pdf = this;
      return (this.pageCache[n] = page);
    },

    destroy: function PDFDoc_destroy() {
      if (this.worker)
        this.worker.terminate();

      if (this.fontWorker)
        this.fontWorker.terminate();

      for (var n in this.pageCache)
        delete this.pageCache[n];

      delete this.data;
      delete this.stream;
      delete this.pdf;
      delete this.catalog;
    }
  };

  return PDFDoc;
})();

globalScope.PDFJS.PDFDoc = PDFDoc;

