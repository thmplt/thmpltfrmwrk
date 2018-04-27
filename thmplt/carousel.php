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
function thmplt_do_carousel_slides($id, $echo = true, $legacy = 'on' ) { 


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
			$html .=  "jQuery(document).ready(function(){ 
			
				jQuery('#".$id."').mouseenter(function() {
					jQuery(this).carousel('pause');
				}).mouseleave(function() {
					jQuery(this).carousel('cycle');
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


	if ($options['pause'] == "hover" ) {
		#$html .=  " data-pause='true' ";
	} else {
		$html .=  " data-pause='false' ";
	}
	
	
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
		
			$custom = get_post_custom($car_post->ID);
			@$slide_set = unserialize($custom['thmplt_carousel_slide_settings'][0]);
			
			
			$yt = thmplt_extract_yt_video_id($slide_set['video']);
			
			$slideid = !empty($slide_set['ID'])? $slide_set['ID'] : "slide-".$car_post->ID;
			
			
			$html .= " \t <div ";
			$html .= !empty($slideid)? "id='".$slideid."' ":"";
			$html .= " class='item carousel-". $car_post->ID . " ".$slide_set['class']." ";
			// if its the first one, give it a class of active 	
			if ($s == 0 ) { $html .=  " active"; }
			$html .=  "' ";
			$html .= !empty($slide_set['interval'])? " data-interval='".($slide_set['interval']*1000)."' ":"";
			
			//$html .= !empty($slide_set['height'])? " style='height:".$slide_set['height']."px'":"";
			
			$html .=  " > \n";
			

			//.1666666
			//$margintop = "52.5$";
			
			if (!empty($yt)){
				
				// iF Responsive 
				if(!empty($slide_set['vresponsive']) && $slide_set['vresponsive'] == "yes"){ 
					
					$heightratio = ($slide_set['height'] / $slide_set['width']) * 100;
					$scale = empty($slide_set['scale']) ? "100" : str_replace("%", "", $slide_set['scale']);
					$scaleoffset = (100 - $scale)/2;					
					$html .= "
					<style scoped>
						#".$slideid." .video-container {width:100%;height:0;padding-bottom:".$heightratio."%}
						#".$slideid." .video-container iframe {height:".$scale."%;top:".$scaleoffset."%}
						#".$slideid." .video-container iframe {width:".$scale."%;left:".$scaleoffset."%}
					</style>";
				}
				
				$html .= "<!-- YT ID: ".$yt." -->"; //width='560' height='315'
				$html .= "<div class='video-container ";
				$html .= ($slide_set['vresponsive'] == "yes") ? " embed-responsive ": "";
				$html .= "'><iframe id='#".$slideid."-video' class='carousel-video position-center' ";
				
				$html .= (!empty($slide_set['height']))? " height='".$slide_set['height']."'":"";
				$html .= (!empty($slide_set['width']))? " width='".$slide_set['width']."'":"";
				
				//$slide_set['sound'] = "no";
				
				$mute = (!empty($slide_set['sound']) && $slide_set['sound'] == "no")? "1" :"0";
				
				$src_sets = "?rel=0&controls=0&showinfo=0&disablekb=0&autoplay=1&loop=1&mute=".$mute."&playlist=".$yt;
				
				$html .= " src='//www.youtube.com/embed/".$yt.$src_sets."' frameborder='0' allow='autoplay; encrypted-media' volume='0' allowfullscreen> </iframe></div>";
				$html .= "<div class='tpf-videomask'></div>";
				
/*				$html .= "
				<script>
					var myVideo =  iframe.getElementById('".$slideid."-video'); 
					myVideo.mute();
				</script>
				";*/
				
			} else {			
				/**
				* Check if a featured image was set, if not then use the bootstrap default grascale image
				*/		
				$pictures="";
				$custom = get_post_custom($car_post->ID);
				@$slide_set = unserialize($custom['thmplt_carousel_slide_images'][0]);			
				
				if (has_post_thumbnail($car_post->ID) && empty($slide_set['main'])){
					$slide_set['main'] = get_the_post_thumbnail_url($car_post->ID);
				} 

				if (!empty($slide_set)){
					$slide_set = array_reverse($slide_set);
					foreach ($slide_set as $key => $img ){
						if (!empty($img)){
							$key = ($key == "main")? "2560":$key;							
							$sz = str_replace("p","", $key);
							$pictures .= "<source media='(max-width: ".$sz."px)' srcset='".$img."'> \n";
						}
					}
				}
				
				if ( !empty($slide_set['main'])) { 

					$imgurl = $slide_set['main'];//wp_get_attachment_url ( get_post_thumbnail_id( $car_post->ID ) );

					if ( $options['imageoptions'] == "constrained" ) { 

						$html .=  "<div class='imageslide constrained' style='background: url(".$imgurl.") center center no-repeat;'>";
						$html .=  "</div>";

					} elseif ( $options['imageoptions'] == "full-width" )  { 
						$html .= "<picture>";
							$html .= $pictures;
							$html .= "<img src='".$imgurl."' class='imageslide fullwidthimg' >";
						$html .= "</picture>";
					} else { 
						
						$html .= "<picture>";
							$html .= $pictures;
							$html .= "<img src='".$imgurl."' class='imageslide'  >";
						$html .= "</picture>";						
						
						//$html .=  get_the_post_thumbnail( $car_post->ID , 'full' ); 				
					} 

				} else {

					$html .=  "<img alt='Carousel Slide' src='data:image/gif;base64,R0lGODlhAQABAIAAAFVVVQAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='>";	

				}// End if has_post_thumbnail 

			}

			
			if ( !empty($car_post->post_content)){
			
				if ($legacy == 'on' ){
					$html .=  " \t \t<div class='container'> \n";				
					$html .=  " \t \t<div class='carousel-caption'> \n";
						$html .=  "\t \t \t". wpautop($car_post->post_content) . "\n";
						$html .=  "\t \t </div> \n";	
					$html .=  "\t \t </div> \n";
				}

				if ($legacy == 'off' ){
					$html .=  " \t \t<div class='caption-wrapper'> \n";
					$html .=  " \t \t<div class='container'> \n";				
					$html .=  " \t \t<div class='caption-box-wrapper container row'> \n";
					$html .=  " \t \t<div class='caption-box'> \n";
						$html .=  "\t \t \t". wpautop($car_post->post_content) . "\n";
					$html .=  "\t \t </div> \n";
					$html .=  "\t \t </div> \n";
					$html .=  "\t \t </div> \n";	
					$html .=  "\t \t </div> \n";			
				}
			} // if !empty($car_post->post_content)

			
			// Add an A TAG here 
			if (!empty($slide_set['href'])){
				$html .= "<a class='tpf-linkslide' href='".$slide_set['href']."'>&nbsp;</a>";
			}			
			
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


	// @todo check that data interval is set... if not, do not run this 
	
	$html .=  "<script type='text/javascript'> \n";
		 $html .=  "jQuery(document).ready(function(){ 
		 	var defaultInterval = jQuery('#".$id."').attr('data-interval');
			var activeInterval = jQuery('#".$id."').find('.item.active').attr('data-interval');
			if ( activeInterval ){
				jQuery('#".$id."').carousel({interval: activeInterval});
			}

			jQuery('#".$id."').on('slide.bs.carousel', function (e) {   

				var newInterval = jQuery(e.relatedTarget).attr('data-interval'); // next slide 
			
				if ( newInterval ) { 
					c = jQuery('#".$id."')
					opt = c.data()['bs.carousel'].options
					opt.interval= newInterval;
					c.data({options: opt})

				} else { 
					c = jQuery('#".$id."')
					opt = c.data()['bs.carousel'].options
					opt.interval= defaultInterval;
					c.data({options: opt})				
				}
			})
		});"; 
	$html .=  "</script> \n \n";		
	
	
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
		'legacy' => 'on'	
		//'excerpt' => ''
	), $atts ) );
	
	return thmplt_do_carousel_slides($ID, false, $legacy);
	
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

	//add_meta_box('postimagediv', __('Background Image'), 'post_thumbnail_meta_box', 'thmplt_carousel', 'normal', 'high');

}


/**
 * Create Metabox for thmplt_section
 */
function thmplt_carousel_slide_meta(){
	add_meta_box("thmplt_carousel_meta_box1", "Slide Settings", "thmplt_carousel_slide_settings_html", "thmplt_carousel", "normal", "high");
	add_meta_box("thmplt_carousel_meta_box2", "Slide Images", "thmplt_carousel_slide_settings_html2", "thmplt_carousel", "normal", "high");
}
add_action("admin_init", "thmplt_carousel_slide_meta");



/**
 * Thmplt Sections Settings 
 */
function thmplt_carousel_slide_settings_html() { 

	global $post;
	$custom = get_post_custom($post->ID);
	@$slide_set = unserialize($custom['thmplt_carousel_slide_settings'][0]);

	$set = "<style>
		.setwrap {display:block; clear:both;}
		.setwrap label, .setwrap input  {float:left;display:block;padding:3px 0; width:100%}
		.setwrap input, .setwrap textarea { width:99%; padding:5px 4px}
		.setwrap select { width:99%; padding:5px 4px; height:31px}
		.setwrap textarea{ height:200px}
		.setwrap .fifth { width:20% }		
		.setwrap .quater { width:25% }
		.setwrap .third { width:33% }			
		.setwrap .half { width:50% }
		.setwrap .quater3 { width:75% }
		.setwrap hr  { float:left; width:100%; clear:both; margin:20px 0 }			
	</style>";	
	
	$set .= "<div class='setwrap'>";
	
	$set .= "<label class='quater'>ID: <input type='text' name='thmplt_carousel_slide_settings[id]' value='".$slide_set['id']."' /> </label>";
	$set .= "<label class='quater'>Class: <input type='text' name='thmplt_carousel_slide_settings[class]' value='".$slide_set['class']."' /> </label>";

	$set .= "<label class='quater'>Duration: <em class='small'>(in seconds) *empty value will use default</em><input type='text' name='thmplt_carousel_slide_settings[interval]' value='".$slide_set['interval']."' /> </label>";	

	//$set .= "<hr  />";
	$set .= "<label class='quater' >Href: <em class='small'>Link entire slide</em><input type='text' name='thmplt_carousel_slide_settings[href]' value='".$slide_set['href']."' /> </label>";	
		
	$set .= "<hr />";
	$set .= "<label ><strong>Video Settings:</strong> <em class='small'>These settings will overwrite image settings</em></label>";
	
	$set .= "<label class='' >Video src: <input type='text' name='thmplt_carousel_slide_settings[video]' value='".$slide_set['video']."' /> </label>";
	
	$set .= "<label class='fifth'>Width: <input type='text' name='thmplt_carousel_slide_settings[width]' value='".$slide_set['width']."' /> </label>";
	$set .= "<label class='fifth'>Height: <input type='text' name='thmplt_carousel_slide_settings[height]' value='".$slide_set['height']."' /> </label>";	
	
	$set .= "<label class='fifth'>Responsive: ";
	$set .= "<select name='thmplt_carousel_slide_settings[vresponsive]'>";
	$set .= !empty( $slide_set['vresponsive'] )  
	? "<option value='".$slide_set['vresponsive']."'>".$slide_set['vresponsive']."</option>"
	: "";
	$set .= "	
		<option value='yes'>yes</option>
		<option value='no'>no</option>
	";	
	$set .= "</select>";
	$set .= "</label>";

	$set .= "<label class='fifth'>Scale: <em>Default is 100</em><input type='text' name='thmplt_carousel_slide_settings[scale]' value='".$slide_set['scale']."' /> </label>";	
	
	$set .= "<label class='fifth'>Sound: ";
	$set .= "<select name='thmplt_carousel_slide_settings[sound]'>";
	$set .= !empty( $slide_set['sound'] )  
	? "<option value='".$slide_set['sound']."'>".$slide_set['sound']."</option>"
	: "";
	$set .= "	
		<option value='yes'>yes</option>
		<option value='no'>no</option>
	";	
	$set .= "</select>";
	$set .= "</label>";	
	

	/*<option value='inherit'>inherit</option> */	
	$set .=  "<div style='clear:both'></div>";
	$set .= "</div>";
	echo $set;

} 


/**
 * Thmplt Sections Settings 
 */
function thmplt_carousel_slide_settings_html2() { 

	global $post;
	$custom = get_post_custom($post->ID);
	@$slide_set = unserialize($custom['thmplt_carousel_slide_images'][0]);

	$set = "<style>
		.setwrap {display:block; clear:both;}
		.setwrap label, .setwrap input  {float:left;display:block;padding:3px 0; width:100%}
		.setwrap input, .setwrap textarea { width:99%; padding:5px 4px}
		.setwrap select { width:99%; padding:5px 4px; height:31px}
		.setwrap .half { width:50% }

		.imageinput {position:relative}
		.arrow_box {position:absolute;width:50%;right:0;bottom:100%;background: #000;border: 2px solid #b0bcf5;display:none;text-align:center}
		.arrow_box:after, 
		.arrow_box:before {
			top: 100%;left: 50%;border: solid transparent;
			content: ' ';height: 0;width: 0;position: absolute;	pointer-events: none;
		}
		.arrow_box:after {border-color: rgba(0, 0, 0, 0);	border-top-color: #000;	border-width: 10px;	margin-left: -10px;	}
		.arrow_box:before {	border-color: rgba(176, 188, 245, 0);border-top-color: #b0bcf5;border-width: 13px;margin-left: -13px;}
		.arrow_box img {max-width:100%;max-height:250px;height:auto;width:auto;}
		
		.imageinput:hover .arrow_box{display:block}
		.add_img {position:absolute;right:12px;top:50%;font-size:20px;font-weight:bold;text-decoration:none}
	</style>";	
	
	$set .= "<div class='setwrap'>";
	
	if (has_post_thumbnail() && empty($slide_set['main'])){
		$main_image = get_the_post_thumbnail_url();
	} else {
		$main_image = $slide_set['main'];
	}
	
	$set .= "<label > <em class='small'>Breakpoints are from large to small. Always use main image for best results.</em></label>";	
	
	
	$set .= "<label class='half imageinput'>Main: <em>Large Desktop monitors</em> <a href='#' class='add_img'>+</a>";
		$set .= "<input type='text' name='thmplt_carousel_slide_images[main]' value='".$main_image."'  />";
		$set .= (!empty($main_image))? "<div class='arrow_box'><img src='".$main_image."' /></div>":"";
	$set .= "</label>";
	
	$set .= "<label class='half imageinput'>1920: <em>Common desktop monitors, laptops</em> <a href='#' class='add_img'>+</a>";
		$set .= "<input type='text' name='thmplt_carousel_slide_images[p1920]' value='".$slide_set['p1920']."' />";
		$set .= (!empty($slide_set['p1920']))? "<div class='arrow_box'><img src='".$slide_set['p1920']."' /></div>":"";
	$set .= "</label>";	
	
	
	$set .= "<label class='half imageinput'>1200: <em>Large devices</em> <a href='#' class='add_img'>+</a>";
		$set .= "<input type='text' name='thmplt_carousel_slide_images[p1200]' value='".$slide_set['p1200']."' />";
		$set .= (!empty($slide_set['p1200']))? "<div class='arrow_box'><img src='".$slide_set['p1200']."' /></div>":"";
	$set .= "</label>";		
	
	$set .= "<label class='half imageinput'>992: <em>Medium devices</em> <a href='#' class='add_img'>+</a>";
		$set .= "<input type='text' name='thmplt_carousel_slide_images[p992]' value='".$slide_set['p992']."' />";
		$set .= (!empty($slide_set['p992']))? "<div class='arrow_box'><img src='".$slide_set['p992']."' /></div>":"";
	$set .= "</label>";	
	
	$set .= "<label class='half imageinput'>768: <em>Small devices</em> <a href='#' class='add_img'>+</a>";
		$set .= "<input type='text' name='thmplt_carousel_slide_images[p768]' value='".$slide_set['p768']."' />";
		$set .= (!empty($slide_set['p768']))? "<div class='arrow_box'><img src='".$slide_set['p768']."' /></div>":"";
	$set .= "</label>";

	$set .= "<label class='half imageinput'>576: <em>Small devices</em> <a href='#' class='add_img'>+</a>";
		$set .= "<input type='text' name='thmplt_carousel_slide_images[p576]' value='".$slide_set['p576']."' />";
		$set .= (!empty($slide_set['p576']))? "<div class='arrow_box'><img src='".$slide_set['p576']."' /></div>":"";
	$set .= "</label>";
	
	/*<option value='inherit'>inherit</option> */	
	$set .=  "<div style='clear:both'></div>";
	$set .= "</div>";
	echo $set;

} 


// Save 
function save_thmplt_carousel_slide(){
	if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) ) {  return; }
	if ( isset($_REQUEST['bulk_edit']) ) {  return; }	
	if ( !empty($_POST['post_type']) && $_POST['post_type'] != 'thmplt_carousel') { return; }
	if ( empty($_POST['post_type'])) { return; }	
	global $post;

	update_post_meta($post->ID, "thmplt_carousel_slide_settings", $_POST["thmplt_carousel_slide_settings"]);
	update_post_meta($post->ID, "thmplt_carousel_slide_images", $_POST["thmplt_carousel_slide_images"]);
		
}
add_action('save_post', 'save_thmplt_carousel_slide'); 


function thmplt_extract_yt_video_id($src){
	
#preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $src, $match);
#preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $src, $match)
	
	if (preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $src, $match)) {
    	$id = $match[1];
		return $id;
    	//var_dump($id);
	} else {
		return false;
	}
	
}


// Attach the CSS and JS to the editor screen
function thmplt_carousel_add_jscss() {
    global $post;
	$url_to_here = str_replace( TEMPLATEPATH, get_bloginfo('template_url'), dirname(__FILE__) );
	if ('thmplt_carousel' === $post->post_type) {		
		echo "<script type='text/javascript'  src='".$url_to_here. "/carousel.js'></script>\n";
		#echo "<link rel='stylesheet'href='".$plugin_url."/editor.css' type='text/css' media='all' \>\n";		
	}
}
add_action('admin_head', 'thmplt_carousel_add_jscss');


