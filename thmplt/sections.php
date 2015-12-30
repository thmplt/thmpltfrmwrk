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
		'supports' => array('title','editor','revisions', /*'thumbnail'*/ )
	
	);
	register_post_type( "thmplt_section", $args ) ;



/**
 * Create Metabox for thmplt_section
 */
function thmplt_section_meta(){
	add_meta_box("thmplt_section_meta_box", "Section Display Conditions", "thmplt_section_html", "thmplt_section", "normal", "high");
}
add_action("admin_init", "thmplt_section_meta");


// mnsbcontent HTML
function thmplt_section_html() {
	echo "<style> #edit-slug-box {display:none!important} </style>";
	global $post;
	$custom = get_post_custom($post->ID);
	$include_data = !empty($custom['include'][0])? unserialize($custom['include'][0]): NULL ;
	$exclude_data = !empty($custom['exclude'][0])? unserialize($custom['exclude'][0]): NULL ;	
	
	// Selections for all pages and children pages. 
	echo "<strong>Select which pages this content should display on</strong><br /><br />";
	@$all_checked = ($include_data['all'] == "on")? "checked":NULL;
	@$all_children_checked = ($include_data['all_children'] == "on")? "checked":NULL;	
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
	
} # End Function 


// Save mnsbcontent
function save_thmplt_section(){
	if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) ) {  return; }
	if ( isset($_REQUEST['bulk_edit']) ) {  return; }	
	if ( !empty($_POST['post_type']) && $_POST['post_type'] != 'thmplt_section') { return; }
	if ( empty($_POST['post_type'])) { return; }	
	global $post;
	update_post_meta($post->ID, "include", $_POST["include"]);
	update_post_meta($post->ID, "exclude", $_POST["exclude"]);	
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
			$section_wrap_open = str_replace("{id}", $section->post_name, $section_wrap_open );

			$section_wrap_close = apply_filters('thmplt_section_wrap_close', NULL,$section->ID );
			//$section_wrap_close = str_replace("{id}", $section->name, $section_wrap_open );			

			$sb_output = $section_wrap_open . $post_content . $section_wrap_close;

		} else {
			
			$sb_output = NULL;
			
		}#end If 
			
	//endwhile;				

	wp_reset_postdata(); // ALWAYS COMES BEFORE AND RETURN OR ESCAPE

	return $sb_output;		

	

}




/*function thmplt_section_content_add_to_dynamic_Section( $index ){
	//global $post;
	if ($index == "thmplt_dynamic_Section"){ 
		echo  thmplt_section_content();
	}
	
}
add_action ('dynamic_Section_before','thmplt_section_content_add_to_dynamic_Section');*/




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