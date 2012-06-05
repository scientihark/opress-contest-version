jQuery(document).ready(function($) {
  var ta = jQuery("#comment");
  $("a.comment-reply-link").click(function() {
    if (ta) {
      var author = $(this).parent().parent().prev().children("p").text().trim();
      var str = '<strong>@' + author + '</strong>\n';
      ta.val(ta.val() + str);
      ta.focus();
    }
    return false;
  });
  $("a.comment-quote-link").click(function() {
    if (ta) {
      var author = $(this).parent().parent().prev().children("p").text().trim();
      var comment = $(this).parent().next(".comment-text").html().trim();
      comment = comment.replace(/<([^>]+)>/g, function($0, $1) {
        return '<' + $1.toLowerCase().replace(/^br$/, 'br /') + '>';
      });
      var str = '<blockquote><strong>' + author + ':</strong> ' + comment + '</blockquote>\n';
      ta.val(ta.val() + str);
      ta.focus();
    }
    return false;
  });
  bindComments();
});

function bindComments() {
  jQuery("#comments-content .paginate a").click(function() {
    var url = jQuery("link[rel=stylesheet]").attr("href").replace(/css\/screen\.css$/, '');
    var post_id = jQuery(".post").attr("id").replace(/^post-/, '');
    var cpage = jQuery(this).attr("href").replace(/#.*/, '').replace(/.*(\d+)$/, '$1');
    url += 'ajax.php?action=get_comments&post_id=' + post_id + '&cpage=' + cpage;
    jQuery("#comments-content").load(url, bindComments);
    return false;
  });
}