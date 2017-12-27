<?php
/**
 * Dynamic Sections
 */
 

/**
 * Custom Post type and settings for Sections which will be displayed
 * in the Sections as 
 */
$args = array ( 
	"public" => true, 
	'labels' => array(
		'name' => 'thmplt Sections', // general name for the post type, usually plural
		'singular_name' => 'Section', // Singular name for one object of this post type
		'add_new' => 'Add New Section', 
		'add_new_item' => 'New Section',
		'edit_item' => 'Edit Section',
		'new_item' => 'New Section',
		'view_item' => 'View Section',
		'search_items' => 'Search Sections',
		'not_found' =>  'No Sections Found',
		'not_found_in_trash' => 'No Sections Found in Trash' 
	),
	'public' => false,
	'show_ui' => true,
	//'show_in_menu' => 'thmplt-options', // Put it in the "theme egg menu"
	'menu_icon' => THMPLT_SVG_B64,
	'hierarchical' => false, // true to treat as pages... can have parent/children	
	'has_archive' => false, // archive/results page (can be set to slug of archive)
	'rewrite' => false, 
	'show_in_nav_menus' => false,
	'exclude_from_search' => true, // Remove from searches
	'publicly_queryable' => false, // Do not allow to show as post infront-end of site				
	'supports' => array('title','editor','revisions', 'thumbnail' )
);
register_post_type( "thmplt_section", $args ) ;


$thmplt_section_taxonomy_args = array (
	'labels' => array(
		'name' => __( 'Section Locations' ), // general name for the taxonomy, usually plural
		'singular_name' => __( 'Section Location' ) // name for one object of this taxonomy
	),
	'public' => false,
	'show_admin_column' => true,
	'description' => true,
	'sort' => false,
	'show_in_quick_edit' => false,
	'hierarchical' => true // true for category style, false for tag style	
);
register_taxonomy( "thmplt_section_tax", " thmplt_section", $thmplt_section_taxonomy_args );
register_taxonomy_for_object_type( 'thmplt_section_tax', 'thmplt_section' );


$thmplt_section_taxonomy_class_args = array (
	'labels' => array(
		'name' => __( 'Section Classes' ), // general name for the taxonomy, usually plural
		'singular_name' => __( 'Section Classes' ), // name for one object of this taxonomy
		'add_new_item' => __( 'Add New Class' ), // name for one object of this taxonomy	
		'separate_items_with_commas' => __( 'Separate classes with commas' ), // name for one object of this taxonomy
		'choose_from_most_used' => __( 'Choose from the most used classes' ), // name for one object of this taxonomy
		//'add_new_item' => __( 'Add New Class' ) // name for one object of this taxonomy	
	),
	'public' => false,
	'show_ui' => true,
	'show_admin_column' => true,
	'show_in_quick_edit' => true,
	'description' => true,
	'sort' => false,
	'hierarchical' => false // true for category style, false for tag style	
);
register_taxonomy( "thmplt_section_classes", " thmplt_section", $thmplt_section_taxonomy_class_args );
register_taxonomy_for_object_type( 'thmplt_section_classes', 'thmplt_section' );




/**
 * Move the featured image box to the main panel 
 */
add_action('do_meta_boxes', 'thmplt_section_move_featured_image_meta_box');
function thmplt_section_move_featured_image_meta_box() {
	remove_meta_box( 'postimagediv', 'thmplt_section', 'side' );
	add_meta_box('postimagediv', __('Background Image'), 'post_thumbnail_meta_box', 'thmplt_section', 'normal', 'high');
	
	//Classes
	remove_meta_box( 'tagsdiv-thmplt_section_classes', 'thmplt_section', 'side' );

}

/**
 * Add setting options to the fatured image
 */
function thmplt_section_featured_image_options( ) {
	global $post;
	
	if ( $post->post_type == "thmplt_section") { 
	
		$custom = get_post_custom($post->ID);
		@$thmplt_section_bg_settings = unserialize($custom['thmplt_section_bg_settings'][0]);
	
		$content = "<br />";
	
		
		$content .= "<label style='padding:0 15px 0 0 '>Section BG Color:
			<input type='text' value='".$thmplt_section_bg_settings['bgcolor']."' class='color-field' name='thmplt_section_bg_settings[bgcolor]' />
			</label>";
		
		
	//	$content = str_replace ( "Set featured image", "Set background Image", $content );
		$content .= "<label style='padding:0 15px 0 0 '>Section BG Image size: 
			<select name='thmplt_section_bg_settings[bgsize]'>
		";
		
		$content .= !empty( $thmplt_section_bg_settings['bgsize'] )  
		? "<option value='".$thmplt_section_bg_settings['bgsize']."'>".$thmplt_section_bg_settings['bgsize']."</option>"
		: "";
		
		$content .= "	
				<option value='-'> - </option>
				<option value='auto'>auto</option>
				<option value='cover'>cover</option>
				<option value='contain'>contain</option>
				</select>
		 </label>";	
	
		$content .= "<label style='padding:0 15px 0 0 '>Section BG Image Position: 
			<select name='thmplt_section_bg_settings[bgposition]'>";
		
		$content .= !empty( $thmplt_section_bg_settings['bgposition'] )  
		? "<option value='".$thmplt_section_bg_settings['bgposition']."'>".$thmplt_section_bg_settings['bgposition']."</option>"
		: "";
		
		$content .= "			
				<option value='-'> - </option>		
				<option value='center-center'>center-center</option>
				<option value='center-top'>center-top</option>
				<option value='center-bottom'>center-bottom</option>			
				<option value='left-top'>left-top</option>
				<option value='left-center'>left-center</option>
				<option value='left-bottom'>left bottom</option>
				<option value='right-top'>right-top</option>
				<option value='right-center'>right-center</option>
				<option value='right-bottom'>right-bottom</option>
				</select>			
		 </label>";	
	
		$content .= "<label style='padding:0 15px 0 0 '>Section BG Image Attachment: 
			<select name='thmplt_section_bg_settings[bgattachment]'>";
		
		$content .= !empty( $thmplt_section_bg_settings['bgattachment'] )  
		? "<option value='".$thmplt_section_bg_settings['bgattachment']."'>".$thmplt_section_bg_settings['bgattachment']."</option>"
		: "";
		
		$content .= "	
			
				<option value='-'> - </option>		
				<option value='scroll'>scroll</option>
				<option value='fixed'>fixed</option>
				<option value='local'>local</option>
				<option value='initial'>initial</option>
				<option value='inherit'>inherit</option>
				</select>			
		 </label>";	
		
		$content .= "<label style='padding:0 15px 0 0 '>Section BG Image repeat: 
			<select name='thmplt_section_bg_settings[bgrepeat]'>";
		
		$content .= !empty( $thmplt_section_bg_settings['bgrepeat'] )  
		? "<option value='".$thmplt_section_bg_settings['bgrepeat']."'>".$thmplt_section_bg_settings['bgrepeat']."</option>"
		: "";
		
		$content .= "
				<option value='-'> - </option>		
				<option value='repeat'>repeat</option>
				<option value='repeat-x'>repeat-x</option>
				<option value='repeat-y'>repeat-y</option>
				<option value='no-repeat'>no-repeat</option>
				<option value='initial'>initial</option>			
				<option value='inherit'>inherit</option>
				</select>			
		 </label>";		

		$content .= "<label style='padding:0 15px 0 0 '>Section BG Opacity: 
			<select name='thmplt_section_bg_settings[bgopacity]'>";
		
		$content .= !empty( $thmplt_section_bg_settings['bgopacity'] )  
		? "<option value='".$thmplt_section_bg_settings['bgopacity']."'>".$thmplt_section_bg_settings['bgopacity']."</option>"
		: "";
		
		$content .= "
				<option value='-'> - </option>		
				<option value='.1'> .1 </option>
				<option value='.2'> .2 </option>		
				<option value='.3'> .3 </option>
				<option value='.4'> .4 </option>		
				<option value='.5'> .5 </option>
				<option value='.6'> .6 </option>
				<option value='.7'> .7 </option>
				<option value='.8'> .8 </option>
				<option value='.9'> .9 </option>
				<option value='1'> 1 </option>				
				</select>			
		 </label>";		
		
		//bgopacity
		
	} #End if 
	
    echo  $content;
}


/**
 * Create Metabox for thmplt_section
 */
function thmplt_section_meta(){
	add_meta_box("thmplt_section_meta_box", "Section Display Conditions", "thmplt_section_html", "thmplt_section", "normal", "high");
	add_meta_box("thmplt_section_meta_box1", "Section Settings", "thmplt_section_settings_html", "thmplt_section", "normal", "high");
	// Moved the "classes" metabox to main area
	add_meta_box('tagsdiv-thmplt_section_classes', __('Section Classes'), 'post_tags_meta_box', 'thmplt_section', 'normal', 'high', array('taxonomy' => 'thmplt_section_classes'));	
	
	add_meta_box("thmplt_section_meta_box2", "Section Background Options", "thmplt_section_featured_image_options", "thmplt_section", "normal", "high");
	
}

add_action("admin_init", "thmplt_section_meta");



/**
 * Thmplt Sections Settings 
 */
function thmplt_section_settings_html() { 

	global $post;
	$custom = get_post_custom($post->ID);
	@$thmplt_section_settings = unserialize($custom['thmplt_section_settings'][0]);

	$set = "<label style='padding:0 15px 0 0 '>Section ID: <input type='text' name='thmplt_section_settings[id]' value='".$thmplt_section_settings['id']."' /> </label>";
	$set .= "<label style='padding:0 15px 0 0 '>Section Class <em>(legacy)</em>: <input type='text' name='thmplt_section_settings[class]' value='".$thmplt_section_settings['class']."' style='width:850px'/> </label>";	

	/* $set .= "<br />";
	$set .= "<strong>Classes:</strong> ";
	$set .= "<em>fullwidth-container</em>"; */
	
	/*<option value='inherit'>inherit</option> */	
	
	$set .= "";
	echo $set;

} 



/**
 * Thmplt Sections Admin HTML options 
 */
function thmplt_section_html() {
	echo "<style> #edit-slug-box {display:none!important} </style>";
	global $post;
	$custom = get_post_custom($post->ID);
	$include_data = !empty($custom['include'][0])? unserialize($custom['include'][0]): NULL ;
	$exclude_data = !empty($custom['exclude'][0])? unserialize($custom['exclude'][0]): NULL ;	
	
	// Selections for all pages and children pages. 
	echo "<strong>Select which pages this content should display on</strong><br /><br />";
	@$fp_checked = ($include_data['frontpage'] == "on")? "checked":NULL;
	@$all_checked = ($include_data['all'] == "on")? "checked":NULL;
	@$all_children_checked = ($include_data['all_children'] == "on")? "checked":NULL;	
	echo "<label style='padding:0 15px 0 0 '><input type='checkbox' class='' name='include[frontpage]' ".$fp_checked." /> ";
		echo " Display on front page</label>";	
	echo "<label style='padding:0 15px 0 0 '><input type='checkbox' class='' name='include[all]' ".$all_checked." /> ";
		echo " Display on all pages</label>";
	echo "<label style='padding:0 15px 0 0 '><input type='checkbox' class='' name='include[all_children]' ".$all_children_checked." /> ";
		echo "Automatically include children pages </label>";
	echo "<br /><br />";
	
	echo "<div style='padding:8px; background:#E2EEFA;'>";	

	// default Section API include data
	// thmplt_section_create_check_boxes( array ( "post_type"=>"page", "label"=>"Pages", "style"=>'page', "type" => "include" ),$include_data);
	thmplt_add_post_types_to_sb($include_data, "include");
	do_action('thmplt_section_include_checkboxes',$include_data);

	echo "<br />";
	
	echo "</div>";	
	echo "<br /><hr style='height:1px; border:0; border-top:1px solid #ccc'/>";
	echo "<strong> Select Pages to Exclude</strong><br /><br />";
	
	$all_children_checked = ($exclude_data['all_children'] == "on")? "checked":NULL;	
	echo "<label style='padding:0 15px 0 0 '><input type='checkbox' class='' name='exclude[all_children]' ".$all_children_checked."/> ";
	echo "Automatically exclude children pages </label><br /><br />";
	echo "<div style='padding:8px; background:#FFF9E8;'>";

	// default Section API include data
	//thmplt_section_create_check_boxes( array ( "post_type"=>"page", "label"=>"Pages", "style"=>'page', "type" => "exclude" ),$exclude_data);
	thmplt_add_post_types_to_sb($exclude_data, "exclude");
	do_action('thmplt_section_exclude_checkboxes',$exclude_data);

	echo "</div>";	

}


/**
 * Create Check boxes for the Section Display Options in the Admin 
 */
function thmplt_section_create_check_boxes($args, $include_data) {
	
	// Default arguments	
	$default_args = array (
		"post_type" => "posts",
		"label" => "Posts",
		"style" => "post",
		//"type" => "include"
	);
	
	// merge defaults with the new args
	$args = array_merge($default_args, $args);	
	
	
	// Create the post type lable 
	echo "<strong>".$args['label'].":</strong><br /><br />";

	// Display All top level pages with no child pages
	if ($args['style'] == "page") {
		// if it's a page style ( I.E , it's hierarchical ) then use get_pages()
		$top_pages = get_pages(  array (
			'parent' => 0, 'post_type' => $args['post_type'], 'posts_per_page' => 2000, 'orderby'=> 'title', 'order' => 'ASC'
		));
	} else { 
	// if it's a post style then use get_posts 
		$top_pages = get_posts( array (
			'parent' => 0, 'post_type' => $args['post_type'], 'posts_per_page' => 2000, 'orderby'=> 'title', 'order' => 'ASC'
		) );
	}
	
	// Loop through results
	foreach ($top_pages as $page){
	
		$sub_pages = get_pages(array(
			'child_of' => $page->ID, 'post_type' => $args['post_type'], 'hierarchical' => false , 'posts_per_page' => 2000 
		));
		
		if (empty($sub_pages)){
			@$current_checked = ($include_data[$page->ID] == "on")? "checked":NULL;
			echo "<label style='padding:0 15px 0 0 '>";
			
			// create the input check box 
			if ($args['type'] == "include"){ 
				echo "<input type='checkbox' name='include[".$page->ID."]' ".$current_checked."> ";
			} elseif ($args['type'] == "exclude") {
				echo "<input type='checkbox' name='exclude[".$page->ID."]' ".$current_checked."> ";				
			}
			
			// create post name
			$post_name = str_replace("-"," ",$page->post_name);
			$post_name =  urldecode($post_name);
			echo   $post_name . " </label>  ";
			
			$current_checked = NULL; // reset the currently checked variable to NULL
		}#end if 
	
	}#end foreach	


	// If the style is like pages, then we can display parent pages with their children pages 
	if ($args['style'] == "page") {
		// Display All top level pages with child pages	and list their child pages 
		$top_pages_with_child = get_pages( array (
			'parent' => 0, 'post_type' => $args['post_type'], 'posts_per_page' => 2000, 'orderby'=> 'title', 'order' => 'ASC'
		));
		foreach ($top_pages_with_child as $page){
			$sub_pages_args = array('child_of' => $page->ID, 'post_type' => $args['post_type'], 'posts_per_page' => 2000 );
			$sub_pages = get_pages( $sub_pages_args );
			if (!empty($sub_pages)){
				echo "<br /><br />";
				$current_checked = ($include_data[$page->ID] == "on")? "checked":NULL;
				
				echo "<label style='padding:0 15px 0 0; font-weight:bold'>";
				if ($args['type'] == "include"){ 
					echo "<input type='checkbox' name='include[".$page->ID."]' ".$current_checked."> ";
				} elseif ($args['type'] == "exclude") {
					echo "<input type='checkbox' name='exclude[".$page->ID."]' ".$current_checked."> ";				
				}
				// Create post name
				$post_name = str_replace("-"," ",$page->post_name);
				$post_name =  urldecode($post_name);
				echo  $post_name . " </label>  ";
				$current_checked = NULL;
				
				foreach ($sub_pages as $sub_page){
					$sub_current_checked = ($include_data[$sub_page->ID] == "on")? "checked":NULL;
					echo "<label style='padding:0 15px 0 0 '>";

						// create the input check box 
						if ($args['type'] == "include"){ 
							echo "<input type='checkbox' name='include[".$sub_page->ID."]' ".$sub_current_checked."> ";
						} elseif ($args['type'] == "exclude") {
							echo "<input type='checkbox' name='exclude[".$sub_page->ID."]' ".$sub_current_checked."> ";				
						}
					
						// Create post name 
						$post_name = str_replace("-"," ",$sub_page->post_name);
						$post_name =  urldecode($post_name);
					echo   $post_name . " </label>  ";
					$sub_current_checked = NULL;				
				}#end foreach 
			}#end if 
		}#end foreach 
	} #end if 
	
	echo "<br /><br />";
	
}#End thmplt_section_create_check_boxes 



// Save mnsbcontent
function save_thmplt_section(){
	if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) ) {  return; }
	if ( isset($_REQUEST['bulk_edit']) ) {  return; }	
	if ( !empty($_POST['post_type']) && $_POST['post_type'] != 'thmplt_section') { return; }
	if ( empty($_POST['post_type'])) { return; }	
	global $post;
	update_post_meta($post->ID, "include", $_POST["include"]);
	update_post_meta($post->ID, "exclude", $_POST["exclude"]);
	update_post_meta($post->ID, "thmplt_section_bg_settings", $_POST["thmplt_section_bg_settings"]);
	update_post_meta($post->ID, "thmplt_section_settings", $_POST["thmplt_section_settings"]);		
		
}
add_action('save_post', 'save_thmplt_section'); 


// Display Data content 
function thmplt_section_content($section_id=NULL){
	wp_reset_postdata();	

	global $post; global $thmplt;
	
	$sb_output = "";

	$post_type = get_post_type( $post->ID ); // post type of current page 
	$page_ID = $post->ID;
	//echo "POSTTYPE:" .$post_type;

	$section = get_post($section_id);

		$display = false; // Set the display to false by default 	
		$custom = get_post_custom($section->ID);
		
		//var_dump($custom);
		
		@$include_data = unserialize($custom['include'][0]);
		@$exclude_data = unserialize($custom['exclude'][0]);	
		@$thmplt_section_settings = unserialize($custom['thmplt_section_settings'][0]);
		
		
		// Include Content Conditions
		if (!empty($include_data['all']) && $include_data['all'] == "on"){ // if its to be included in all pages 		
			$display = true;
		}else{
			@$display = ($include_data[$page_ID] == "on")? true: $display; // if its to be included in all pages 		
		}
		
		//echo $display;
		
		if (!empty($include_data['all_children']) && $include_data['all_children'] == "on"){
			$top_page_ID = get_post_ancestors($page_ID);
			$top_page_ID = $top_page_ID[0];
			$display = ($include_data[$top_page_ID] == "on")? true: $display; // if its to be included in all pages 			
		}


		// Include if it's on this post type
		if ( !empty($include_data[$post_type]) && $include_data[$post_type] == "on" ) {
			$display = true;
		}


		// Include if it's on the front page
		if ( !empty($include_data['frontpage']) && $include_data['frontpage'] == "on" ) {
			if (is_front_page()){
				$display = true;
			}
		}
	

		// Exclude content conditions
		@$display = ($exclude_data[$page_ID] == "on")? false: $display; // if its to be included in all pages 	
		
		if (!empty($exclude_data['all_children']) && $exclude_data['all_children'] == "on"){
			$top_page_ID = get_post_ancestors($page_ID);
			@$top_page_ID = $top_page_ID[0];
			@$display = ($exclude_data[$top_page_ID] == "on")? false: $display; // if its to be included in all pages 			
		}
		
		
		// Include if it's on this post type
		if ( !empty($exclude_data[$post_type]) && $exclude_data[$post_type] == "on" ) {
		
			$display = false;
			
		}		
		
		$post_content = ""; // make sure post_content is empty ( especially fromt he previous loop )
	
		// Display The Content Based on its Conditions
		if ($display == true){

			$post_content = $section->post_content;

			// call actions here for things like removing filters
			// from the "thmplt_content" especially ones added from "the_content" 	
			do_action('thmplt_section_content');
			
			// Call actions here for specific content areas
			// such as a Section content "thmplt_content_pid-11" 
			do_action('thmplt_section_content_pid-'. $page_ID );	 
		
			// Apply filters from "thmplt_content"
			$post_content = apply_filters('thmplt_section_content', $post_content );
			// Apply filters Specifically to the running content area 
			$post_content = apply_filters('thmplt_section_content_pid-'.$page_ID , $post_content );	
			wp_reset_postdata();
						
				
			$section_wrap_open = apply_filters('thmplt_section_wrap_open', NULL, $section->ID );
			
			
			if ( !empty($thmplt_section_settings['id']) ){ 
				$section_wrap_open = str_replace("{id}", $thmplt_section_settings['id'], $section_wrap_open );
				$secid = $thmplt_section_settings['id'];
			} else { 
				$section_wrap_open = str_replace("{id}", $section->post_name, $section_wrap_open );	
				$secid = $section->post_name;						
			} 

			// Get "classes" taxonomy 
			$classes = wp_get_post_terms($section->ID, 'thmplt_section_classes', array( "fields" => "names" ) );
			if (is_array($classes)) {
				
				$thmplt_section_settings['class'] .= " " . implode(" ", $classes);
				
			}
			

			if ( !empty($thmplt_section_settings['class']) ){ 
				$section_wrap_open = str_replace("{class}", $thmplt_section_settings['class'], $section_wrap_open );
			}
		
			
			$section_wrap_close = apply_filters('thmplt_section_wrap_close', NULL,$section->ID );
			//$section_wrap_close = str_replace("{id}", $section->name, $section_wrap_open );			

			$sb_output = $section_wrap_open . $post_content . $section_wrap_close;

			// Get the settings 
			$custom = get_post_custom($section->ID);
			@$thmplt_section_bg_settings = unserialize($custom['thmplt_section_bg_settings'][0]);


			if ( has_post_thumbnail($section->ID) || !empty($thmplt_section_bg_settings['bgcolor']) ) { 	
				
					global $thmplt_section_footer;
					$style = "";

					//$style = "<style scoped> \n";
/*					if ( has_post_thumbnail($section->ID) ) {
						$imgurl = wp_get_attachment_url ( get_post_thumbnail_id( $section->ID ) );
						$style .= "#".$secid." { background-image: url(".$imgurl." )} \n";
					}

					if ( !empty( $thmplt_section_bg_settings['bgcolor']) && $thmplt_section_bg_settings['bgcolor'] != "-" ) { 
						$style .= "#".$secid." { background-color: ".$thmplt_section_bg_settings['bgcolor']."} \n";
					} 
				
					if ( !empty( $thmplt_section_bg_settings['bgsize']) && $thmplt_section_bg_settings['bgsize'] != "-" ) { 
						$style .= "#".$secid." { background-size: ".$thmplt_section_bg_settings['bgsize']."} \n";
					} 
					if ( !empty( $thmplt_section_bg_settings['bgposition']) && $thmplt_section_bg_settings['bgposition'] != "-" ) { 
						$thmplt_section_bg_settings['bgposition'] = str_replace("-", " ", $thmplt_section_bg_settings['bgposition'] );
						$style .= "#".$secid." { background-position: ".$thmplt_section_bg_settings['bgposition']."} \n";
					} 
					if ( !empty( $thmplt_section_bg_settings['bgattachment']) && $thmplt_section_bg_settings['bgattachment'] != "-" ) { 
						$style .= "#".$secid." { background-attachment: ".$thmplt_section_bg_settings['bgattachment']."} \n";
					} 
					if ( !empty( $thmplt_section_bg_settings['bgrepeat']) && $thmplt_section_bg_settings['bgrepeat'] != "-" ) { 
						$style .= "#".$secid." { background-repeat: ".$thmplt_section_bg_settings['bgrepeat']."} \n";
					} */

					// If the OPACITY is set.. then change the CSS to pseudo 
					// else use regular background css
					if ( !empty( $thmplt_section_bg_settings['bgopacity']) && $thmplt_section_bg_settings['bgopacity'] != "-" ) {				
						if ( has_post_thumbnail($section->ID) ) {
							$imgurl = wp_get_attachment_url ( get_post_thumbnail_id( $section->ID ) );
							$style .= "#".$secid."{position:relative} \n";
							$style .= "#".$secid." .container {position:relative;z-index:2} \n";
							$style .= "#".$secid."::before { 
								background-image: url(".$imgurl." );
								content:' ';position:absolute;
								top:0;left:0;bottom:0;right:0;z-index:1;
							} \n";
						}
						if ( !empty( $thmplt_section_bg_settings['bgposition']) && $thmplt_section_bg_settings['bgposition'] != "-" ) { 
							$thmplt_section_bg_settings['bgposition'] = str_replace("-", " ", $thmplt_section_bg_settings['bgposition'] );
							$style .= "#".$secid."::before { background-position: ".$thmplt_section_bg_settings['bgposition']."} \n";
						} 
						if ( !empty( $thmplt_section_bg_settings['bgsize']) && $thmplt_section_bg_settings['bgsize'] != "-" ) { 
							$style .= "#".$secid."::before { background-size: ".$thmplt_section_bg_settings['bgsize']."} \n";
						} 				
						if ( !empty( $thmplt_section_bg_settings['bgattachment']) && $thmplt_section_bg_settings['bgattachment'] != "-" ) { 
							$style .= "#".$secid."::before { background-attachment: ".$thmplt_section_bg_settings['bgattachment']."} \n";
						} 
						if ( !empty( $thmplt_section_bg_settings['bgrepeat']) && $thmplt_section_bg_settings['bgrepeat'] != "-" ) { 
							$style .= "#".$secid."::before { background-repeat: ".$thmplt_section_bg_settings['bgrepeat']."} \n";
						}
						if ( !empty( $thmplt_section_bg_settings['bgopacity']) && $thmplt_section_bg_settings['bgopacity'] != "-" ) { 
							$style .= "#".$secid."::before { opacity: ".$thmplt_section_bg_settings['bgopacity']."} \n";
						}				
					} else {
						if ( has_post_thumbnail($section->ID) ) {
							$imgurl = wp_get_attachment_url ( get_post_thumbnail_id( $section->ID ) );
							$style .= "#".$secid." { background-image: url(".$imgurl." )} \n";
						}

						if ( !empty( $thmplt_section_bg_settings['bgsize']) && $thmplt_section_bg_settings['bgsize'] != "-" ) { 
							$style .= "#".$secid." { background-size: ".$thmplt_section_bg_settings['bgsize']."} \n";
						} 
						if ( !empty( $thmplt_section_bg_settings['bgposition']) && $thmplt_section_bg_settings['bgposition'] != "-" ) { 
							$thmplt_section_bg_settings['bgposition'] = str_replace("-", " ", $thmplt_section_bg_settings['bgposition'] );
							$style .= "#".$secid." { background-position: ".$thmplt_section_bg_settings['bgposition']."} \n";
						} 
						if ( !empty( $thmplt_section_bg_settings['bgattachment']) && $thmplt_section_bg_settings['bgattachment'] != "-" ) { 
							$style .= "#".$secid." { background-attachment: ".$thmplt_section_bg_settings['bgattachment']."} \n";
						} 
						if ( !empty( $thmplt_section_bg_settings['bgrepeat']) && $thmplt_section_bg_settings['bgrepeat'] != "-" ) { 
							$style .= "#".$secid." { background-repeat: ".$thmplt_section_bg_settings['bgrepeat']."} \n";
						} 

					} // End else/if
				
					// universal setting for the BG color
					if ( !empty( $thmplt_section_bg_settings['bgcolor']) && $thmplt_section_bg_settings['bgcolor'] != "-" ) { 
						$style .= "#".$secid." { background-color: ".$thmplt_section_bg_settings['bgcolor']."} \n";
					} 
				


 				
				
				

				
				
					//$style .= "</style> \n";
				
					if (!array( $thmplt_section_footer )){
						$thmplt_section_footer = array();
					}
					$thmplt_section_footer[] = $style;
			}
	

			#$sb_output = $style . $sb_output;
			$sb_output = $sb_output;


		} else {
			
			$sb_output = NULL;
			
		}#end If 
			
	//endwhile;				

	wp_reset_postdata(); // ALWAYS COMES BEFORE AND RETURN OR ESCAPE
	return $sb_output;		

}#End thmplt_section_content



function thmplt_section_build_footer(){
	global $thmplt_section_footer;
		
	
		if (is_array($thmplt_section_footer)) {
			$footer_style = "<!-- thmplt footer styles --> \n <style scoped> \n";
			foreach ( $thmplt_section_footer as $t ){
				$footer_style .= $t ."\n";
			}
			$footer_style .= "</style> \n <!-- end thmplt footer styles --> \n";

			echo $footer_style;
		}
}
add_action('wp_footer','thmplt_section_build_footer' );



/**
 * Creates terms for the section tax based on the section location it is in
 * Function runs only on the admin results page 
 */
function thmplt_section_screen() {

    $current_screen = get_current_screen();
    if( $current_screen ->id === "edit-thmplt_section" ) {
		
		$sections = get_posts( array( "post_type" => "thmplt_section" ) );
		foreach ( $sections as $s ) { 
			//var_dump($s);
			wp_set_object_terms( $s->ID, NULL , "thmplt_section_tax");
			
		} 
		
		global $thmplt_register_section;
		do_action('thmplt_init_section');
		$thmplt_section = get_option('thmplt_section');
		
		foreach ( $thmplt_register_section as $id => $arg ) {
			
			if (!empty($thmplt_section[$arg['hook']]) && is_array($thmplt_section[$arg['hook']]) ){
				foreach ( $thmplt_section[$arg['hook']] as $listitem ){			
				
					$object_id = $listitem; // Post ID
					//$terms = array( $arg['label'] ) ;
					$taxonomy = "thmplt_section_tax";					
					$terms = array_merge( wp_get_object_terms( $object_id, $taxonomy, array( 'fields' => 'names' )), array( $arg['label'] )  );
					
					wp_set_object_terms( $object_id, $terms, $taxonomy);
					
				}
			}
		}
    }
}#End thmplt_section_screen 
add_action( 'current_screen', 'thmplt_section_screen' );



/**
 * Set the default order of sections by name in the admin Dashboard
 * Sort posts in wp_list_table by column in ascending or descending order.
 */
function thmplt_section_default_order($query){
    /* 
        Set post types.
        _builtin => true returns WordPress default post types. 
        _builtin => false returns custom registered post types. 
    */
    $post_types = get_post_types(array('_builtin' => false), 'names');
    /* The current post type. */
    $post_type = $query->get('post_type');
	/* Effects only a specific post type in the array of post types. */
	if(in_array($post_type, $post_types) && $post_type == 'thmplt_section'){
        /* Post Column: e.g. title */
        if($query->get('orderby') == ''){
            $query->set('orderby', 'title');
        }
        /* Post Order: ASC / DESC */
        if($query->get('order') == ''){
            $query->set('order', 'ASC');
        }
    }
}

// Add action only if within the admin panel 
if(is_admin()){
    add_action('pre_get_posts', 'thmplt_section_default_order');
}


/**
 * Add all filters from "the_content" and apply it to "thmplt_section_content"
 * for compatibility reasons
 */
	global $wp_filter;
	foreach ($wp_filter['the_content'] as $priority => $filter){
		foreach ($filter as $func) {	
			add_filter('thmplt_section_content', $func['function'], $priority, $func['accepted_args']);		
		}
	}


/**
 * Create the include/exclude boxes for 
 */
function thmplt_add_post_types_to_sections($include_data, $type="include"){

	$args = array(
	   'public'   => true,
	   'hierarchical' => true
	  // '_builtin' => false
	);

	$page_types = get_post_types( $args, 'objects' );	

	foreach ( $page_types as $pgt => $pob) {
		thmplt_section_create_check_boxes( array ( "post_type"=> $pgt, "label"=> $pob->labels->name, "style"=> "page", "type" => $type ), $include_data);
	}

	echo "<hr style='border-color:#ccc'/><strong>Post Types:</strong><br><br>";
	
	$args = array(
	   'public'   => true,
	   'hierarchical' => false
	  // '_builtin' => false
	);

	$post_types = get_post_types( $args, 'objects' );

	foreach ( $post_types as $pt => $ob) {
	   
		@$current_checked = ($include_data[$pt] == "on")? "checked":NULL;

		echo "<label style='padding:0 15px 0 0 '>";
		
			// create the input check box 
			if ($type == "include"){ 
				echo "<input type='checkbox' name='include[".$pt."]' ".$current_checked."> ";
			} elseif ($type == "exclude") {
				echo "<input type='checkbox' name='exclude[".$pt."]' ".$current_checked."> ";			
			}		
		
			echo $ob->labels->name . " <em>[". $pt ."]</em>";
		echo "</label>";
		
		$current_checked = NULL;
	   
	}
}