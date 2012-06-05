<?php
/*
Plugin Name: Ajax Widget Area
Plugin URI: http://www.chrishilditch.co.uk  
Description: This plugin creates a new 'Ajax Widget Area'. The widget loads the widgets placed in the Area with AJAX, after the page load.
Version: 0.7
Author: Chris Hilditch (@chrishilditch)
Author URI: http://www.chrishilditch.co.uk
License: GPLv2 or later
*/
  
// TODO - add desktop / mobile / bot options.
// TODO - add option for loading text.
    
/*
 *   Add the ajax widget area
 */
function ajaxWidgetsArea_widgetAreaInit() {
	register_sidebar( array(
		'name' => __( 'Ajax Widget Area', 'ajax_widgets' ),
		'id' => 'ajax-widget-area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'ajaxWidgetsArea_widgetAreaInit' );


/*
 *   Ajax widget control
 */
function ajaxWidgetArea_widgetControl () {
    echo '<div>The widget loads the widgets placed in the \'Ajax Widget Area\' with AJAX, after the page has loaded</div>';
}
wp_register_widget_control( 'ajaxWidgetArea', 'Ajax Widget Area', 'ajaxWidgetArea_widgetControl', null, 'ajax-widget-area');


/*
 *   Ajax widget
 */
function ajaxWidgetArea_widgetDisplay () {
    echo '<div id="ajaxSidebar"><center><img src="http://ise.scie.in/img/loader.gif"></center></div>';
    ?>
    <script type="text/javascript" >
    jQuery(document).ready(function($) {
        var data = {
            action: 'get_ajax_sidebar'
        };
        jQuery.post('<?php echo admin_url( 'admin-ajax.php' )?>', data, function(response) {
            $('#ajaxSidebar').html(response);
        });
    });
    </script>
<?php
}
wp_register_sidebar_widget( 'ajaxWidgetArea', 'Ajax Widget Area', 'ajaxWidgetArea_widgetDisplay', null, 'ajax-widget-area');

/*
 *   Ajax response
 */
function ajaxWidgetArea_ajaxResponse() {
    dynamic_sidebar( 'ajax-widget-area' ); 
	die(); 
}
add_action('wp_ajax_get_ajax_sidebar', 'ajaxWidgetArea_ajaxResponse');
add_action('wp_ajax_nopriv_get_ajax_sidebar', 'ajaxWidgetArea_ajaxResponse');


/*
 *   Ensure jQuery is loaded on the page.
 */
function ajaxWidgetArea_addJQuery(){
    wp_enqueue_script("jquery");
}
add_action('get_header', 'ajaxWidgetArea_addJQuery');



