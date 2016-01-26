(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	// form varibles are accessible through fromValues

	jQuery('document').ready(function(){

		// adds empty option to all select
		jQuery('select', '#edvisor-form').prepend('<option value="" disabled selected hidden></option>');

		// Add autocomplete to google fields
		jQuery('[e=google]').autocomplete({
	    source: function( request, response ) {
	      jQuery.ajax({
	        url: "https://app.edvisor.io/api/v1/google-place/search?public_key=" + formValues.apiKey,
	        type: 'GET',
	        data: {
	          query: request.term
	        },
	        success: function(data) {
	          response($.map(data, function(item) {
	            return {
	              label: item.description,
	              id: item.place_id
	            };
	          }));
	        },
	      });
	    },
	    select: function(event, ui) {
	      var googleId = ui.item.id
	      event.target.setAttribute('google_place_id', googleId)
	    },
	    change: function (event, ui) {
	      if(ui.item == null || ui.item == undefined) {
	        $(this).val("")
	      }
	    }
	  });

	  jQuery('[e=google]').keypress(function(event) {
	    if (event.keyCode == 13) {
	      event.preventDefault();
	    }
	  });


	  // Adds date to birthday 
	  jQuery('[e-date]').datepicker({
	    changeMonth: true,
	    changeYear: true,
	    yearRange: "-90:-0D",
	  });


		// This is what happens when the submit button is clicked
	 	jQuery('#edvisor-form button').on('click', function(event){
	 		event.preventDefault();

	 		// Validate Fields
	 		// Remove existing errors, check for requried and email fields
	 		jQuery('.edvisor-required-msg').remove();

			var errors = '0';
			jQuery('.e-required').each(function(){
				if(jQuery(this).has('input') && jQuery(this).children('input').val() === "") {
					jQuery(this).children('label').after('<span class="edvisor-required-msg">'+ formValues.valid_required +'</span>');
					errors += 1;
				} else if(jQuery(this).has('select') && jQuery(this).children('select').val() === null) {
					jQuery(this).children('label').after('<span class="edvisor-required-msg">'+ formValues.valid_required +'</span>');
					errors += 1;
				} else if(jQuery(this).has('textarea') && jQuery(this).children('textarea').val() === "")  {
					jQuery(this).children('label').after('<span class="edvisor-required-msg">'+ formValues.valid_required +'</span>');
					errors += 1;
				}
			});

			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

			if(jQuery('[name=email]').val() && !emailReg.test(jQuery('[name=email]').val())) {
				jQuery('[name=email]').parent().children('label').after('<span class="edvisor-required-msg">'+ formValues.valid_email +'</span>');
		    errors += 1
			}

			if (errors != 0) {
				jQuery('html, body').animate({
        	scrollTop: (jQuery(".edvisor-required-msg").offset().top - 50)
    		}, 2000);
				errors = false;
				return errors;
			}

			

			// Grab Data according to type and assigning it to json format 
		  var data = {};
		  
		  jQuery('[e="text"]').each(function(index, ele){
		    if(jQuery(this).val()) {
		      data[ele.name] = jQuery(this).val()
		    }
		  });

		  jQuery('[e="google-manual"]').each(function(index, ele){
		    if(jQuery(this).val()) {
		    	data[ele.name] = jQuery('option:selected', this).attr('google')
		    }
		  });

		  jQuery('[e="google-manual-tag"]').each(function(index, ele){
		    if(jQuery(this).val()) {
		    	data[ele.name] = [{
						googlePlaceId: jQuery('option:selected', this).attr('google')
					}]
		    }
		  });

		  jQuery('[e="radio"]').each(function(index, ele){
		    if(jQuery(this).val()) {
		    	data[ele.name] = jQuery('option:selected', this).attr('custom')
		    }
		  });

		  jQuery('[e="google"]').each(function(index, ele){
		  	if(jQuery(this).val()) {
		  		if(ele.name === "currentLocationGooglePlaceId") {
		  			data[ele.name] = jQuery(this).attr('google_place_id')
		  		}
		  		if(ele.name === "studentLocationPreferences") {
		  			data[ele.name] = [{
							googlePlaceId: jQuery(this).attr('google_place_id')
						}]
		  		}
		  	}
		  })

		  jQuery('[e="tag"]').each(function(index, ele){
		  	if(jQuery(this).val()) {
					if(ele.name === 'studentCoursePreferences') {
						data[ele.name] = [{
							name: jQuery(this).val()
						}]
					}
					if(ele.name === 'studentSchoolPreferences') {
						data[ele.name] = [{
							name: jQuery(this).val()
						}]
					}
		  	}
		  });

		  if(jQuery('[e="nationality"]').val()) {
		  	var natNum = parseInt(jQuery('option:selected', '[e="nationality"]').attr('index')) + 1
		  	data['nationalityId'] = natNum;
		  }

		  jQuery('[name="customPropertyValues"]').each(function(index, ele){
		    if(jQuery(this).val()) {
		    	if(typeof data.customPropertyValues === "undefined") {
		    		data.customPropertyValues = [];
		    	}
		    	if($(this).is('select')) {
		    		data.customPropertyValues.push({
							customPropertyFieldId: $(ele).attr('custom'),
	          	customOptionSelections: [$(this).val()]
		    		})
		    	} else {
		    		 data.customPropertyValues.push({
		    		 	customPropertyFieldId: $(ele).attr('custom'),
          		value: $(this).val()
		    		 });
		    	}
		    }
		  });

		  data.agencyId = formValues.agencyId;

		  // Add Javascript before post
		  eval(formValues.jspost)

		  // Post Data to Edvisor API
			jQuery.ajax({
				url: 'https://app.edvisor.io/api/v1/student?public_key=' + formValues.apiKey,
				data: JSON.stringify(data),
				type:'PUT',
				contentType: "application/json; charset=utf-8",
				processData: false
			})
				.done(function(data) {
					if(formValues.success_radio === "url") {
						window.location.href = formValues.success_url
					} else {
						jQuery('#edvisor-form').append('<div class="edvisor-success">'+formValues.success_message+'</div>')
					}
				})
				.fail(function(data) {
					console.log('error', data);
				})

	 	});

	// add user defined javascript
	eval(formValues.js)

	});
	 

})( jQuery );
