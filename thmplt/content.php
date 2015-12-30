<?php
/**
 * Custom Post type and settings for content which will be used as 
 * the home page sections
 */


	$args = array ( 
		"public" => true, 
		
		'labels' => array(
			'name' => 'thmplt Content', // general name for the post type, usually plural
			'singular_name' => 'Content', // Singular name for one object of this post type
			'add_new' => 'Add New Content', 
			'add_new_item' => 'New Content',
			'edit_item' => 'Edit Content',
			'new_item' => 'New Content',
			'view_item' => 'View Content',
			'search_items' => 'Search Contents',
			'not_found' =>  'No Contents Found',
			'not_found_in_trash' => 'No Contents Found in Trash' 
		),
		'public' => false,
		'show_ui' => true,
		//'show_in_menu' => 'thmplt-options', // Put it in the "theme egg menu"
		//'menu_position' => 61.1,
		'menu_icon' => THMPLT_SVG_B64,
		'hierarchical' => false, // true to treat as pages... can have parent/children	
		'has_archive' => false, // archive/results page (can be set to slug of archive)
		'rewrite' => false, 
		'show_in_nav_menus' => false,
		'supports' => array('title','editor','revisions', /*'thumbnail'*/ )
	
	);
	register_post_type( "thmplt_content", $args ) ;



/*	// UPDATE THE COUNT EVERYTIME THE POST IS UPDATED
	// There is a bug in WP that doesnt recount the custom catergories
	// after a case is "trashed" this accounts for that 
	add_action('init', 'thmplt_content_update_trash_count'); //trashed_post
	function thmplt_content_update_trash_count(){
		if ($_GET['trashed'] >= 1 || $_GET['untrashed'] >= 1){
			$taxonomy = get_taxonomy('mnfaqcat'); //get_object_taxonomies('mngallery', 'names');
			$terms 	= get_terms('mnfaqcat', array('get'=>'all')); // GET ALL TERMS
			$term_id = array(); 
			foreach ($terms as $termx){
				$term_id[] = $termx->term_taxonomy_id; //Convert Terms to array with term taxonomy id's
			}#End Foreach
			_update_post_term_count($term_id,$taxonomy);
		}#End If
	}#End Function mngallery_update_trash_count
*/


add_action ('admin_menu','thmplt_content_options');
function thmplt_content_options() {
	$parent_slug = "edit.php?post_type=thmplt_content";
	//$parent_slug = "thmplt-options";
	$page_title = "Content Options";
	$menu_title = "Content Options";
	$capability = "publish_posts";
	$menu_slug = "content-options";	
	$function = "content_options_callback";		
	add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
} 



/**
 * Callback creates the content options/settings page
 *
 */
function content_options_callback () {
	
	// $registered_contents = apply_filter("thmplt_content", array() );

	global $thmplt_register_content;
	
	do_action('thmplt_init_content'); 
	
	//echo "<pre>"; var_dump($thmplt_register_content); echo "</pre>";
	
	$thmplt_content = get_option('thmplt_content');

	if (!empty($_POST)){ 
		$thmplt_content = $_POST['thmplt_content']; 
	}

	
	echo "<div class='wrap'>";
		echo "<h2>content Settings</h2>";
		
		echo "<form method='post' name='options'>";
			echo "<table class='form-table' >";
				echo "<tbody>";
				
					/**
					 * HTML/Option for the Contents 
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='blogname'>Contents</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>Choose which contents to attach to its registered part</label><br /><br />";
					
						/**
						 * loop creates the drop downs for selecting which Contents go on the front page
						 */
						foreach ( $thmplt_register_content as $id => $arg ) { 
						
							echo "<strong>" .$arg['label'] . "</strong> ";
							if (!empty($arg['description'])) { 
								echo "<br /><span class='description'>". $arg['description'] . "</span> <br />";
							}
							
							echo "<span class='shortcode'>[thmplt_content cid='".$id."' ]</span> <br />";
							
							@thmplt_content_dropdown( "thmplt_content[".$id."]" , $thmplt_content[$id] );
							//echo "<br /><strong>Shortcode:</strong>&nbsp;&nbsp;&nbsp; [thmplt_content cid='".$id."' ]";
							echo "<br /><br />";
						}
						
						echo "</fieldset>";
					echo "</td>";
					echo "</tr>";

						
				echo "</tbody>"; 
			echo "</table>";

			echo "<p class='submit'>";
				echo "<input type='submit' name='Submit' value='Save Changes' class='button-primary' />";
			echo "</p>";			
			
		echo "</form>";		
	
	echo "</div>";	


	/**
	 * Save our data if $_POST is not empty 
	 *
	 */
	if (!empty($_POST)){

		$error = false;
	
		if ($error != true){
			echo "<div class='updated'><p><strong>";
			echo "Options saved";
			echo "</strong></p></div>";
		}
		update_option( 'thmplt_content', $_POST['thmplt_content'] );
		
	}#End if (!empty($_POST))
	
	
}


/**
 * Create a dropdown of the content post types
 * so it can be selected to show on the front page 
 */
function thmplt_content_dropdown($name, $selected_id){
	

	$args = array('sort_column' => 'post_title', 'post_type' => 'thmplt_content', 'post_status' => 'publish', 'posts_per_page' => -1);
	$pages = get_posts($args);

	
	if (is_array($pages)) {
		echo "<select name='".$name."'>";
		echo "<option value='none'> - </option>";
		foreach ($pages as $page) {
			$selected = ( $page->ID == $selected_id ) ? "selected": NULL;
			
			echo "<option value='".$page->ID."' ".$selected." >". ucfirst($page->post_title) . "</option>";
		}
		echo "</select>";
	}
	
	
}


/**
 * register a content to be used as part of a theme section
 * 
 * @param string $id The ID name of the content
 * @param array $args The arguments passed 
 * @return void returns nothing
 */
function thmplt_register_content($id, $args = array() ) {
	global $thmplt_register_content;

	$default = array(
		"label" => $id
	);
	
	$args = array_merge($default, $args);
	
	$thmplt_register_content[$id] = $args;
	
}



/**
 * display the content based on the registered ID
 * Also adds filters from "the_content" to "thmplt_content" so that 
 * it is compatible when display content on the front end
 *
 * Uses "thmplt_content" action and filters
 * 
 * @param string $id The ID of the content that should be displayed
 * @return string The content fromt the attached post
 */
function thmplt_show_content($id) {
	
	$thmplt_content = get_option('thmplt_content');
	
	// If a post ID is not attached then return false
	// as we cannot do anything with it anyways
	if ( empty($thmplt_content[$id]) ){ 
		return false;
	}
	
	
	$content = get_post($thmplt_content[$id]);
	@$post_content = $content->post_content;


	// call actions here for things like removing filters
	// from the "thmplt_content" especially ones added from "the_content" 	
	do_action('thmplt_content');
	
	// Call actions here for specific content areas
	// such as a sidebar content "thmplt_content_sidebar" 
	do_action('thmplt_content_'. $id );	 

	// Apply filters from "thmplt_content"
	$post_content = apply_filters('thmplt_content', $post_content );
	// Apply filters Specifically to the running content area 
	$post_content = apply_filters('thmplt_content_'.$id , $post_content );	

	return $post_content;
	
}



/**
 * display the content based on the registered ID through wp shortcode method
 * 
 * @param array $atts The attributes passed on from wp shortcode
 * @return string The content fromt the attached post
 */
function thmplt_show_content_shortcode($atts) {

	extract( shortcode_atts( array(
		'cid' => '', // Which content ID to pull 
		'id' => '',	// selector/s	
		'class' => ''
	), $atts ) );
	
	$html = "<div ";
	$html .= (empty($id))? "": " id='".$id."'"; 
	$html .= "class='thmplt_content ". $class ."'> \n";
	
	$html .= thmplt_show_content($cid);
	$html .= "</div> \n\n";

	return $html;
	
}
add_shortcode('thmplt_content', 'thmplt_show_content_shortcode');




/**
 * Add all filters from "the_content" and apply it to "thmplt_content"
 * for compatibility reasons
 */
	global $wp_filter;

	foreach ($wp_filter['the_content'] as $priority => $filter){
			
		foreach ($filter as $func) {	
			add_filter('thmplt_content', $func['function'], $priority, $func['accepted_args']);		
		}
		
	}



