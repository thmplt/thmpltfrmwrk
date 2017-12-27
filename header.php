<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 */
global $thmplt;
global $post;

set_the_proper_page_id(); 

//echo $thmplt['pageID'];

// Get the options for the theme   
$thmplt_options = get_option('thmplt_options'); 
 
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	
    <meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>


	<?php 
	// If we have posts from the blog then display feed and pingback info
	$count_posts = wp_count_posts();
	if ( $count_posts->publish >=1 ) { 
		echo "<!-- Blog/Page feed --> \n";
		echo "<link rel='alternate' type='application/rss+xml' title='".get_bloginfo('name')." RSS Feed' href='".get_bloginfo('rss2_url')."' /> \n";
		echo "<link rel='pingback' href='".get_bloginfo('pingback_url')."' /> \n \n";
	} 
	?>
        
	<link rel="profile" href="http://gmpg.org/xfn/11">


	<?php if ( empty($thmplt_options['bootstrap']) || $thmplt_options['bootstrap'] == "on" ) {  
	
			if ($thmplt_options['bootstrapver'] == "4" ) { 

				echo "<!-- Bootstrap 4 --> \n";
				echo "<link type='text/css' rel='stylesheet' href='".get_bloginfo('template_url')."/bootstrap4/css/bootstrap.min.css' /> \n";
				
				wp_enqueue_script('bootsrap_js', get_template_directory_uri() . "/bootstrap4/js/bootstrap.min.js", array('jquery','jquery-migrate') );
				

			}else{

				echo "<!-- Bootstrap 3 --> \n";
				echo "<link type='text/css' rel='stylesheet' href='".get_bloginfo('template_url')."/bootstrap/css/bootstrap.min.css' /> \n";
				wp_enqueue_script('bootsrap_js', get_template_directory_uri() . "/bootstrap/js/bootstrap.min.js", array('jquery','jquery-migrate') );

			}
		} 
	?>
    
	<?php if ( !empty($thmplt_options['fonts']) && $thmplt_options['fonts'] == "off" ) { 
			/**
			 * If we want to remove the fonts from the admin options
			 */
			remove_action("wp_print_styles", "thmplt_fonts");
			remove_action("wp_print_styles", "thmplt_do_registered_font");		
    } ?>    


	<?php 
	$bclasess = get_body_class(); 
    if ( in_array('ie6',$bclasess) || in_array('ie7',$bclasess) || in_array('ie8',$bclasess) || in_array('ie9',$bclasess) ) { 

		function thmplt_ie_html5_scripts(){
			echo "<!-- IE SCRIPTS START --> \n";
			wp_register_script( 'ie-html5-js',esc_url( get_template_directory_uri() ) . '/js/my-script.js' );			
			wp_register_script( 'ie-respond-js', esc_url( get_template_directory_uri() ) . '/js/my-script.js' );						
			wp_enqueue_script('ie-html5-js',esc_url( get_template_directory_uri() )."/js/html5.js" );
			wp_enqueue_script('ie-respond-js', esc_url( get_template_directory_uri() )."/js/respond.min.js" );
			echo "<!-- IE SCRIPTS END --> \n";
		}

		add_action('wp_enqueue_scripts','thmplt_ie_html5_scripts');
	} 
	
    if ( in_array('ie6',$bclasess) || in_array('ie7',$bclasess) ) { 

		function thmplt_ie_bootstrap_scripts(){
			wp_enqueue_style('ie-bootstrap', esc_url( get_template_directory_uri() )."/bootstrap-ie-help/bootstrap-ie7.css" );
		}

		add_action('wp_enqueue_scripts','thmplt_ie_bootstrap_scripts');
	} 	
	
	?>
    
	<script>(function(){document.documentElement.className='js'})();</script>

	<?php 
    /**
     * load extra header.php code/html here 
	 * Backwards compatible. Will remove in future versions... stop using!! 
     */
    locate_template('/structure/assets.php', true); 
	
    /**
     * load extra header.php code/html here 
     */
    locate_template('/structure/head.php', true);     
    ?>

    
	<?php wp_head(); ?>

	<?php 
        if ( thmplt_favicon_url() ) { 
            echo "<link rel='shortcut icon' href='".thmplt_favicon_url()."' />";						
        }
    ?>
    
</head>

<body <?php body_class(); ?>>


<!-- Beginning of page --> 
<div class='pagewrapper'>

<?php do_action('thmplt_before_main_header'); ?>
<?php 
/**
 * load extra header.php code/html here 
 */
locate_template('/structure/header.php', true); 

/**
 * Set the ID of the main content area, which is overwrittable by 
 * the main_section_id key in the $thmplt global array 
 */
$main_content_id = empty($thmplt['main_section_id']) ? "main_content" : $thmplt['main_section_id'];

do_action('thmplt_before_main_section'); ?>
<div id='<?php echo $main_content_id; ?>' class='wrapper pcolor-main'><div class='container'><div class='content row'>
<?php do_action('thmplt_main_section_start'); ?>