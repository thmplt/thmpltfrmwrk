<?php
/**
 * Options markup for the sections screen  
 */



add_action ('admin_menu','thmplt_section_options');
function thmplt_section_options() {
	$parent_slug = "edit.php?post_type=thmplt_section";
	//$parent_slug = "thmplt-options";
	$page_title = "Section Options";
	$menu_title = "Section Options";
	$capability = "publish_posts";
	$menu_slug = "thmplt-section-options";	
	$function = "thmplt_section_options_callback";		
	add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
} 



/**
 * Add support for the media upload 
 */
add_action('admin_init', 'thmplt_sections_media_support');
function thmplt_sections_media_support() {

	$add_scripts = false;
	if ( !empty( $_GET['page'] ) && $_GET['page'] == "thmplt-section-options" ) { $add_scripts = true; }
	
	if ($add_scripts) {		
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-draggable' );		
		 	 		
		 	 
	}
	
}


/**
 * Include scripts/styles to this page
 */
add_action('admin_head', 'thmplt_section_options_scripts');
function thmplt_section_options_scripts() {

	$add_scripts = false;
	$url_to_here = str_replace( TEMPLATEPATH, get_bloginfo('template_url'), dirname(__FILE__) );
	
	if (!empty($_GET['page']) && $_GET['page'] == "thmplt-section-options") { $add_scripts = true; }
	if ($add_scripts) {	

		echo "<script type='text/javascript'  src='". $url_to_here. "/section_options.js'></script>\n";
		echo "<link type='text/css' rel='stylesheet' href='". $url_to_here. "/section_options.css' />\n";
		
	}
	
}




/**
 * Callback creates the content options/settings page
 *
 */
function thmplt_section_options_callback () {
	
	// $registered_contents = apply_filter("thmplt_section", array() );

	global $thmplt_register_section;
	
	do_action('thmplt_init_section'); 
	
	//echo "<pre>"; var_dump($thmplt_register_content); echo "</pre>";
	
	$thmplt_section = get_option('thmplt_section');

	if (!empty($_POST)){ 
		$thmplt_section = $_POST['thmplt_section']; 
	}


	//var_dump($thmplt_section);
	
	echo "<div class='wrap'>";
		echo "<h2>Sections Settings</h2>";
		
		echo "<form method='post' name='options'>";
			echo "<table class='form-table' >";
				echo "<tbody>";
				
					/**
					 * HTML/Option for the Contents 
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='blogname'>Sections</label><br /><br />";
					//echo "Sections go here!";
					
					
					@thmplt_section_selectbox('sections_select', NULL);
					
					
					echo "</th>";
					echo "<td valign='top' style='vertical-align:top'>";
					
						echo "<fieldset>";
						echo "<label>Choose which sections to attach to its registered part</label><br /><br />";
					
						/**
						 * loop creates the drop downs for selecting which Contents go on the front page
						 */
						 echo "<ul>";
						foreach ( $thmplt_register_section as $id => $arg ) { 
						
						echo "<li id='".$id."' data-hook='".$arg['hook']."'>";
							//echo "<div class='dragdropclose'>";
							//echo "<h3>title goes here</h3>";
							//echo "</div>";

							echo "<strong>" .$arg['label'] . "</strong> ";
							if (!empty($arg['description'])) { 
								echo "<br /><span class='description'>". $arg['description'] . "</span> <br />";
							}
							
							echo "<ul class='tpf-jq-sortable' data-hook='".$arg['hook']."'>";
								
								if (!empty($thmplt_section[$arg['hook']]) && is_array($thmplt_section[$arg['hook']]) ){
									foreach ( $thmplt_section[$arg['hook']] as $listitem ){
										
										//echo $listitem; = ID
										$post_7 = get_post( $listitem ); 
										$title = $post_7->post_title;
										
										echo "<li>";
										echo $title;
										echo "<input type='hidden' name='thmplt_section[".$arg['hook']."][]' value='".$listitem."'/>";
										echo "</li>";
										
										
									}
								}
	
							echo "</ul>";
						
							echo "<br /><br />";
							
						echo "</li>";	
						}
						
						echo "</fieldset>";
					echo "</td>";
					echo "</tr>";


					/**
					 * HTML/Option for the Contents 
					 */ 
/*					echo "<tr>";
					echo "<th scope='row'><label for='blogname'>Sections Builder</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>Define the opening and closing markup for the sections</label><br /><br />";
					
						echo "<strong>Opening markup</strong><br />";
						echo "<input type='text' value='' name='thmplt_section[openingmarkup]'  style='max-width:550px;width:100%'/><br /><br />";

						echo "<strong>Closing markup</strong><br />";
						echo "<input type='text' value='' name='thmplt_section[closingmarkup]' style='max-width:550px;width:100%'/><br /><br />";						
						
						echo "</fieldset>";
					echo "</td>";
					echo "</tr>";*/


						
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
		update_option( 'thmplt_section', $_POST['thmplt_section'] );
		
	}#End if (!empty($_POST))
	
	
}


/**
 * Create a selectbox of the sections post types
 * so it can be selected to and added to the structures 
 */
function thmplt_section_selectbox($name, $selected_id){
	
	$args = array('sort_column' => 'post_title', 'post_type' => 'thmplt_section', 'post_status' => 'publish', 'posts_per_page' => -1);
	$pages = get_posts($args);
	
	if (is_array($pages)) {
		echo "<ul class='tpf-jq-sortable-master' style='width:90%; height:300px'>";		
		foreach ($pages as $page) {
			echo "<li>".ucfirst($page->post_title)." <input type='hidden' name='thmplpt_section[][]' value='".ucfirst($page->ID)."' /></li>";
			
		}
		echo "</ul>";
	}
	
}







/**
 * register a section/hook to be used as part of a theme layout
 * 
 * @param string $id The ID name of the content
 * @param array $args The arguments passed 
 * @return void returns nothing
 */
function thmplt_register_section($id, $args = array() ) {
	global $thmplt_register_section;

	$default = array(
		"label" => $id
	);
	
	$args = array_merge($default, $args);
	
	$thmplt_register_section[$id] = $args;
	
}



/**
 * display the content based on the registered ID
 * Also adds filters from "the_content" to "thmplt_section" so that 
 * it is compatible when display content on the front end
 *
 * Uses "thmplt_section" action and filters
 * 
 * @param string $id The ID of the content that should be displayed
 * @return string The content fromt the attached post
 */
function thmplt_show_contentXXX($id) {
	
	$thmplt_section = get_option('thmplt_section');
	
	// If a post ID is not attached then return false
	// as we cannot do anything with it anyways
	if ( empty($thmplt_section[$id]) ){ 
		return false;
	}
	
	
	$content = get_post($thmplt_section[$id]);
	@$post_content = $content->post_content;


	// call actions here for things like removing filters
	// from the "thmplt_section" especially ones added from "the_content" 	
	do_action('thmplt_section');
	
	// Call actions here for specific content areas
	// such as a sidebar content "thmplt_section_sidebar" 
	do_action('thmplt_section_'. $id );	 

	// Apply filters from "thmplt_section"
	$post_content = apply_filters('thmplt_section', $post_content );
	// Apply filters Specifically to the running content area 
	$post_content = apply_filters('thmplt_section_'.$id , $post_content );	

	return $post_content;
	
}



/**
 * display the content based on the registered ID through wp shortcode method
 * 
 * @param array $atts The attributes passed on from wp shortcode
 * @return string The content fromt the attached post
 */
function thmplt_show_content_shortcodeXXX($atts) {

	extract( shortcode_atts( array(
		'cid' => '', // Which content ID to pull 
		'id' => '',	// selector/s	
		'class' => ''
	), $atts ) );
	
	$html = "<div ";
	$html .= (empty($id))? "": " id='".$id."'"; 
	$html .= "class='thmplt_section ". $class ."'> \n";
	
	$html .= thmplt_show_content($cid);
	$html .= "</div> \n\n";

	return $html;
	
}
add_shortcode('thmplt_section', 'thmplt_show_content_shortcode');




/**
 * Add all filters from "the_content" and apply it to "thmplt_section"
 * for compatibility reasons
 */
	global $wp_filter;

	foreach ($wp_filter['the_content'] as $priority => $filter){
			
		foreach ($filter as $func) {	
			add_filter('thmplt_section', $func['function'], $priority, $func['accepted_args']);		
		}
		
	}
	

/**
 * add support for sections to be used on the pages
 * Must me passed trough an action "thmplt_init_section"
 */
function thmplt_init_section() {
	
	thmplt_register_section('thmplt_before_main_header', array(
		'label' => 'Before the header',
		'description' => 'Section before the main header, after the opening "body" tag',
		'hook' => 'thmplt_before_main_header'
	));
	thmplt_register_section('thmplt_before_main_section', array(
		'label' => 'Before the main section',
		'description' => 'Section right after the header and before the main section',
		'hook' => 'thmplt_before_main_section'
	));
	thmplt_register_section('thmplt_after_main_section', array(
		'label' => 'Before the footer',
		'description' => 'Section right after the main section and before the footer',
		'hook' => 'thmplt_after_main_section'
	));	
	thmplt_register_section('thmplt_after_main_footer', array(
		'label' => 'After the footer',
		'description' => 'All content after the main footer before the closing "body" tag',
		'hook' => 'thmplt_after_main_footer'
	));			

}
add_action('thmplt_init_section', 'thmplt_init_section' );



/**
 * Get the registered (filled) section hooks and add them to its appropriate hook
 */
function thmplt_add_actions_to_hooks_from_sections(){

	$thmplt_section = get_option('thmplt_section');
	
	if (!empty($thmplt_section) && is_array($thmplt_section) ){

		foreach ($thmplt_section as $hook => $sections ) {
				add_action($hook, 'thmplt_show_section' );
		}
	}
}
add_action('init', 'thmplt_add_actions_to_hooks_from_sections' );


/**
 * 
 */
function thmplt_show_section($current_hook){

	$hook = current_filter(); 
	
	$thmplt_section = get_option('thmplt_section');
	if (!empty($thmplt_section[$hook]) && is_array($thmplt_section[$hook]) ){
		
		foreach ($thmplt_section[$hook] as $listitemid){
			
			echo thmplt_Section_content($listitemid);
			
		}
	}
	
}

