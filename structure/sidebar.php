<?php
/**
 * Sidebar Template file 
 */
 ?>
 
	<?php 
	if (is_page() || is_404()) { 

		dynamic_sidebar('thmplt_dynamic_sidebar');
        if(is_active_sidebar('website')) { 
	        dynamic_sidebar('website'); 
        }  
		
	} else { 
	
        if(is_active_sidebar('blog')) { 
	        dynamic_sidebar('blog'); 
        }  
	
	} 
	?>