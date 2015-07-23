<?php 
/**
 * thmplt's common functions to drive the theme
 */


/**
 * pass classes to the sidebar globally
 *
 */
function thmplt_sidebar_class($classes) {
	global $post; 

	$classes = apply_filters( 'sidebar_class', $classes, $post->ID );
	
	echo 'class="' . join( ' ', $classes ) . '"';

}



/**
 * pass classes to the main section globally
 *
 */
function thmplt_main_section_class($classes) {
	global $post; 

	$classes = apply_filters( 'main_section_class', $classes, $post->ID );
	
	echo 'class="' . join( ' ', $classes ) . '"';

}



/**
 * Filter adds the classes to the sidebar  
 * from the global variable 
 */
function thmplt_add_sidebar_classes($classes, $post_id=NULL){
	global $thmplt;
	
	if (!empty($thmplt['sidebar_class']) ) { 
	
		$classes[] = $thmplt['sidebar_class'];
		
	}
		
	return $classes;	
	
}
add_filter('sidebar_class','thmplt_add_sidebar_classes');



/**
 * Filter adds the classes to the article 
 * from the global variable 
 */
function thmplt_add_main_section_classes($classes, $post_id=NULL){
	global $thmplt;
	
	if (!empty($thmplt['main_section_class']) ) { 
	
		$classes[] = $thmplt['main_section_class'];
		
	}
		
	return $classes;	
	
}
add_filter('main_section_class','thmplt_add_main_section_classes');



/**
 * The pagination 
 *
 */
function thmplt_content_pagination(){
	global $post; global $wp_query;	
	
	echo "<div class='pagination'>";
	
	$big = 999999999; // a random page assigned 
	$args = array(
		'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ), 
		'format' => '?paged=%#%', 
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'end_size'     => 2,
		'mid_size'     => 20
	);
	echo paginate_links( $args );  
	
	echo "</div>";

}#End Function Pagination 



/**
 * archive title 
 *
 */
function thmplt_title($before, $after, $args=array()) {
	global $post;
		$defaults = array(
				'cat' => '{title}',
				'tax' => '{title}',
				'tag' => 'Posts Tagged &#8216; {title} &#8217;',
				'day' => 'Posts From {title}',
				'month' => 'Posts From {title}',
				'year' => 'Posts From {title}',
				'author' => 'Achives from {title}',
				'archived'=>'Latest Posts'
				//'default' =>  $hostpost->post_title 
			);
	

		// Merge Defaults with real values 	
		$args = array_merge($defaults,$args); // Overwrite Defaults

	
		
	//$post = $posts[0]; // Hack. Set $post so that the_date() works. 
		if ( is_category() ) { 
			$title = str_replace ( '{title}', single_cat_title('',false), $args['cat'] );       
		} elseif( is_tax() ) {
			$title = str_replace ( '{title}', get_queried_object()->name, $args['tax'] ); 
		} elseif( is_tag() ) {
			$title = str_replace ( '{title}',single_tag_title('',false), $args['tag'] );		      
		} elseif (is_day()) { 
			$title =  str_replace ( '{title}', get_the_date('F jS, Y'), $args['day'] );        
		} elseif (is_month()) { 
			$title = str_replace ( '{title}',  get_the_date('F, Y') , $args['month'] );     
		} elseif (is_year()) {
			$title = str_replace ( '{title}', get_the_date('Y'), $args['year'] );
		} elseif (is_author()) {
			$title = str_replace ( '{title}', "Author" , $args['author'] );
		} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { 
			$title = str_replace ( '{title}', "Posts" , $args['archived'] );
		} else {
			$title = str_replace ( '{title}', "Blog" , $args['default'] );
		}
		
		echo $before.$title.$after ."\n";
}


/**
 * Resgister a font for later enqueuing 
 * 
 * @param string $id Name used as handle for stylesheet
 * @param string $scr URL source to stylesheet
 * @param string $inline Inline CSS to be added to this stylesheet
 */

function thmplt_register_font ($id, $src, $inline=NULL) {

	global $thmplt_style;
		
	if ( !array($thmplt_style) ) {
		$thmplt_fonts = array();
	}
	
	$thmplt_style[] = array(
		"ID" => $id,
		"src" => $src,
		"inline" => $inline
	);
	
}

/**
 * Add the style using wp_enqueue_style and wp_add_inline_style
 * that was registered with thmplt_register_font
 */
function thmplt_do_registered_font () {
	
	global $thmplt_style;
	
	if ( is_array($thmplt_style) ) { 
		foreach ($thmplt_style as $key => $val ){
			
			wp_enqueue_style ($val['ID'], $val['src'] );
			if ( !is_null($val['inline']) ){
				
				wp_add_inline_style($val['ID'], $val['inline']);
				
			}
		}
	}
	
}
add_action("wp_print_styles", "thmplt_do_registered_font") ;



/**
 * Resgister a Script file for later enqueuing 
 * 
 * @param String $id Name used as handle for stylesheet
 * @param String $scr URL source to stylesheet
 * @param Array $deps Array of the handles of all the registered scripts that this script depends on
 * @param String $ver String specifying the script version number, if it has one, 
 * which is concatenated to the end of the path as a query string
 *
 * @param boolean $in_footer Normally, scripts are placed in <head> of the HTML document. 
 * If this parameter is true, the script is placed before the </body> end tag
 * 
 */

function thmplt_register_script ($id, $src=false, $deps=array(), $ver=false, $in_footer=false) {

	global $thmplt_scripts;
		
	if ( !array($thmplt_scripts) ) {
		$thmplt_scripts = array();
	}
	
	$thmplt_scripts[] = array(
		"ID" => $id,
		"src" => $src,
		"deps" => $deps,
		"ver" => $ver,
		"in_footer" => $in_footer
		);
	
}

/**
 * Add the scripts using wp_enqueue_script 
 * that was registered with thmplt_register_script
 */
function thmplt_do_registered_scripts () {
	
	global $thmplt_scripts;
	
	if ( is_array($thmplt_scripts) ) { 
		foreach ($thmplt_scripts as $key => $val ){
			
			wp_enqueue_script ( $val['ID'], $val['src'], $val['deps'], $val['ver'], $val['in_footer'] );
			
		}
	}
}
add_action("wp_enqueue_scripts", "thmplt_do_registered_scripts");


/**
 * Resgister a Styles file for later enqueuing 
 * 
 * @param String $id Name used as handle for stylesheet
 * @param String $scr URL source to stylesheet
 * @param Array $deps Array of the handles of all the registered scripts that this script depends on
 * @param String $ver String specifying the script version number, if it has one, 
 * which is concatenated to the end of the path as a query string
 *
 * @param boolean $in_footer Normally, scripts are placed in <head> of the HTML document. 
 * If this parameter is true, the script is placed before the </body> end tag
 * 
 */

function thmplt_register_styles ($id, $src=false, $deps=array(), $ver=false, $media='all') {

	global $thmplt_styles;
		
	if ( !array($thmplt_styles) ) {
		$thmplt_styles = array();
	}
	
	$thmplt_styles[] = array(
		"ID" => $id,
		"src" => $src,
		"deps" => $deps,
		"ver" => $ver,
		"media" => $media
		);
	
}


/**
 * Add the styles using wp_enqueue_script 
 * that was registered with thmplt_register_styles
 */
function thmplt_do_registered_styles () {
	
	global $thmplt_styles;
	
	if ( is_array($thmplt_styles) ) { 
		foreach ($thmplt_styles as $key => $val ){
			
			wp_enqueue_style ( $val['ID'], $val['src'], $val['deps'], $val['ver'], $val['media'] );
			
		}
	}
}
add_action("wp_enqueue_scripts", "thmplt_do_registered_styles");


/**
 * Function adds special classes, based on the website's status, the body tag
 */
add_filter('body_class','thmplt_special_body_classes');
function thmplt_special_body_classes($classes) {
	 global $post;
	 
	// Detect Browser and OS of device and pass the info to the "body_spc_class" (BODY SPECIAL CLASS) to be appended to the body
	if( preg_match('/mac/i', $_SERVER['HTTP_USER_AGENT'])) { $classes[] =  "mac"; } 
	if( preg_match('/win/i', $_SERVER['HTTP_USER_AGENT'])) { $classes[] =  "windows"; } 
	if( preg_match('/linux/i', $_SERVER['HTTP_USER_AGENT'])) { $classes[] =  "linux"; } 
	if( preg_match('/firefox/i', $_SERVER['HTTP_USER_AGENT'])) { $classes[] =  "firefox"; } 
	if( preg_match('/safari/i', $_SERVER['HTTP_USER_AGENT'])) { $classes[] =  "safari"; }
	if( preg_match('/MSIE/i', $_SERVER['HTTP_USER_AGENT'])) { $classes[] =  "ie"; }
	if( !preg_match('/MSIE/i', $_SERVER['HTTP_USER_AGENT'])) { $classes[] =  "notie"; }
	if( preg_match('/MSIE 6/i', $_SERVER['HTTP_USER_AGENT'])) { $classes[] =  "ie6"; }
	if( preg_match('/MSIE 7/i', $_SERVER['HTTP_USER_AGENT'])) { $classes[] =  "ie7"; }
	if( preg_match('/MSIE 8/i', $_SERVER['HTTP_USER_AGENT'])) { $classes[] =  "ie8"; }
	if( preg_match('/MSIE 9/i', $_SERVER['HTTP_USER_AGENT'])) { $classes[] =  "ie9"; }
	if( preg_match('/MSIE 10/i', $_SERVER['HTTP_USER_AGENT'])) { $classes[] =  "ie10"; }
	if( preg_match('/android/i', $_SERVER['HTTP_USER_AGENT'])) { $classes[] =  "android"; }
	if( preg_match('/ipad/i', $_SERVER['HTTP_USER_AGENT'])) { $classes = thmplt_del_value($classes,"mac"); $classes[] =  "ipad"; }
	if( preg_match('/iphone/i', $_SERVER['HTTP_USER_AGENT'])) { $classes = thmplt_del_value($classes,"mac"); $classes[] =  "iphone"; }
	if( preg_match('/ipod/i', $_SERVER['HTTP_USER_AGENT'])) { $classes = thmplt_del_value($classes,"mac"); $classes[] =  "ipod"; }
	if( preg_match('/chrome/i', $_SERVER['HTTP_USER_AGENT'])) { $classes = thmplt_del_value($classes,"safari");  $classes[] =  "chrome"; }
	
	if (!empty($post)){
		//$classes[] = "top-parent-". get_top_parent($post->ID) ;
		
		$template = get_post_meta( $post->ID, '_wp_page_template', true );		
		$classes[] = str_replace(".php","",$template);		
	}

	// return the $classes array
	return $classes;
}#end function


/**
 * Function allows to delete an array based on value
 */
function thmplt_del_value ($array=array(), $value=NULL){
	if(($key = array_search($value, $array)) !== false) {
			unset($array[$key]);
	}
	return $array;
}



/**
 * Remove empty P Tags 
 */
function thmplt_remove_empty_p($content){
	
    $content = force_balance_tags($content);
    return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
	
}
add_filter('the_content', 'thmplt_remove_empty_p', 20, 1);




/**
 * Creates list item based on the .tps-clone-list jQuery action
 */
function thmplt_clone_list($atts){

	extract( shortcode_atts( array(
		'clone' => '', // Which Element to clone
		'contains' => '', // contains a word/text
		'target' => '',	// selector/s	
		'class' => ''
	), $atts ) );

	$html = "<ul class='tpf-clone-list ".$class."'" ; // opening of the UL 
	if (!empty($clone)){
		$html .= " data-clone='". $clone ."'";
	}
	if (!empty($contains)){
		$html .= " data-li-contains='". $contains ."'";
	}	
	if (!empty($target)){
		$html .= " data-target='". $target ."'";
	}	
	$html .= "><!-- Auto Generated --></ul>"; // Close the UL
	return  $html ;
}
add_shortcode('thmplt_clone_list','thmplt_clone_list');


/**
 * lists all sub-nav items based on menu location in the admin
 *
 * example :[thmplt_wp_nav location='XXXX']
 */
function thmplt_wp_nav($atts){
	extract( shortcode_atts( array(
		'location' => '',
		'class' => '',
		'id'		=> '',
		'depth' => '0'
	), $atts ) );	
	
	if (!empty($location)){
		$list =	wp_nav_menu('theme_location='.$location.'&container=false&echo=0&fallback_cb=false&items_wrap=%3$s&depth='.$depth); 		
	}else{
		$list = "<!-- Empty -->";
	}
	 $html = "<ul ";
	 if (!empty($id)) { $html .= "id='".$id."' "; }
	 $html .= " class='thmplt_wp_nav wp_nav_menu ". $class."' >".$list."</ul>";
	 return $html;
}
add_shortcode('thmplt_wp_nav','thmplt_wp_nav');


include ( TEMPLATEPATH . "/thmplt/theme_options.php" );	
include ( TEMPLATEPATH . "/thmplt/carousel.php" );
include ( TEMPLATEPATH . "/thmplt/content.php" );
include ( TEMPLATEPATH . "/thmplt/dynamic_sidebars.php" );	