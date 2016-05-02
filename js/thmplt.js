/* 
 * Thmplt JS and Jquery Classes and helpers
 * 
 * @version 1 
 */

jQuery(document).ready(function(){

/**
 * New expression that similar to :contains but case insenitive
 */
	jQuery.extend( jQuery.expr[":"], {
		"containsCI": function(elem, i, match, array) {
			return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
		}
	});


/*
 * Preload and allow to create image hovers by swicthing the src
 * with the hover source
 */
	jQuery(".imghover, .tpf-img-hover").each(
		function(){
		var thesrc = jQuery(this).attr('src');
		var name = thesrc.substring(0, thesrc.lastIndexOf('.'));
		var extension = thesrc.substring(thesrc.lastIndexOf('.'));
		var newbgurl =  name + "_hover" + extension;
		jQuery('<img />').attr('src', newbgurl); // preload the img into the dom
	});

	jQuery('.imghover, .tpf-img-hover').hover (
		function () {
		var thesrc = jQuery(this).attr('src');
		var name = thesrc.substring(0, thesrc.lastIndexOf('.'));
		var extension = thesrc.substring(thesrc.lastIndexOf('.'));
		jQuery(this).attr('src', name + '_hover' + extension);
		}, function () {
		var newsrc = jQuery(this).attr('src').replace("_hover","");
		jQuery(this).attr('src', newsrc);
	});


/**
 * Clone a Ul/OL menu 
 * 
 * Must use data attributes to target a list to clone
 * @param data-clone String The selector of the UL/OL you are cloning
 * @param data-li-contains String The search down the tree for an LI that contains a specific word
 * @param data-target string The selector of a specific sub list or selector of the parent of a sub list 
 * Samples 
 * <ul class='tpf-clone-list' data-clone='#mainmenu' ></ul> 
 * clones a list with "mainmenu" ID
 * 
 * <ul class='tpf-clone-list' data-clone='#mainmenu' data-li-contains='more'></ul> 
 * clones a sub list from "mainmenu" where the LI contains the word "more" ( uses the first element it finds )  
 *
 * <ul class='tpf-clone-list' data-clone='#mainmenu' data-target='.moreitems'></ul>
 * clones a sub list from "mainmenu" where the sub list has the class of "moreitems" or the parent LI has a 
 * class of "moreitems" 
 */
	jQuery(".tpf-clone-list").each(function() {


		var tpf_clone = jQuery(this).attr("data-clone");
		var tpf_contains = jQuery(this).attr('data-li-contains');
		var tpf_target = jQuery(this).attr('data-target');
		
		var tpf_clone_list_html = "";
		
		if ( tpf_contains ) {
			// else search down the tree for an LI that contains *tpf_contains*	and copy it's UL
			var tpf_clone_list_html = jQuery( tpf_clone ).find('a:containsCI(' + tpf_contains + ')').parent().find("ul").html();			
		} else if ( tpf_target ) {

			if ( jQuery( tpf_target ).is("ul") ) {
			// If it's a direct UL item use this
				var tpf_clone_list_html = jQuery(tpf_clone).find(tpf_target).html();
				
			} else { 
			// Else find the closest UL down the hierarchy 			
				var tpf_clone_list_html = jQuery(tpf_clone).find(tpf_target).find("ul").html();
				
			}
		} else if ( tpf_clone ) {	
			// If clone is set then copy the HTML directly
			var tpf_clone_list_html = jQuery( tpf_clone ).html();
	
		} else {
			// If nothing is set, then return a message 
			var tpf_clone_list_html = "";
			
		}

		// Copy the HTML onto this selector
		jQuery(this).html(tpf_clone_list_html);

		//var lookfor = "li.current-menu-item, li.current-menu-parent";

	});



/**
 * Classes for accordion menus
 */
	jQuery(".tpf-ac-trigger").click(function(){
		jQuery(this).toggleClass('tpf-active').next(".tpf-ac-pane").slideToggle('normal').siblings(".tpf-ac-pane").slideUp("normal");
		jQuery(this).siblings(".tpf-ac-trigger").removeClass('tpf-active');
	});

	jQuery('.tpf-ac-pane').hide(); 
	jQuery(".tpf-ac-open").toggleClass('tpf-active').next('.tpf-ac-pane').show();


	//ACMENU  UL BASED
	jQuery(".tpf-accordion li:has(ul)>a").addClass('tpf-ac-click'); // Add accmenu-click class to make it a clickable accordion tab   

	jQuery('.tpf-accordion ul').hide();
	jQuery('.tpf-accordion li .tpf-ac-click').live("click", function(e) {
		e.preventDefault();
		jQuery(this).parent().siblings().removeClass('tpf-active').addClass('tpf-inactive');
		jQuery(this).parent().removeClass('tpf-inactive').toggleClass('tpf-active');
		jQuery(this).next().slideToggle('normal');
		jQuery('.tpf-inactive ul').slideUp('normal'); 
	});	
  
	//For the ac menu - keep the current menu open  
	jQuery(".tpf-ac-open-current .current-menu-item, .tpf-ac-open-current .current-menu-parent, .tpf-ac-open-current .current-menu-ancestor").addClass('active'); 
	jQuery(".tpf-ac-open-current .current-menu-item>ul, .tpf-ac-open-current .current-menu-parent>ul, .tpf-ac-open-current .current-menu-ancestor>ul").show();
	
	//For the ac menu - keep a specific menu open
	jQuery(".tpf-accordion .tpf-ac-open").addClass('tpf-active').children('ul').show();


/**
 * finds the first and last items and first and last elements
 * and adds a class to it
 */
	jQuery(".tpf-firstlast").each(function() {
		jQuery(this).find('>*:first').addClass("first");
		jQuery(this).find('>*:last').addClass("last");
	});


/**
 * A crossbrowser stylable alternative to placeholder in HTML5
 * 
 * Clear the text value on focus and return 
 * when empty, unless new value is inputed  
 */
	jQuery('.tpf-placeholder-value').on("focusin", function(){
		if (this.defaultValue == this.value) { 
			this.value = '';
		}
	}).on("focusout", function() {
		if (this.value == ''){
			this.value = this.defaultValue;
		}
	});


/**
 * Remove/clear the placeholder values when submitting 
 * So they don't get accidentally submitted with the form
 */	
	jQuery('.tpf-clear-placeholder-on-submit').submit(function(e){
		//e.preventDefault(); // Stop it from submitting
		jQuery(this).find('.tpf-placeholder-value').each(function(){
			if (this.defaultValue == this.value) { 
				this.value = '';
			}
		});
	});


/**
 * Add a target='_blank' to external links
 */
 	// make all links that are external pop up in new window/tab 
	var mndomain_check = document.domain.replace("www.","");
	jQuery(".tpf-external a[href^='htt']").not("a[href*='"+mndomain_check+"']").attr("target","_blank");
	 
	jQuery('.tpf-target-blank a, .tpf-target-blank').attr('target','_blank');
	jQuery('.tpf-remove-target-blank a, .tpf-remove-target-blank').removeAttr('target');


/**
 * Create a full width bleed "breakout" of the container 
 * 
 */
	if ( jQuery(".tpf-fwbleed").length ) { 
		jQuery('.tpf-fwbleed').each( function( ){
			tpfFWBleedMargin( jQuery(this) );
//			jQuery(this).css("width", "100vw");
		});  
		jQuery( window ).resize(function() {
			jQuery('.tpf-fwbleed').each( function( ){
				tpfFWBleedMargin( jQuery(this) );
			});    
		});
	}
	
	/**
	 * Calculate the margin left of the element
	 * based on the left of the container and the outerwidth 
	 */		
	function tpfFWBleedMargin( e ){
		var outerW = ( e.closest(".container").outerWidth(true) - e.closest(".container").width() ) / 2; 
		var parentW = e.closest(".wrapper").outerWidth(true);
		e.css("margin-left", ( ( e.closest(".container").position().left + outerW ) * -1 ) + "px");
		e.css("width", parentW + "px");	
		// ( e.outerWidth(true) - e.width() ) / 2; // <-- Outerwidth formula 
	}	



});	// Close Jquery document ready 