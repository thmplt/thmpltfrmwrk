<?php
/**
 * thmplt's script options functions 
 *
 */
 
//echo "TEST";

/**
 * Create a logo and favicon upload option
 *
 */
add_action ('admin_menu','thmplt_script_options');
function thmplt_script_options() {
	
	//echo "TEST";

	$parent_slug = "thmplt-options";
	//$parent_slug = "options-general.php";
	$page_title = "Script Options";
	$menu_title = "Script Options";
	$capability = "publish_posts";
	$menu_slug = "thmplt-script-options";
	$function = "thmplt_script_options_callback";
	// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	//add_menu_page($page_title, $menu_title, $capability, $menu_slug, NULL, THMPLT_SVG_B64);
	add_submenu_page( $parent_slug, $page_title, "Script Options", $capability, $menu_slug, $function );	
} 


/**
 * options screen for admin
 */
function thmplt_script_options_callback () {

	$thmplt_options = get_option('thmplt_options');
	
	if (!empty($_POST)){ 

		$thmplt_options = $_POST['thmplt_options']; 
		//flush_rewrite_rules();
		
	}

	echo "<div class='wrap'>";
		echo "<h2>Theme Script Options and Settings</h2>";
		echo "<em><strong>You can also update these settings through the customize section</strong></em>";
		
		echo "<form method='post' name='options'>";
			echo "<table class='form-table' >";
				echo "<tbody>";


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


	
	 				global $wp_scripts; echo "<pre>"; var_dump($wp_scripts); echo "</pre>";
	


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