<?php
/**
 * Sidebar Template file 
 */


	// All sidebar content from the admin area 
	dynamic_sidebar('thmplt_dynamic_sidebar');	
	
	if (is_page() || is_404()) { 

		// page widget 
        if(is_active_sidebar('website')) { 
	        dynamic_sidebar('website'); 
        }  
		
	} else { 
		
		
		// blog / post widget 
	    if(is_active_sidebar('blog')) { 
	        dynamic_sidebar('blog'); 
        }  
	
	} 
	
?>