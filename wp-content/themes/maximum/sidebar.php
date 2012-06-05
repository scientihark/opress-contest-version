<div id="sidebar">
<?php if ( is_page() ) {
    if($post->post_parent)
    $children = wp_list_pages('sort_column=menu_order&title_li=&child_of='.$post->post_parent.'&echo=0');
	else
    $children = wp_list_pages('sort_column=menu_order&title_li=&child_of='.$post->ID.'&echo=0');
    if ($children) { ?>
<div class="sidebar-row page-navi">
	<ul>
	<?php echo $children; ?>
	</ul>
</div>
<?php } // End If Post
} // End if is page
?>
<div class="sidebar-row page-navi">
<h3>Consectetur Adipisicing:</h3>
<p>The API will generate the necessary CSS specific to the user's browser so you can use the font on your page.</p>
</div><!--blue-->

<div class="sidebar-row grey">
<h3>Categories:</h3>
<ul>
<?php wp_list_categories(array('title_li'=>__(''), 'style'=>'list', 'hierarchical'=>true, 'depth'=>0, ));?>
</ul>
</div><!--sidebar-row-->
 



<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Left Sidebar") ) : ?>
<?php endif; ?>

</div><!--sidebar-->