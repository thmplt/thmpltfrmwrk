// JavaScript Document



jQuery(function() {
	
	var sortableIn = 1;

	jQuery( ".tpf-jq-sortable" ).sortable({
		connectWith: ".tpf-jq-sortable",
		//placeholder: "ui-state-highlight",
		receive: function() { sortableIn = 1; },
		over: function() { sortableIn = 1; },
		out: function() { sortableIn = 0; },
		beforeStop: function(e, ui) {
			if (sortableIn === 0) { 
				ui.item.remove(); 
			} 
		},
		 update: function(e, ui) {
			//jQuery(this).data('hook');
			//ui.item.addClass('test');
			ui.item.find('input').attr('name','thmplt_section['+jQuery(this).data('hook')+'][]');
		}		
	});

	
    jQuery( ".tpf-jq-sortable" ).disableSelection();
	
	
    jQuery( ".tpf-jq-sortable-master" ).sortable({
		connectWith: ".tpf-jq-sortable",
		placeholder: "ui-state-highlight",
		helper: "clone",
		remove: function(event, ui) {
			ui.item.clone().appendTo(this);
		}
    });

    jQuery( ".tpf-jq-sortable-master" ).disableSelection();

  });