<?php
/**
 * ThemeEgss' theme options functions 
 *
 */
 
 

/**
 * Create a logo and favicon upload option
 *
 */
add_action ('admin_menu','thmplt_options');
function thmplt_options() {
	//$parent_slug = "themes.php";
	$parent_slug = "thmplt-options";	
	$page_title = "Theme Options";
	$menu_title = "Thmplt Options";
	$capability = "publish_posts";
	$menu_slug = "thmplt-options";	
	$function = "thmplt_options_callback";		
	// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	add_menu_page($page_title, $menu_title, $capability, $menu_slug);
	add_submenu_page( $parent_slug, $page_title, "Theme Options", $capability, $menu_slug, $function );	
} 


/**
 * options screen for admin
 */
function thmplt_options_callback () {

	$thmplt_options = get_option('thmplt_options');
	
	if (!empty($_POST)){ 

		$thmplt_options = $_POST['thmplt_options']; 
		//flush_rewrite_rules();
		
	}

	echo "<div class='wrap'>";
		echo "<h2>Theme Options and Settings</h2>";
		
		echo "<form method='post' name='options'>";
			echo "<table class='form-table' >";
				echo "<tbody>";



					/**
					 * HTML/Option logo
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='logo'>Logo</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>Upload or remove a logo</label><br /><br />";

							if ( empty( $thmplt_options['logo'] ) ) { 
								
								echo "<div class='inactivelogo logocontainer'> \n";
								echo "<img src='' id='logo_img' /> \n";
								echo "<input type='hidden' name='thmplt_options[logo]' id='logo_input' value='' /> \n";
								echo "<a href='#' id='add_logo'>Add a logo</a> \n";
								echo "<a href='#' id='remove_logo'>Remove logo</a> \n";
								echo "</div>";
								
							} else { 
							
								echo "<div class='activelogo logocontainer'>";
								echo "<img src='". $thmplt_options['logo'] ."' id='logo_img' />";
								echo "<input type='hidden' name='thmplt_options[logo]' id='logo_input' value='".$thmplt_options['logo']."' />";
								echo "<a href='#' id='add_logo'>Add a logo</a>";
								echo "<a href='#' id='remove_logo'>Remove logo</a>";							
								echo "</div>";
							
							}
						
						echo "</fieldset>";
					echo "</td>";
					echo "</tr>";
				



					/**
					 * HTML/Option for favicon
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='favicon'>Favicon</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>Upload or remove a favicon</label><br /><br />";

							if ( empty( $thmplt_options['favicon'] ) ) { 
								
								echo "<div class='inactivefavicon faviconcontainer'> \n";
								echo "<img src='' id='favicon_img' /> \n";
								echo "<input type='hidden' name='thmplt_options[favicon]' id='favicon_input' value='' /> \n";
								echo "<a href='#' id='add_favicon'>Add a favicon</a> \n";
								echo "<a href='#' id='remove_favicon'>Remove favicon</a> \n";
								echo "</div>";
								
							} else { 
							
								echo "<div class='activefavicon faviconcontainer'>";
								echo "<img src='". $thmplt_options['favicon'] ."' id='favicon_img' />";
								echo "<input type='hidden' name='thmplt_options[favicon]' id='favicon_input' value='".$thmplt_options['favicon']."' />";
								echo "<a href='#' id='add_favicon'>Add a favicon</a>";
								echo "<a href='#' id='remove_favicon'>Remove favicon</a>";							
								echo "</div>";
							
							}
						
						echo "</fieldset>";
					echo "</td>";
					echo "</tr>";



					/**
					 * HTML/Option for fonts
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='fonts'>Fonts</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>Enable/Disable default fonts used in theme</label><br /><br />";

						$font_options = array ( "on", "off");
						
						echo "<select name='thmplt_options[fonts]' >";
						foreach ( $font_options as $fo ) { 
						
							$fo_selected = ($fo == $thmplt_options['fonts']) ? "selected": NULL;
							echo "<option value='".$fo."' ".$fo_selected." >".ucfirst($fo)."</option>";
						
						} 
						
						echo "</fieldset>";
					echo "</td>";
					echo "</tr>";


					/**
					 * HTML/Option for bootstrap
					 */ 
					echo "<tr>";
					echo "<th scope='row'><label for='fonts'>Bootstrap</label></th>";
					echo "<td>";
					
						echo "<fieldset>";
						echo "<label>Enable/Disable default Bootstrap assets</label><br /><br />";

						$boostrap_options = array ( "on", "off");
						
						echo "<select name='thmplt_options[bootstrap]' >";
						foreach ( $boostrap_options as $bo ) { 
						
							$bo_selected = ($bo == $thmplt_options['bootstrap']) ? "selected": NULL;
							echo "<option value='".$bo."' ".$bo_selected." >".ucfirst($bo)."</option>";
						
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
	 */
	if (!empty($_POST)){

		$error = false;
	
		if ($error != true){
			echo "<div class='updated'><p><strong>";
			echo "Options saved";
			echo "</strong></p></div>";
		}
		update_option( 'thmplt_options', $_POST['thmplt_options'] );
		
	}#End if (!empty($_POST))

	
}




/**
 * Add support for the media upload 
 */
add_action('admin_init', 'thmplt_options_media_support');
function thmplt_options_media_support() {

	$add_scripts = false;
	if ( !empty( $_GET['page'] ) && $_GET['page'] == "thmplt-options" ) { $add_scripts = true; }
	
	if ($add_scripts) {		
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('jquery');
		wp_enqueue_style('thickbox');		
	}
	
}


/**
 * Adds a filter that forces the image info to send from 
 * the media box to where ever we tell it to go
 */
add_filter( 'get_media_item_args', 'thmplt_options_force_send' );
function thmplt_options_force_send( $args ) {
	$args['send'] = true;
	return $args;
}



/**
 * Include scripts/styles to this page
 */
add_action('admin_head', 'thmplt_options_scripts');
function thmplt_options_scripts() {

	$add_scripts = false;
	$url_to_here = str_replace( TEMPLATEPATH, get_bloginfo('template_url'), dirname(__FILE__) );
	
	if (!empty($_GET['page']) && $_GET['page'] == "thmplt-options") { $add_scripts = true; }
	if ($add_scripts) {	

		echo "<script type='text/javascript'  src='". $url_to_here. "/theme_options.js'></script>\n";
		echo "<link type='text/css' rel='stylesheet' href='". $url_to_here. "/theme_options.css' />\n";
		
	}
	
}


/**
 * get option registerd in the thmplt admin screen
 * if the option does not exist, return default
 * if default is not set return false 
 * 
 */
function thmplt_option( $option, $default = false){

	$thmplt_options = get_option('thmplt_options');

	if (!empty($thmplt_options[$option])) { 
	
		return $thmplt_options[$option];
	
	} else {
	
		return $default;	
		
	}
	
}



/**
 * The URL of the LOGO from the admin
 */
function thmplt_logo_url() {

	return thmplt_option('logo', false);

}


/**
 * the URL of the favicon fromt the admin 
 */
function thmplt_favicon_url() {

	return thmplt_option('favicon', false);
	
}


/**
 * Function will load the logo image wrapped in an A tag
 * If there is no image from the admin to load, it will try and 
 * load the URL source. if there is no source, then it
 * will load the site name and title as a default 
 *
 * @param string $src Source of the image file
 * @param string $href The HREF to link to 
 * @param string $alt The Alt attribute 
 */
function thtmplt_logo($src=NULL, $href=NULL, $alt=NULL){
	
	$src = is_null($src) ? 	false : $src;
	$href = is_null($href) ? get_bloginfo('url'): $href;
	$alt = is_null($alt) ? get_bloginfo('name'): $alt;

	$html = "";
	
	if ( thmplt_logo_url() ) {
		
		$html .= "\n <a href='".$href."'> \n";
		$html .= "\t <img class='logoimg' src='".thmplt_logo_url()."' alt='".$alt."' /> \n";
		$html .= " </a> \n";
		
	} elseif ( $src ) { 	
	
		$html .= "\n <a href='".$href."'> \n";
		$html .= "\t <img class='logoimg' src='".$src." ' alt='".$alt."' /> \n";
		$html .= " </a> \n";		
		
	} else { 
	
		$html .= "\n <h1 class='thmplt_logo'> \n";
		$html .= " <a href='".$href."'> \n";
		$html .= get_bloginfo( 'name' ) ."\n";
		$html .= " </a> \n";
		$html .= " </h1> \n";
		
		$html .= "\n <h2 class='thmplt_logo'> \n";
		$html .= " <a href='".$href."'> \n";
		$html .= get_bloginfo('description')."\n";
		$html .= " </a> \n";
		$html .= " </h2> \n";	
	
	}

	return $html;
	
}
