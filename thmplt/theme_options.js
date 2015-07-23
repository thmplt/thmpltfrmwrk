/**
 * JS controls for the options page
 */
 
 
/* Opens the media library for the logo */
jQuery('#add_logo').live("click",function(e) {
	e.preventDefault();	

	var to = jQuery(this);//.find('img'); // Where to send information 	
	tb_show('', 'media-upload.php?type=image&TB_iframe=true'); 

	// The information that get's sent back from the media uploader
	window.send_to_editor = function(html) { 
		imgurl = jQuery('img',html).attr('src'); // Get the image source returned from the image uploader
	
		// Add the imag
		jQuery('#logo_img').attr('src',imgurl);
		jQuery('#logo_input').val(imgurl);


		jQuery('.logocontainer').removeClass('inactivelogo');
		jQuery('.logocontainer').addClass('activelogo');		
		
		tb_remove(); // Close the media uploader
	}
	

	
	return false; // Prevents other functions to run while using the image uploader
}); 



/* Remove logo */
jQuery('#remove_logo').live("click",function(e) {
	e.preventDefault();	

		imgurl = ""; // NULL VALUE - 
	
		// Add the imag
		jQuery('#logo_img').attr('src',imgurl);
		jQuery('#logo_input').val(imgurl);

		jQuery('.logocontainer').removeClass('activelogo');
		jQuery('.logocontainer').addClass('inactivelogo');
		
	return false; // Prevents other functions to run while using the image uploader
});



/* Opens the media library for the favicon */
jQuery('#add_favicon').live("click",function(e) {
	e.preventDefault();	

	var to = jQuery(this);//.find('img'); // Where to send information 	
	tb_show('', 'media-upload.php?type=image&TB_iframe=true'); 

	// The information that get's sent back from the media uploader
	window.send_to_editor = function(html) { 
		imgurl = jQuery('img',html).attr('src'); // Get the image source returned from the image uploader
	
		// Add the imag
		jQuery('#favicon_img').attr('src',imgurl);
		jQuery('#favicon_input').val(imgurl);


		jQuery('.faviconcontainer').removeClass('inactivefavicon');
		jQuery('.faviconcontainer').addClass('activefavicon');		
		
		tb_remove(); // Close the media uploader
	}
	

	
	return false; // Prevents other functions to run while using the image uploader
}); 



/* Remove favicon */
jQuery('#remove_favicon').live("click",function(e) {
	e.preventDefault();	

		imgurl = ""; // NULL VALUE - 
	
		// Add the imag
		jQuery('#favicon_img').attr('src',imgurl);
		jQuery('#favicon_input').val(imgurl);

		jQuery('.faviconcontainer').removeClass('activefavicon');
		jQuery('.faviconcontainer').addClass('inactivefavicon');
		
	return false; // Prevents other functions to run while using the image uploader
});

 