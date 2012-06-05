
<table class="form-table post-table">
<?php
	foreach ($padd_meta_boxes as $opt) {
		$opt->set_value(get_post_meta($post->ID,$opt->get_keyword(), true));
		echo $opt;
	}
?>
</table>
