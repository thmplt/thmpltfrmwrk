<?php
/**
 * Custom Post type and settings for 
 * Bootstrap carousel
 */


	$args = array ( 
		"public" => true, 
		
		'labels' => array(
			'name' => 'thmplt Carousel', // general name for the post type, usually plural
			'singular_name' => 'Carousel', // Singular name for one object of this post type
			'add_new' => 'Add New Slide', 
			'add_new_item' => 'New Slide',
			'edit_item' => 'Edit Slide',
			'new_item' => 'New Slide',
			'view_item' => 'View Slide',
			'search_items' => 'Search Slides',
			'not_found' =>  'No Slides Found',
			'not_found_in_trash' => 'No Slides Found in Trash' 
		),
		'public' => false,
		'show_ui' => true,		
		//'show_in_menu' => 'thmplt-options', // Put it in the "theme egg tab"
		'menu_icon' => THMPLT_SVG_B64,
		'hierarchical' => false, // true to treat as pages... can have parent/children	
		'has_archive' => false, // archive/results page (can be set to slug of archive)
		'rewrite' => false, 
		'show_in_nav_menus' => false,
		'supports' => array('title','editor','revisions', 'thumbnail' )
	
	);
	register_post_type( "thmplt_carousel", $args ) ;



/*	// UPDATE THE COUNT EVERYTIME THE POST IS UPDATED
	// There is a bug in WP that doesnt recount the custom catergories
	// after a case is "trashed" this accounts for that 
	add_action('init', 'thmplt_carousel_update_trash_count'); //trashed_post
	function thmplt_carousel_update_trash_count(){
		if ($_GET['trashed'] >= 1 || $_GET['untrashed'] >= 1){
			$taxonomy = get_taxonomy('mnfaqcat'); //get_object_taxonomies('mngallery', 'names');
			$terms 	= get_terms('mnfaqcat', array('get'=>'all')); // GET ALL TERMS
			$term_id = array(); 
			foreach ($terms as $termx){
				$term_id[] = $termx->term_taxonomy_id; //Convert Terms to array with term taxonomy id's
			}#End Foreach
			_update_post_term_count($term_id,$taxonomy);
		}#End If
	}#End Function mngallery_update_trash_count*/



add_action ('admin_menu','thmplt_carousel_options');
function thmplt_carousel_options() {
	$parent_slug = "edit.php?post_type=thmplt_carousel";
	//$parent_slug = "thmplt-options";
	$page_title = "Carousel Options";
	$menu_title = "Carousel Options";
	$capability = "publish_posts";
	$menu_slug = "carousel-options";	
	$function = "carousel_options_callback";		
	add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
} 



/**
 * Callback creates the carousel options/settings page
 *
 */
function carousel_options_callback () {
	
	$default_number_of_slides = 5;
	
	$thmplt_carousel_options = get_option('thmplt_carousel_options');
	$thmplt_carousel_slides = get_option('thmplt_carousel_slides');
	if (!empty($_POST)){ 
		$thmplt_carousel_options = $_POST['thmplt_carousel_options']; 
		$thmplt_carousel_slides = $_POST['thmplt_carousel_slides']; 		

	}
	
	$number_of_slides = empty($thmplt_carousel_options['number_of_slides']) ? $default_number_of_slides : $thmplt_carousel_options['number_of_slides'];
	
	echo "<div class='wrap'>";
		echo "<h2>Carousel Settings</h2>";
		
		echo "<form method='post' name='options'>";
			echo "<table class='form-table' >";
				echo "<tbody>";


					/**
					 * HTML/Option for the slides 
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='blogname'>Slide Amount</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>Choose how many slides the carousel will hold.</label><br /><br />";
					
						echo "<select name='thmplt_carousel_options[number_of_slides]'>";
						/**
						 * loop creates the drop downs for selecting the amount of slides go on the front page
						 */
						for ( $as=1; $as <= 15; $as++ ) { 
							
							$as_selected = ($as == $number_of_slides) ? "selected": NULL;
							echo "<option value='".$as."' ".$as_selected."  >".$as."</option>";
					
						}
						echo "</select>";
						
						echo "</fieldset>";
					echo "</td>";
					echo "</tr>";

				
					/**
					 * HTML/Option for the slides 
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='blogname'>Slides</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>Choose which slides to show on the front page carousel</label><br /><br />";
					
						/**
						 * loop creates the drop downs for selecting which slides go on the front page
						 */
						for ( $s=1; $s <= $number_of_slides; $s++ ) { 
						
							echo "<strong> Slide " .$s . "</strong> ";
						@	thmplt_carousel_dropdown( "thmplt_carousel_slides[slide". $s ."]" , $thmplt_carousel_slides['slide'.$s ] );
							echo "<br />";
						}
						
						echo "</fieldset>";
					echo "</td>";
					echo "</tr>";



					/**
					 * HTML/Option for indicators
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='indicators'>Indicators</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>The bullet navigation</label><br /><br />";
						$indicator_options = array ( "on", "off");
						
						echo "<select name='thmplt_carousel_options[indicators]' >";
						foreach ( $indicator_options as $io ) { 
						
							$io_selected = ($io == $thmplt_carousel_options['indicators']) ? "selected": NULL;
							echo "<option value='".$io."' ".$io_selected." >".ucfirst($io)."</option>";							
						
						} 
						echo "</select>";

						
						echo "</fieldset>";
					echo "</td>";
					echo "</tr>";


					/**
					 * HTML/Option for controls ( left and right arrows) 
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='controls'>Controls</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>The left and right arrows</label><br /><br />";
						$controls_options = array ( "on", "off");
						
						echo "<select name='thmplt_carousel_options[controls]' >";
						foreach ( $controls_options as $co ) { 
						
							$co_selected = ($co == $thmplt_carousel_options['controls']) ? "selected": NULL;
							echo "<option value='".$co."' ".$co_selected." >".ucfirst($co)."</option>";							
						
						} 
						echo "</select>";

						
						echo "</fieldset>";
					echo "</td>";
					echo "</tr>";



					/**
					 * HTML/Option for controling background images
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='images'>Background Images</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>How to handle the background image of each slide</label><br /><br />";
						$image_options = array ( "normal", "full-width", "constrained");
						
						echo "<select name='thmplt_carousel_options[imageoptions]' >";
						foreach ( $image_options as $io ) { 
						
							$io_selected = ($io == $thmplt_carousel_options['imageoptions']) ? "selected": NULL;
							echo "<option value='".$io."' ".$io_selected." >".ucfirst($io)."</option>";							
						
						} 
						echo "</select>";

						
						echo "</fieldset>";
					echo "</td>";
					echo "</tr>";
					
					
					/**
					 * HTML/Option for controling slide intervals
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='intervals'>Interval</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>The amount of time to delay between automatically cycling an item. 
						If false, carousel will not automatically cycle.</label><br /><br />";
						$interval_options = array ( "0", "3", "5", "8", "10", "15", "20" );
						
						echo "<select name='thmplt_carousel_options[interval]' >";
						foreach ( $interval_options as $io ) { 
						
							$io_selected = ($io == $thmplt_carousel_options['interval']) ? "selected": NULL;
							echo "<option value='".$io."' ".$io_selected." >".ucfirst($io)."</option>";							
						
						} 
						echo "</select>";

						
						echo "</fieldset>";
					echo "</td>";
					echo "</tr>";					


					/**
					 * HTML/Option for controling pause control
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='pause'>Pause</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>Pauses the cycling of the carousel on mouseenter and resumes the cycling of the carousel on mouseleave.</label><br /><br />";
						$pause_options = array ( "none", "hover" );
						
						echo "<select name='thmplt_carousel_options[pause]' >";
						foreach ( $pause_options as $po ) { 
						
							$po_selected = ($po == $thmplt_carousel_options['pause']) ? "selected": NULL;
							echo "<option value='".$po."' ".$po_selected." >".ucfirst($po)."</option>";							
						
						} 
						echo "</select>";

						
						echo "</fieldset>";
					echo "</td>";
					echo "</tr>";


					/**
					 * HTML/Option for slide or fade transitions
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='transition'>Transition</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>What effects </label><br /><br />";
						$transition_options = array ( "slide", "fade" );
						
						echo "<select name='thmplt_carousel_options[transition]' >";
						foreach ( $transition_options as $to ) { 
						
							$to_selected = ($to == $thmplt_carousel_options['transition']) ? "selected": NULL;
							echo "<option value='".$to."' ".$to_selected." >".ucfirst($to)."</option>";							
						
						} 
						echo "</select>";

						
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
		update_option( 'thmplt_carousel_options', $_POST['thmplt_carousel_options'] );
		update_option( 'thmplt_carousel_slides', $_POST['thmplt_carousel_slides'] );			
		
	}#End if (!empty($_POST))
	


	
}




/**
 * Create a dropdown of the carousel post types
 * so it can be selected to show on the front page 
 */
function thmplt_carousel_dropdown($name, $selected_id){
	

	$args = array('sort_column' => 'post_title', 'post_type' => 'thmplt_carousel', 'post_status' => 'publish', 'posts_per_page' => -1);
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
 * Create the slides that will be shown on the front page
 */
function thmplt_do_carousel_slides($id, $echo = true ) { 


	$thmplt_carousel_options = get_option('thmplt_carousel_options');
	$thmplt_carousel_slides = get_option('thmplt_carousel_slides');
	
	$s = 0;
	$classes = "";
	
	// If there are no slides... return false
	if ( !is_array( $thmplt_carousel_slides ) ) { return false; }	
	
	// If there are no options, then set it to be an empty array 	
	if ( !is_array( $thmplt_carousel_options ) ) { $thmplt_carousel_options = array(); }
	
	$options = array ( 
		
		"indicators" => "on",
		"controls" => "on",
		"imageoptions" => "normal",
		"interval" => "3",
		"pause" => "none",
		"transition" => "slide"
	
	);

	$options = array_merge($options, $thmplt_carousel_options );

	$html = "";

	/**
	 *  Add the hover attribute
	 */		
	if ($options['pause'] == "hover" ) { 

		$html .=  "<script type='text/javascript'> \n";
			$html .=  "$(document).ready(function(){ 
			
				$('#".$id."').mouseenter(function() {
					$(this).carousel('pause');
				}).mouseleave(function() {
					$(this).carousel('cycle');
				}); 
			
			});";
		$html .=  "</script> \n \n";

	}
	
	// Appened which transition we want 
	$classes .= "carousel-" . $options['transition'];
	

	$html .= "<div id='".$id."' class='carousel slide ".$classes."' ";

		/**
		 * Add the interval attribute
		 */		
		$interval = $options['interval'] * 1000;
		$html .=  " data-interval='". $interval ."' ";


	$html .=  " data-ride='carousel' > \n\n";

	/**
	 * Create the indicators if they are turned on in the settings
	 * they are on 
	 */	
	if ( $options['indicators'] == "on" ) {

		$html .=  "<!-- Indicators --> \n";
		$html .=  "<ol class='carousel-indicators'> \n";
		
		foreach ($thmplt_carousel_slides as $slide ) { 

			if ( $slide != "none" ) { 
			
				// Build the indicators list items 			
				$html .=  "\t <li data-target='#".$id."' data-slide-to='".$s."'";
					
					// if its the first one, give it a class of active 	
					if ($s == 0 ) { $html .=  " class='active'"; }
				
				$html .=  " ></li> \n";
				
				$s = $s + 1;
			
			} 
		}
		
		$html .=  "</ol> \n \n";
		
	} #end if 



	$s = 0;
	/**
	 * Create the slides 
	 */
	$html .=  "<!-- Wrapper for slides --> \n";
	$html .=  "<div class='carousel-inner'> \n";
	 
	foreach ($thmplt_carousel_slides as $slide ) { 
	
		if ( $slide != "none" ) { 
			
			$car_post = get_post($slide);
		
			$html .=  " \t <div class='item carousel-". $car_post->ID . " ";
			// if its the first one, give it a class of active 	
			if ($s == 0 ) { $html .=  " active"; }			
			$html .=  "' > \n";
			
			
				/**
				* Check if a featured image was set, if not then use the bootstrap default grascale image
				*/			
				if ( has_post_thumbnail($car_post->ID) ) { 
				
					$imgurl = wp_get_attachment_url ( get_post_thumbnail_id( $car_post->ID ) );
				
				if ( $options['imageoptions'] == "constrained" ) { 
				
					$html .=  "<div class='imageslide constrained' style='background: url(".$imgurl.") center center no-repeat;'>";
					$html .=  "</div>";
					
				} elseif ( $options['imageoptions'] == "full-width" )  { 
				
					$html .=  "<img src='".$imgurl."' class='imageslide fullwidthimg' \>";
				
				} else { 
				
					$html .=  get_the_post_thumbnail( $car_post->ID , 'full' ); 				
				
				} 
			
			
			} else {
				
				$html .=  "<img alt='Third slide' src='data:image/gif;base64,R0lGODlhAQABAIAAAFVVVQAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='>";	
				
			}// End if has_post_thumbnail 
			
			
			$html .=  " \t \t<div class='container'> \n";				
			$html .=  " \t \t<div class='carousel-caption'> \n";	
				$html .=  "\t \t \t". wpautop($car_post->post_content) . "\n";
			$html .=  "\t \t </div> \n";	
			$html .=  "\t \t </div> \n";				

			$html .=  "\t </div> \n";
			
			$s = $s + 1;
		
		} 
	}
	
	$html .=  "</div> \n \n"; // end the slides div


	/**
	 * Create the controls if they are turned on in the seetings
	 * they are on by default
	 */	
	if ( $options['controls'] == "on" ) {

		$html .=  "<!-- Controls --> \n";
		
		$html .=  "	<a class='left carousel-control' href='#".$id."' role='button' data-slide='prev'>
	    			<span class='glyphicon glyphicon-chevron-left'></span>
			  	</a> \n
			";
		$html .=  "	<a class='right carousel-control' href='#".$id."' role='button' data-slide='next'>
    				<span class='glyphicon glyphicon-chevron-right'></span>
  				</a> \n
			";			
	} #end if 


	$html .=  "</div> \n \n"; // End closing carousel

	
	if ($echo == true ) {
		echo $html;
	} else { 
		return $html;
	}
	
}


/**
 * Create the javascript to control the carousel 
 */
function thmplt_bootstrap_carousel_shortcode($atts){

		extract( shortcode_atts( array(
		'ID' => 'tpf_carousel', // 
		//'excerpt' => ''
	), $atts ) );
	
	return thmplt_do_carousel_slides($ID, false);
	
}
add_shortcode('tpf_carousel','thmplt_bootstrap_carousel_shortcode');




/**
 * Create the javascript to control the carousel 
 */
function thmplt_bootstrap_carousel($atts){

	/**
	 * Create the controls if they are turned on in the seetings
	 * they are on by default
	 */	
	if ( $options['controls'] == "on" ) {

		echo "<!-- Controls --> \n";
		
		echo "	<a class='left carousel-control' href='#".$id."' role='button' data-slide='prev'>
	    			<span class='glyphicon glyphicon-chevron-left'></span>
			  	</a> \n
			";
		echo "	<a class='right carousel-control' href='#".$id."' role='button' data-slide='next'>
    				<span class='glyphicon glyphicon-chevron-right'></span>
  				</a> \n
			";			
	} #end if 
	
	
	
}



/**
 * Move the featured image box to the main panel 
 */
add_action('do_meta_boxes', 'thmplt_move_featured_image_meta_box');
function thmplt_move_featured_image_meta_box() {

	remove_meta_box( 'postimagediv', 'thmplt_carousel', 'side' );

	add_meta_box('postimagediv', __('Background Image'), 'post_thumbnail_meta_box', 'thmplt_carousel', 'normal', 'high');

}


?>