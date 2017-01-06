<?php 
/**
 * thmplt's common functions to drive the theme
 */


/**
 * thmplt current version 
 */
define("THMPLT_VERSION", "1.1.5.1");



/**
 * thmplt SVG logo
 */
define("THMPLT_SVG_B64" , "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgMzIgMzIiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDMyIDMyIiB4bWw6c3BhY2U9InByZXNlcnZlIj48ZyBpZD0iTGF5ZXJfMV8xXyIgZGlzcGxheT0ibm9uZSI+PHBhdGggZGlzcGxheT0iaW5saW5lIiBmaWxsPSIjRUY0MjczIiBkPSJNMjcuNywwSDQuNEMyLDAsMC4xLDEuOSwwLjEsNC4zdjIzLjNjMCwyLjQsMS45LDQuMyw0LjMsNC4zaDIzLjNjMi40LDAsNC4zLTEuOSw0LjMtNC4zVjQuM0MzMiwxLjksMzAuMSwwLDI3LjcsMHogTTguNywyNS44Yy0yLDAtMy42LTAuOS0zLjYtMy40YzAtMC43LDAuMS0xLjQsMC4yLTJjMC4xLTAuNywwLjItMS4zLDAuMi0yYzAtMS43LTItMi4zLTItMi41YzAtMC4yLDItMC44LDItMi40YzAtMC43LTAuMS0xLjQtMC4yLTIuMWMtMC4xLTAuNy0wLjItMS40LTAuMi0yYzAtMi4zLDEuNS0zLjIsMi45LTMuMmgxLjFjMCwwLTAuNywwLjEtMS4yLDAuNUM3LjUsNyw2LjksNy44LDYuOCw5LjZjMCwwLjYsMC4xLDEuMiwwLjIsMS43YzAuMSwwLjYsMC4yLDEuMiwwLjIsMS45YzAsMS42LTAuNywyLjQtMS44LDIuN2wwLDBjMS4xLDAuMywxLjgsMS4xLDEuOCwyLjdjMCwwLjctMC4xLDEuMy0wLjIsMS45cy0wLjIsMS4yLTAuMiwxLjhjMCwxLjQsMC40LDIuMywwLjcsMi42YzAuOCwwLjksMS42LDAuOSwxLjYsMC45SDguN3ogTTE4LjMsMTQuMnYxMS41Yy00LjcsMC00LjYtMy41LTQuNi0zLjV2LTguMUg5LjF2LTEuMmMyLjQsMCwzLjktMS43LDQuMy0yLjdDMTQuMiw4LjMsMTMuNyw2LDEzLjcsNmM0LjksMCw0LjYsNC42LDQuNiw0LjZIMjNDMjMsMTQuMiwxOC4zLDE0LjIsMTguMywxNC4yeiBNMjYuNiwxOC40YzAsMC43LDAuMSwxLjQsMC4yLDIuMXMwLjIsMS40LDAuMiwyYzAsMi4zLTEuNSwzLjItMi45LDMuMkgyM2MwLDAsMC43LTAuMSwxLjItMC41czEuMS0xLjEsMS4yLTNjMC0wLjYtMC4xLTEuMi0wLjItMS43Yy0wLjEtMC42LTAuMi0xLjItMC4yLTEuOWMwLTEuNiwwLjctMi40LDEuOC0yLjdsMCwwYy0xLjEtMC4zLTEuOC0xLjEtMS44LTIuN2MwLTAuNywwLjEtMS4zLDAuMi0xLjljMC4xLTAuNiwwLjItMS4yLDAuMi0xLjhjMC0xLjQtMC40LTIuMy0wLjctMi42QzIzLjgsNi4xLDIzLDYuMiwyMyw2LjJoMC40YzIsMCwzLjYsMC45LDMuNiwzLjRjMCwwLjctMC4xLDEuNC0wLjIsMmMtMC4xLDAuNy0wLjIsMS4zLTAuMiwyYzAsMS43LDIsMi4zLDIsMi41QzI4LjYsMTYuMiwyNi42LDE2LjgsMjYuNiwxOC40eiIvPjwvZz48ZyBpZD0iTGF5ZXJfMiIgZGlzcGxheT0ibm9uZSI+PGcgZGlzcGxheT0iaW5saW5lIj48ZWxsaXBzZSBkaXNwbGF5PSJub25lIiBmaWxsPSIjRUY0MjczIiBjeD0iMTYuMiIgY3k9IjE1LjkiIHJ4PSIxNS43IiByeT0iMTUuOSIvPjxwYXRoIGRpc3BsYXk9Im5vbmUiIGZpbGw9IiNFRjQyNzMiIGQ9Ik0xOS43LDMySDEyQzUuNCwzMiwwLDI2LjYsMCwyMHYtOEMwLDUuNCw1LjQsMCwxMiwwaDcuN2M2LjYsMCwxMiw1LjQsMTIsMTJ2OEMzMS43LDI2LjYsMjYuMywzMiwxOS43LDMyeiIvPjxwYXRoIGRpc3BsYXk9Im5vbmUiIGZpbGw9IiNGRkZGRkYiIGQ9Ik0xNywwLjJjMCwwLDAuOCw0LjQtMC41LDguM2MtMC43LDItMy4xLDEuOC02LjksMS45VjE2SDE3djE1LjhjMCwwLTAuMiw2LjgsNy40LDYuOFYxNS45YzAsMCw3LjQsMCw3LjQtNi43aC03LjRDMjQuNCw5LjIsMjQuOCwwLjIsMTcsMC4yeiIvPjxnIGRpc3BsYXk9Im5vbmUiPjxwYXRoIGRpc3BsYXk9ImlubGluZSIgZmlsbD0iIzQwODBDMiIgZD0iTTI3LjUsMTkuMmMwLDAuOSwwLjIsMS45LDAuNCwyLjhjMC4yLDAuOSwwLjQsMS44LDAuNCwyLjhjMCwzLjEtMi44LDQuNC01LjYsNC40aC0yLjFjMCwwLDEuMy0wLjEsMi4yLTAuN2MwLjktMC41LDIuMS0xLjUsMi4yLTQuMWMwLTAuOC0wLjEtMS42LTAuMy0yLjRjLTAuMi0wLjgtMC4zLTEuNi0wLjMtMi41YzAtMi4xLDEuMy0zLjIsMy40LTMuNnYtMC4xYy0yLjEtMC40LTMuNC0xLjUtMy40LTMuN2MwLTAuOSwwLjEtMS43LDAuMy0yLjVDMjQuOSw4LjgsMjUsOCwyNSw3LjJjMC0xLjktMC44LTMuMS0xLjMtMy41Yy0xLjUtMS4zLTMuMS0xLjItMy4xLTEuMmwwLjgtMC4xYzMuOSwwLDYuOCwxLjIsNi44LDQuNmMwLDAuOS0wLjIsMS44LTAuNCwyLjdjLTAuMiwwLjktMC40LDEuOC0wLjQsMi43YzAsMi4zLDMuOCwzLjEsMy44LDMuM1MyNy41LDE3LDI3LjUsMTkuMnoiLz48L2c+PGcgZGlzcGxheT0ibm9uZSI+PHBhdGggZGlzcGxheT0iaW5saW5lIiBmaWxsPSIjNDE4MUMzIiBkPSJNNCwxMi41YzAtMC45LTAuMi0xLjktMC40LTIuOEMzLjQsOC44LDMuMiw3LjksMy4yLDYuOWMwLTMuMSwyLjktNC40LDUuOS00LjRoMi4xYzAsMC0xLjQsMC4xLTIuMywwLjdDOCwzLjcsNi43LDQuNyw2LjYsNy4yYzAsMC44LDAuMSwxLjYsMC4zLDIuNGMwLjIsMC44LDAuMywxLjYsMC4zLDIuNmMwLDIuMS0xLjMsMy4yLTMuNSwzLjZ2MC4xYzIuMiwwLjQsMy42LDEuNSwzLjUsMy43YzAsMC45LTAuMSwxLjctMC4zLDIuNmMtMC4yLDAuOC0wLjMsMS42LTAuMywyLjRjMCwxLjksMC44LDMuMSwxLjQsMy41YzEuNSwxLjMsMy4yLDEuMiwzLjIsMS4ybC0wLjksMC4xYy00LjEsMC03LjEtMS4yLTcuMS00LjZjMC0wLjksMC4yLTEuOCwwLjQtMi44QzMuOCwyMSw0LDIwLjEsNCwxOS4yYzAtMi4zLTQtMy4xLTQtMy4zQzAsMTUuNiw0LDE0LjcsNCwxMi41eiIvPjwvZz48cmVjdCB4PSIxLjMiIHk9IjEwLjMiIGRpc3BsYXk9Im5vbmUiIGZpbGw9IiNGRkZGRkYiIHdpZHRoPSI2IiBoZWlnaHQ9IjUuNiIvPjxnIGRpc3BsYXk9Im5vbmUiPjxwYXRoIGRpc3BsYXk9ImlubGluZSIgZmlsbD0iI0ZGRkZGRiIgZD0iTTEyLjMsMjguMXYxLjZoLTEuMmMtMywwLTUuMS0wLjUtNi4xLTEuNWMtMC44LTAuNy0xLjItMS45LTEuMi0zLjVjMC0wLjYsMC0xLjIsMC4xLTEuOGMwLTAuNiwwLjEtMS4yLDAuMS0xLjhjMC0xLjEtMC4yLTItMC43LTIuNWMtMC42LTAuOC0xLjctMS4zLTMuMy0xLjV2LTEuNGMxLjYtMC4yLDIuNy0wLjcsMy4zLTEuNEMzLjcsMTMuNyw0LDEyLjksNCwxMS44YzAtMC41LTAuMS0xLjMtMC4yLTIuMmMtMC4xLTEtMC4xLTEuNS0wLjEtMS43YzAtMS41LDAuNS0yLjcsMS40LTMuNGMxLjMtMC45LDMuNy0xLjQsNy4yLTEuNHYxLjZDMTAuMSw0LjgsOC41LDUuMyw3LjYsNmMtMC43LDAuNS0xLDEuNC0xLDIuNWMwLDAuNSwwLjEsMS4yLDAuMiwyLjFjMC4xLDEsMC4yLDEuNiwwLjIsMS44YzAsMS0wLjIsMS44LTAuNywyLjRjLTAuNiwwLjgtMS43LDEuMy0zLjIsMS43YzEuNSwwLjQsMi42LDAuOSwzLjIsMS43QzYuOCwxOC44LDcsMTkuNiw3LDIwLjZjMCwwLjQtMC4xLDEuMS0wLjIsMnMtMC4yLDEuNS0wLjIsMS45YzAsMS4xLDAuMywxLjksMSwyLjRDOC41LDI3LjUsMTAuMSwyOCwxMi4zLDI4LjF6Ii8+PC9nPjxjaXJjbGUgZGlzcGxheT0ibm9uZSIgZmlsbD0iI0ZGRkZGRiIgY3g9IjQuNyIgY3k9IjIzLjMiIHI9IjEuMiIvPjxjaXJjbGUgZGlzcGxheT0ibm9uZSIgZmlsbD0iI0ZGRkZGRiIgY3g9IjQuOCIgY3k9IjIwLjMiIHI9IjAuNiIvPjxwYXRoIGZpbGw9IiNFRjQyNzMiIGQ9Ik0yNy41LDI4LjhjLTEuMiwwLjUtMi4xLDAuNy0yLjgsMC44Yy01LDAuNi02LjYtMC44LTcuMS01LjNsLTEuMS05LjdMMTIuNiwxNWwtMC43LTAuN2wtMC41LTQuNmw0LjUtMC41bC0wLjctNi40TDIyLjMsMmwxLjEsMC4zbDAuNyw2bDUuNy0wLjdDMzAuNyw4LDMxLjEsMTIuNSwzMCwxM2wtNS4yLDAuNmwwLjksOC4yYzAuNCwzLjIsMi4yLDMuNiwzLjMsMy41YzAuOS0wLjEsMS45LTAuNCwyLjktMC45VjQuM0MzMS45LDEuOSwzMCwwLDI3LjYsMEg0LjRDMiwwLDAuMSwxLjksMC4xLDQuM3YyMy40QzAuMSwzMC4xLDIsMzIsNC40LDMyaDIzLjJjMi40LDAsNC4zLTEuOSw0LjMtNC4zdi0xLjJMMjcuNSwyOC44eiBNOS4yLDI5LjVjLTIuNywwLTQuOS0yLjItNC45LTQuOXMyLjItNC45LDQuOS00LjlzNC45LDIuMiw0LjksNC45UzExLjksMjkuNSw5LjIsMjkuNXoiLz48ZyBkaXNwbGF5PSJub25lIj48cGF0aCBkaXNwbGF5PSJpbmxpbmUiIGZpbGw9IiNGRkZGRkYiIGQ9Ik0xLjcsMTguNWMwLTAuMS0wLjEtMC4zLTAuMS0wLjVzMC0wLjQsMC0wLjZjMC0wLjUsMC4yLTAuNiwwLjgtMC44YzEuOS0wLjgsMS4zLTMuNCwxLjUtNi44QzQsOC4zLDQuNiw3LjEsNS42LDZjMC44LTAuOSwyLTEuNiwzLjMtMi4xYzAuMSwwLDAuMy0wLjEsMC40LTAuMWMwLjMsMCwwLjUsMC4xLDAuNywwLjRzMC4zLDAuOSwwLjQsMS4xYzAsMC4zLTAuMSwwLjQtMC42LDAuN2MtMS42LDAuOS0yLDIuNS0yLjIsNS4xYy0wLjEsMi42LTAuMSw1LTIuMSw2LjNjMiwwLjMsMi4yLDEuOCwzLjMsNS41YzAuNywyLjMsMS40LDQsMy4xLDQuN2MwLjYsMC4yLDAuOCwwLjMsMC45LDAuN2MwLDAuNC0wLjEsMC44LTAuMiwxLjJjLTAuMSwwLjMtMC4yLDAuNC0wLjUsMC40Yy0wLjEsMC0wLjMsMC0wLjUsMGMtMS43LTAuMi0zLTAuOC00LTEuN2MtMS0wLjgtMS42LTEuOS0yLTMuMmMtMC45LTMuMy0wLjYtNS42LTIuNy01LjlDMi4yLDE5LjEsMS45LDE5LDEuNywxOC41eiIvPjwvZz48cmVjdCB4PSIxMC4xIiB5PSIxMC42IiB0cmFuc2Zvcm09Im1hdHJpeCgtMC45OTU4IDkuMTk5MjQ2ZS0wMDIgLTkuMTk5MjQ2ZS0wMDIgLTAuOTk1OCAyOC43NzY1IDI3LjY3MDkpIiBkaXNwbGF5PSJub25lIiBmaWxsPSIjRUY0MjczIiB3aWR0aD0iNy4zIiBoZWlnaHQ9IjcuOCIvPjwvZz48L2c+PHBhdGggZmlsbD0iI0NDMzM2NiIgZD0iTTIzLjksMEMyMy4zLDAsMi43LDAsMi40LDBDMi4xLDAsMS4xLDAuMSwwLjYsMC42UzAsMS45LDAsMi4yYzAsMC4zLDAsMjAuMywwLDIxLjJjMCwwLjgsMC41LDIsMS45LDJzMS45LTEuMywxLjktMmMwLTAuNywwLTE5LjUsMC0xOS41czE5LjMsMCwyMCwwYzAuNywwLDEuNi0wLjcsMS42LTJDMjUuNCwwLjYsMjQuNCwwLDIzLjksMHoiLz48cGF0aCBmaWxsPSIjQ0MzMzY2IiBkPSJNOC44LDMyYzAuNiwwLDIwLjYsMCwyMC45LDBjMC4zLDAsMS4zLTAuMSwxLjgtMC42YzAuNS0wLjUsMC42LTEuMywwLjYtMS42czAtMjAuMywwLTIxLjJjMC0wLjgtMC42LTItMS45LTJjLTEuNCwwLTEuOCwxLjMtMS44LDJzMCwxOS41LDAsMTkuNXMtMTguOCwwLTE5LjQsMGMtMC42LDAtMS43LDAuNi0xLjcsMkM3LjIsMzEuNSw4LjMsMzIsOC44LDMyeiIvPjxwYXRoIGZpbGw9IiNDQzMzNjYiIGQ9Ik0xMiwxMS4yYzAuMSwwLDAuNywwLDEuOCwwYzAsMCwwLjEtMi45LDAuMS0zLjFjMC0wLjUsMC40LTEuNCwxLjUtMS40QzE2LjIsNi43LDE3LDcuMSwxNyw4YzAsMC4xLDAuMSwzLjMsMC4xLDMuM2MwLjcsMC4xLDIuNiwwLDIuOSwwYzEuMiwwLDEuOSwwLjcsMS45LDEuN2MwLDEuMi0wLjgsMS43LTEuOCwxLjhjLTAuMywwLTMsMC4xLTMsMC4xUzE3LDE2LjQsMTcsMTkuMWMwLDAuNS0wLjIsMi4zLDEuMywyLjRjMC40LDAsMi4xLTAuMSwyLjcsMGMwLjYsMC4xLDEuMSwwLjYsMC45LDEuM2MtMC4yLDEtMS43LDEuNS0zLjIsMS42Yy0xLjUsMC4xLTIuNiwwLTMuMS0wLjFjLTEuNC0wLjMtMS45LTEuNS0yLjEtMi41Yy0wLjEtMC42LTAuMS03LjEtMC4xLTcuMXMtMS4zLDAtMS44LDBjLTAuOSwwLTEuNy0wLjQtMS43LTEuN1MxMC45LDExLjIsMTIsMTEuMnoiLz48L3N2Zz4=");



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
	
		// If there is a page_for_posts set... get the page
		if ( get_option( 'page_for_posts' ) ) { 
			 $hostpost = get_post( get_option( 'page_for_posts' ) );
		} 
	
		$defaults = array(
				'cat' => '{title}',
				'tax' => '{title}',
				'tag' => 'Posts Tagged &#8216; {title} &#8217;',
				'day' => 'Posts From {title}',
				'month' => 'Posts From {title}',
				'year' => 'Posts From {title}',
				'author' => 'Achives from {title}',
				'archived'=>'Latest Posts',
				'default' =>  $hostpost->post_title 
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
	// global $post;
	
	global $thmplt;
	 
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
	
	
	if  ( !empty($thmplt['nosidebar']) && $thmplt['nosidebar'] == true ) { 
		$classes[] = "nosidebar no-sidebar";
	}
	
	if ( !is_front_page()){ 
		$classes[] = "inside";
	} 
	
	//if (!empty($post)){
		//$classes[] = "top-parent-". get_top_parent($post->ID) ;
		
		//$template = get_post_meta( $post->ID, '_wp_page_template', true );		
		//$classes[] = str_replace(".php","",$template);		
	//}

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


/**
 * Get the sidebar/widgets to return through a shortcode 
 *
 */
function thmplt_dynamic_sidebar_shortcode($atts){
	extract( shortcode_atts( array(
		'sidebar' => '',
	), $atts ) );
		
    ob_start();
    dynamic_sidebar($sidebar);
    $sidebar_ob = ob_get_contents();
    ob_end_clean();
	
	return $sidebar_ob;
}
add_shortcode('thmplt_dynamic_sidebar','thmplt_dynamic_sidebar_shortcode');



/**
 * Get bloginfo in the editor as a shortcode
 */
function thmplt_bloginfo_shortcode($atts){
	extract( shortcode_atts( array(
		'info' => ''
	), $atts ) );	
	
	return get_bloginfo($info);
	
}
add_shortcode('thmplt_bloginfo','thmplt_bloginfo_shortcode');


include ( TEMPLATEPATH . "/thmplt/theme_options.php" );	
include ( TEMPLATEPATH . "/thmplt/carousel.php" );
include ( TEMPLATEPATH . "/thmplt/content.php" );
include ( TEMPLATEPATH . "/thmplt/dynamic_sidebars.php" );	
include ( TEMPLATEPATH . "/thmplt/sections.php" );
include ( TEMPLATEPATH . "/thmplt/sections_options.php" );	
include ( TEMPLATEPATH . "/thmplt/latest.php" );