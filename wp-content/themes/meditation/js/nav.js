var basePath = '/';
var rtl = false;
jQuery.browser.msie6 = (jQuery.browser.msie && jQuery.browser.version <= 6);
if (jQuery.cookie("font-size")) {
  document.write('<style type="text/css" media="all">');
  document.write('.page .storycontent,.single .storycontent {font-size: ' + jQuery.cookie("font-size") + ';}');
  document.write('</style>');
}

jQuery(document).ready(function($) {
  basePath = $("link").attr("href").replace(/https?:\/\/[^\/]+/, '').replace(/wp-content\/.*/, '');
  if ($("html").attr("dir") == 'rtl') {
    rtl = true;
  }
  setGuide();
  $(window).bind("scroll resize", setGuide);
  $("#nav ul ul ul").each(function() {
    $(this).css('margin-left', $(this).parent().parent().width());
  });
  $("div.zoom a").dblclick(function() {
    $(this).blur();
    return false;
  });
  $(".font-large").click(function() {
    var size = $.cookie("font-size");
    if (size) {
      size = parseInt(size);
      if (size < 16) {
        size += 1;
      }
    } else {
      size = 15;
    }
    zoomFont(size + "px");
    return false;
  });
  $(".font-normal").click(function() {
    zoomFont("13px");
    return false;
  });
  $(".font-small").click(function() {
    var size = $.cookie("font-size");
    if (size) {
      size = parseInt(size);
      if (size > 11) {
        size -= 1;
      }
    } else {
      size = 11;
    }
    zoomFont(size + "px");
    return false;
  });
  $(document).keyup(function(e) {
    //alert(e.keyCode);
    if (e.ctrlKey && e.shiftKey && e.altKey) {
      var url;
      if (e.keyCode == 76) {
        // Login / logout
        url = $("#guide li.login a").attr("href");
      }
      if (e.keyCode == 82) {
        // Register
        url = $("#guide li.register a").attr("href");
      }
      if (e.keyCode == 65) {
        // Admin
        url = $("#guide li.admin a").attr("href");
      }
      if (e.keyCode == 70) {
        // Feed
        url = $("#guide li.feed a").attr("href");
      }
      if (e.keyCode == 80) {
        // Profile
        url = $("#guide a.profile").attr("href");
      }
      if (e.keyCode == 78) {
        // New post
        url = $("#guide li.new-post a").attr("href");
      }
      if (url) {
        location = url;
      }
    }
  });
  if ($.browser.msie) {
    $("#header a").attr("hideFocus", true);
    if ($.browser.msie6) {
      $("#nav li").mouseenter(function() {
        $(this).addClass("current-cat");
        $(this).children("ul").show();
      }).mouseleave(function() {
        $(this).removeClass("current-cat");
        $(this).children("ul").hide();
      });
    }
  }
});

function setGuide() {
  if (jQuery(window).width() < jQuery("#container").width()) {
    if (jQuery(window).width() > jQuery("#guide ul").attr("offsetWidth")) {
      if (rtl) {
        jQuery("#guide").width(jQuery(window).width() - jQuery(window).scrollLeft());
      } else {
        jQuery("#guide").width(jQuery(window).width() + jQuery(window).scrollLeft());
      }
    }
  } else {
    if (jQuery("#guide").width() != jQuery("#container").width()) {
      jQuery("#guide").width(jQuery("#container").width());
    }
  }
}

function zoomFont(size) {
  jQuery(".storycontent").css("font-size", size);
  jQuery.cookie("font-size", size, {expires: 365, path: basePath});
}