
<?php
/*
Template Name: 404 Error
*/
?>
<?php get_header(); ?>

<div id="content" class="content-singular content-page">
	<div class="pad">

<div id="post-0" class="hentry error404 not-found">
	<?php 
		if (function_exists('bcn_display')) { 
			echo '<p class="breadcrumb">';
			bcn_display(); 
			echo '</p>';
		} 
	?>	
	<div class="title">
		<h1>Not Found</h1>
	</div>
	<div class="content">
		<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>
	</div>
</div>

	</div>
</div>

<?php get_sidebar(); ?>

<div class="padd-clear"></div>

<?php get_footer(); ?>
