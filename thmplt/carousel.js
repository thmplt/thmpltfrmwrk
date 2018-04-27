// JavaScript Document
jQuery(document).ready(function($){
	"use strict";
	
	var frame;
	var inputfield;
	
	jQuery('.add_img').click(function(event){

		event.preventDefault();
		
		inputfield =  jQuery(this).next('input');
		
		// If the media frame already exists, reopen it.
		if ( frame ) {
		  frame.open();
		  return;
		}
		
		// Create a new media frame
		frame = wp.media({
			title: 'Select or Upload images',
			button: {
				text: 'Use image'
			},
			library: {
				type: 'image'
			},
			multiple: 'false'  // Set to true to allow multiple files to be selected #add for multiple
		});		
		

		// When an image is selected in the media frame...
		frame.on( 'select', function() {

			// Get media attachment details from the frame state
			var attachment = frame.state().get('selection').first().toJSON();

			// Send the attachment URL to our custom image input field.
			//imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );
			//Send the attachment id to our hidden input
			//alert( attachment.url );

			inputfield.val( attachment.url );
			inputfield.parent(".imageinput").append( '<div class="arrow_box"><img src="'+attachment.url+'"></div>' );

		});

		// Finally, open the modal on click
		frame.open();		
		
	});
	
});