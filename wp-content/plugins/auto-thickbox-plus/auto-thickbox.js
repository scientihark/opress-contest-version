/*
 * JavaScript for Auto ThickBox Plus
 * Copyright (C) 2010-2012 attosoft <http://attosoft.info/en/>
 * This file is distributed under the same license as the Auto ThickBox Plus package.
 * attosoft <contact@attosoft.info>, 2012.
 */

jQuery(function($) {
	postboxes.add_postbox_toggles("auto-thickbox-options");

	$(".colorpicker").each(function() {
		var text = $(this).prevAll("input:text");
		var checkbox = $(this).nextAll("label").children("input:checkbox");
		var preview = $(this).prevAll(".colorpreview");
		var fb = $.farbtastic(this, function(color) {
			text.val(color);
			preview.css("backgroundColor", color);
			text.filter(":disabled").removeAttr("disabled");
			checkbox.filter(":checked").removeAttr("checked");
		});
		if (text.val()[0] == '#') fb.setColor(text.val()); // color in hex
		else preview.css("backgroundColor", text.val());
	});
	$(".pickcolor").click(function() { $(this).nextAll(".colorpicker").show(); return false; });
	$(document).mousedown(function() { $(".colorpicker:visible").hide(); });

	if ($.isFunction($().slider)) {
		$(".opacity-slider").each(function() {
			var text = $(this).prevAll("input:text");
			$(this).slider({
				max: 1,
				step: 0.05,
				value: text.val(),
				slide: function(event, ui) { text.val(ui.value); },
				change: function(event, ui) { text.val(ui.value); }
			});
		});
		$(".opacity-trans").click(function() { $(this).next(".opacity-slider").slider("value", 0); });
		$(".opacity-opaque").click(function() { $(this).prev(".opacity-slider").slider("value", 1); });

		$("#click-range-slider").slider({
			max: 50,
			step: 5,
			value: $("#click-range").val(),
			slide: function(event, ui) { $("#click-range").val(ui.value); },
			change: function(event, ui) { $("#click-range").val(ui.value); },
			disabled: $("#click-range:disabled").length > 0
		});
	}

	$("ol.sortable").sortable({
		placeholder: "sortable-placeholder",
		helper: "clone",
		opacity: 0.65,
		update: function(event, ui) { $(this).prev("input:hidden").val("'" + $(this).sortable("toArray").join("','") + "'"); }
	});
	if ($.isFunction($().disableSelection))
		$("ol.sortable").disableSelection();

	$(".media-uploader").each(function() {
		var text = $(this).prevAll("input:text");
		var checkbox = $(this).nextAll("label").children("input:checkbox");
		$(this).click(function() {
			formfield = text.attr('name');
			tb_show(this.value, 'media-upload.php?type=image&post_id=0&TB_iframe=true');
			window.send_to_editor = function(html) {
				imgurl = $('img', html).attr('src') || $(html).attr('src'); // type/library or type_url
				text.val(imgurl);
				tb_remove();
				text.filter(":disabled").removeAttr("disabled");
				checkbox.filter(":checked").removeAttr("checked");
			}
			return false;
		});
	});
});

function updateEffectSpeed(radio) {
	var text = document.form[radio.name][document.form[radio.name].length - 1]
	text.disabled = radio.value != "number";
	switch (radio.value) {
		case "fast": text.value = "200"; break;
		case "normal": text.value = "400"; break;
		case "slow": text.value = "600"; break;
	}
}

function disableClickOption(radio) {
	var disabled = radio.value == "close" || radio.value == "none";
	for (var i = 0; i < document.form['auto-thickbox-plus[click_end]'].length; i++)
		document.form['auto-thickbox-plus[click_end]'][i].disabled = disabled;

	disabled = radio.value != "prev_next";
	document.form['auto-thickbox-plus[click_range]'].disabled = disabled;
	if (jQuery.isFunction(jQuery().slider))
		jQuery("#click-range-slider").slider("option", "disabled", disabled);
}

function disableOption(checkbox) {
	document.form[checkbox.name][0].disabled = checkbox.checked;
}
