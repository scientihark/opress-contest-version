
function padd_admintabs_init() {
	if (!jQuery("#padd-admin-tabs").length) {
		return;
	}

	var jQversion = undefined == jQuery.ui ? [0,0,0] : undefined == jQuery.ui.version ? [0,1,0] : jQuery.ui.version.split('.');
	switch(true) {
		case jQversion[0] >= 1 && jQversion[1] >= 7:
			jQuery("#padd-admin-tabs").tabs({ cookie: { expires: 30 } });
			break;
		default:
			jQuery("#padd-admin-tabs > ul").tabs({ cookie: { expires: 30 } });
	}
}

jQuery(document).ready(function() {
	padd_admintabs_init();
});
