<?php
/**
 * Wp Conditional shortcodes 
 */
 

add_shortcode('show_on_page', 'thmplt_is_page');
add_shortcode('thmplt_show_on_page', 'thmplt_is_page');
add_shortcode('thmplt_is_page', 'thmplt_is_page');


/**
 * Checks if it's a page, page ID or not on a page 
 */
function thmplt_is_page($atts, $content = NULL ){

	global $post;
	
    $a = shortcode_atts( array(
        'pids' => '',
		'not' => '' 
    ), $atts );	
	
	$pids = !empty($a['pids']) ? explode(",", $a['pids']): NULL ;
	$not = !empty($a['not']) ? explode(",", $a['not']): NULL ;
	
	$is_pid = is_array($pids) ? is_page($pids) : is_page();
	$is_not_pid	= is_array($not) ? !is_page($not) : true;
	
	// if both it is on a page is true and it's not on a certain page is true
	if ( $is_pid && $is_not_pid ) {
			return do_shortcode($content);
	}
}