<?php 
/**
 * thmplt Functions and definitions
 *
 */

global $thmplt;

// Default value for "nosidebar" 
// Sidebar is on by default
$thmplt['nosidebar'] = false;




/**
 * enque and load the JS and CSS files into the framework
 */
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Load the parent style and theme style into thmplt framework 
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );

	// Load the main thmplt JS file
	wp_enqueue_script( 'thmplt_js', 
		get_template_directory_uri() . "/js/thmplt.js", array('jquery', 'jquery-migrate') );



	wp_enqueue_script('bootsrap_js',
		get_template_directory_uri() . "/bootstrap/js/bootstrap.min.js", array('jquery','jquery-migrate') );

}





/**
 * Custom menu walker for bootstrap
 *
 */
require_once( TEMPLATEPATH . '/php/wp_bootstrap_navwalker.php');


/**
 * include other functions needed to run the site
 * Best if left as the last code in this file 
 */
 require_once ( TEMPLATEPATH . "/thmplt/functions.php" );