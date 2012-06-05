
function paddAppendClear() {
	jQuery('.append-clear').append('<div class="clear"></div>');
}

function paddToggle(classname,value) {
	jQuery(classname).focus(function() {
		if (value == jQuery(classname).val()) {
			jQuery(this).val('');
		}
	});
	jQuery(classname).blur(function() {
		if ('' == jQuery(classname).val()) {
			jQuery(this).val(value);
		}
	});
}

function paddSidebarTabsInit() {
	if (!jQuery("#sidebar-tabs").length) {
		return;
	} else {
		jQuery("#sidebar-tabs").tabs({ cookie: { expires: 30 } });
	}
}

jQuery(window).load(function() {
	jQuery('#slideshow').nivoSlider({
		effect: 'sliceUpDown',
		animSpeed: 1000,
		pauseTime: 10000
	});
});

jQuery(document).ready(function() {
	jQuery.noConflict();
	
	jQuery('div#menubar div > ul li a[title="Home"]').prepend('<span></span>');
	jQuery('div#menubar div > ul li a[title="Home"] span').css({
		'float': 'left',
		'display': 'block',
		'width': '24px',
		'height': '40px'
	});
	jQuery('div#menubar div > ul').superfish({
		autoArrows: false,
		hoverClass: 'hover',
		speed: 500,
		animation: { opacity: 'show', height: 'show' }
	});
	jQuery('div#menubar div > ul ul li:last-child a').css('background','transparent none');

	paddAppendClear();
	
	jQuery('input#s').val('keywords here');
	paddToggle('input#s','keywords here');

	jQuery('div.search form').click(function () {
		jQuery('input#s').focus();
	});
	
	paddSidebarTabsInit();
});
