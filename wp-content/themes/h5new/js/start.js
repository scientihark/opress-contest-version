$(function() {
var isStarted = $.cookie("started");
if(isStarted){
$(".startbg").css("marginTop",-1*$("body").height());
$(".page").show();
$("body").css("height","auto");
$(".startbg").css("display","none");
}else{
$(".startbg").show();
}
$(".startbtn").click(function(){
$(".startbg").animate({
marginTop: -1 * $("body").height()
},500,function(){
if(!isStarted){
 $.cookie("started", "1", {expires:7, path:"/"});

}
$(".startbg").hide();
$(".page").fadeIn();
$("body").css("height","auto");
});
});


$("#backtotop").hide();
$(function () {
    $(window).scroll(function () {
    if ($(this).scrollTop() > 80) {
	$('#backtotop').fadeIn();
    } else {
	$('#backtotop').fadeOut();
    }
});

		// scroll body to 0px on click
$('#backtotop a').click(function () {
    $('body,html').animate({
		    scrollTop: 0
		    }, 800);
    return false;
    });
});
jQuery('.thumbnail img').hover(
function() {jQuery(this).fadeTo("fast", 0.5);},
function() {jQuery(this).fadeTo("fast", 1);
});

});
