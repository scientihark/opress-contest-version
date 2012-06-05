
<div id="sidebar">
	<div class="pad">

		<h2>Sidebar</h2>

	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : ?>


<div class="box box-search">
	<div class="title">
		<h3>Search</h3>
	</div>
	<div class="interior">
		<?php get_search_form(); ?>
	</div>
</div>
	
<div class="box box-ads">
	<div class="title">
		<h3>Sponsors</h3>
	</div>
	<div class="interior">
		<?php padd_theme_widget_sponsors(); ?>
	</div>
</div>

<div class="box box-tabs">
	<div class="title">
		<h3>Tabs</h3>
	</div>
	<div class="interior">
		<?php padd_theme_widget_tabs(); ?>
	</div>
</div>

	<?php endif; ?>

	</div>
</div>


