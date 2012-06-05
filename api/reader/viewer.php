<?php 
include( "conf.php" );
if(empty($_GET['url']))
{
	if(!empty($_GET['id']))
	{
		$nowfileid=$_GET['id'];
	}
	else
	{
		$nowfileid=0;
	}
	include( "pdffiles.php" );
	$nowfile=pdffile($nowfileid);
}
else
{
	include( "getfile.php" );
	$or_file_path=getfile($_GET['url']);
	//echo "<!--geturl".$_GET['url']."!-->";
	$or_file_name='From url';
	$or_file_typename='From url';
	$or_file_uploader='From url';
	$or_file_locked=0;
	$or_file_pass='0';
	$or_file_des='From  '.$_GET['url'];

$or_return_value->filepath=$or_file_path;
$or_return_value->filename=$or_file_name;
$or_return_value->filetypename=$or_file_typename;
$or_return_value->fileuploader=$or_file_uploader;
$or_return_value->fileislocked=$or_file_locked;
$or_return_value->filepass=$or_file_pass;
$or_return_value->filedes=$or_file_des;
$nowfile=$or_return_value;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo "<title>OReader -".$or_version."</title>"; ?>
        <!-- PDFJSSCRIPT_INCLUDE_FIREFOX_EXTENSION -->
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <link rel="stylesheet" href="viewer.css"/>
<?php echo "<script type=\"text/javascript\"> var kDefaultURL = '".$nowfile->filepath."';</script>"; ?>
<?php echo "<!--1".$nowfile->filepath."!-->"; ?>
<?php echo "<!--2".$nowfile->filetypename."!-->"; ?>
<?php echo "<!--3".$nowfile->fileuploader."!-->"; ?>
<?php echo "<!--4".$nowfile->fileislocked."!-->"; ?>
<?php echo "<!--5".$nowfile->filepass."!-->"; ?>
<?php echo "<!--6".$nowfile->filedes."!-->"; ?>
        <script type="text/javascript" src="compatibility.js"></script> <!-- PDFJSSCRIPT_REMOVE_FIREFOX_EXTENSION -->

        <!-- PDFJSSCRIPT_INCLUDE_BUILD -->
        <script type="text/javascript" src="src/core.js"></script> <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/util.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/metadata.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/canvas.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/obj.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/function.js"></script> <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/charsets.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/cidmaps.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/colorspace.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/crypto.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/evaluator.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/fonts.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/glyphlist.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/image.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/metrics.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/parser.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/pattern.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/stream.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/worker.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/jpg.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/jpx.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="src/bidi.js"></script>  <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript">PDFJS.workerSrc = 'src/worker_loader.js';</script> <!-- PDFJSSCRIPT_REMOVE_CORE -->
        <script type="text/javascript" src="debugger.js"></script>
        <script type="text/javascript" src="viewer.js"></script>

    </head>

  <body>
    <div id="controls">
      <button id="previous" onclick="PDFView.page--;" oncontextmenu="return false;">
        <img src="images/go-up.svg" align="top" height="16"/>
        上一页
      </button>

      <button id="next" onclick="PDFView.page++;" oncontextmenu="return false;">
        <img src="images/go-down.svg" align="top" height="16"/>
        下一页
      </button>

      <div class="separator"></div>

      <input type="number" id="pageNumber" onchange="PDFView.page = this.value;" value="1" size="4" min="1" />

      <span>/</span>
      <span id="numPages">--</span>

      <div class="separator"></div>

      <button id="zoomOut" title="Zoom Out" onclick="PDFView.zoomOut();" oncontextmenu="return false;">
        <img src="images/zoom-out.svg" align="top" height="16"/>
      </button>
      <button id="zoomIn" title="Zoom In" onclick="PDFView.zoomIn();" oncontextmenu="return false;">
        <img src="images/zoom-in.svg" align="top" height="16"/>
      </button>

      <div class="separator"></div>

      <select id="scaleSelect" onchange="PDFView.parseScale(this.value);" oncontextmenu="return false;">
        <option id="customScaleOption" value="custom"></option>
        <option value="0.5">50%</option>
        <option value="0.75">75%</option>
        <option value="1">100%</option>
        <option value="1.25">125%</option>
        <option value="1.5">150%</option>
        <option value="2">200%</option>
        <option id="pageWidthOption" value="page-width">页面宽度适应</option>
        <option id="pageFitOption" value="page-fit">适应纸张大小</option>
        <option id="pageAutoOption" value="auto" selected="selected">页面自适应</option>
      </select>

      <div class="separator"></div>

      <button id="print" onclick="window.print();" oncontextmenu="return false;">
        <img src="images/document-print.svg" align="top" height="16"/>
        打印
      </button>

      <button id="download" title="下载" onclick="PDFView.download();" oncontextmenu="return false;">
        <img src="images/download.svg" align="top" height="16"/>
        下载
      </button>

      <div class="separator"></div>

      <input id="fileInput" type="file" oncontextmenu="return false;"/>

      <div id="fileInputSeperator" class="separator"></div>

      <a href="#" id="viewBookmark" title="书签-保存当前位置">
        <img src="images/bookmark.svg" alt="Bookmark" align="top" height="16"/>
      </a>

    </div>
    <div id="errorWrapper" hidden='true'>
      <div id="errorMessageLeft">
        <span id="errorMessage"></span>
        <button id="errorShowMore" onclick="" oncontextmenu="return false;">
          更多信息
        </button>
        <button id="errorShowLess" onclick="" oncontextmenu="return false;" hidden='true'>
          较少信息
        </button>
      </div>
      <div id="errorMessageRight">
        <button id="errorClose" oncontextmenu="return false;">
          关闭
        </button>
      </div>
      <div class="clearBoth"></div>
      <textarea id="errorMoreInfo" hidden='true' readonly="readonly"></textarea>
    </div>

    <div id="sidebar">
      <div id="sidebarBox">
        <div id="pinIcon" onClick="PDFView.pinSidebar()"></div>
        <div id="sidebarScrollView">
          <div id="sidebarView"></div>
        </div>
        <div id="outlineScrollView" hidden='true'>
          <div id="outlineView"></div>
        </div>
        <div id="sidebarControls">
          <button id="thumbsSwitch" title="显示预览" onclick="PDFView.switchSidebarView('thumbs')" data-selected>
            <img src="images/nav-thumbs.svg" align="top" height="16" alt="Thumbs" />
          </button>
          <button id="outlineSwitch" title="显示目录" onclick="PDFView.switchSidebarView('outline')" disabled>
            <img src="images/nav-outline.svg" align="top" height="16" alt="Document Outline" />
          </button>
        </div>
      </div>
    </div>
<div id="sidebar_r">
      <div id="sidebarBox_r">
        <div class="sider_bar_r_text_Tittle"><center><b>OReader</b></center></div>
	<div class="sider_bar_r_text_cloum"><center><?php echo $or_version; ?></center></div>
	<div class="sider_bar_r_text_cloum"><br></br>文件名:<br></br><b><?php echo $nowfile->filename; ?></b></div>
	<div class="sider_bar_r_text_cloum"><br></br>文件类型:<br></br><b><?php echo $nowfile->filetypename; ?></b></div>
	<div class="sider_bar_r_text_cloum"><br></br>上传者:<br></br><b><?php echo $nowfile->fileuploader; ?></b></div>
	<div class="sider_bar_r_text_cloum"><br></br>说明:<br></br><b><?php echo $nowfile->filedes; ?></b></div>
	<center><br>=======================</br></center>
	<div class="sider_bar_r_text_footer" id="sidebar_footer"><center>Powered by <a href="http://apps.scie.in/oreader" target="_blank">OReader</a>(by <a href="http://blogs.scie.in/sciebtihark" target="_blank">Scientihark</a>)<br></br> and <a href="http://github.com/mozilla/pdf.js" target="_blank">Pdf.js</a> by <a href="http://www.mozilla.org" target="_blank">Mozilla</a><br></br> and <a href="http://jquery.com" target="_blank">JQuery</a> by John Resig<br></br> and jpg.js by notmasteryet<br></br>Licensed under GPL and MIT</center></div>
      </div>
    </div>
    <div id="loadingBox">
        <div id="loading">亲，读取中~~请稍后... 0%</div>
        <div id="loadingBar"><div class="progress"></div></div>
    </div>
    <div id="viewer"></div>
  </body>
</html>
