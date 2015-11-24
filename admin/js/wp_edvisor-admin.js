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

	$( window ).load(function() {
		var autoComOpt = {
			source: function( request, response ) {
	      $.ajax({
	        url: 'http://app.edvisor.io/api/v1/google-place/search?public_key='+api+'',
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
	      $(event.target).next().val(googleId);
	    },
	    change: function (event, ui) {
	      if(ui.item == null || ui.item == undefined) {
	        $(this).val("")
	      }
	    },
	    minLength: 3
		}

		// Delete item from dropdown
		$('.edvisor-dropdown').on('click', '.edvisor-delete', function(){
				$(this).parent().remove();
			});

		// Add another item into dropdown
		$('.edvisor-dropdown').on('click', '.edvisor-add', function(){
			var type = $(this).parent().attr('type')
			for (var key in dropdownItems) {
				if (key === type) {
					if(type === 'destinations' || type === 'location') {
						var item = dropdownItems[type]
						$(this).parent().children().eq(0).append(item);
						$('[e-google]').autocomplete(autoComOpt);
					} else {
						$(this).parent().children().eq(0).append(dropdownItems[type]);
					}
				}
			}
		});

		// possible types of dropdowns
		var dropdownItems = {
			destinations: '<div class="edvisor-item"><input type="text" class="edvisor-dropdown-input" e-google name="wp_edvisor[studentLocationPreferences_options][]"/><input type="text" name="wp_edvisor[studentLocationPreferences_ids][]" hidden/><span class="edvisor-delete">x</span><div>',
			location: '<div class="edvisor-item"><input type="text" class="edvisor-dropdown-input" e-google name="wp_edvisor[currentLocationGooglePlaceId_options][]"/><input type="text" name="wp_edvisor[currentLocationGooglePlaceId_ids][]" hidden/><span class="edvisor-delete">x</span><div>',
			schools: '<div class="edvisor-item"><input type="text" class="edvisor-dropdown-input" name="wp_edvisor[studentSchoolPreferences_options][]"/><span class="edvisor-delete">x</span><div>',
			courses: '<div class="edvisor-item"><input type="text" class="edvisor-dropdown-input" name="wp_edvisor[studentCoursePreferences_options][]"/><span class="edvisor-delete">x</span><div>'
		}

		// Grab Api Key, watch for change
		var api = $('#wp_edvisor-apikey').val();
		$('#wp_edvisor-apikey').on('change', function(){
			api = $(this).val();
		});

		// Add google place dropdowns
		$('[e-google]').autocomplete(autoComOpt);
	  $('[e-google]').keypress(function(event) {
	    if (event.keyCode == 13) {
	      event.preventDefault();
	    }
	  });

		// Custom Fields delete dropdown item
		$(document).on('click', '.edvisor-custom-dropdown .edvisor-delete', function(){
			$(this).parent().remove();
		});

		// Custom Fields Add dropdown item
		$(document).on('click', '.edvisor-custom-dropdown .edvisor-add', function(){
			var num = $(this).attr('addTo')
			$(this).parent().children().eq(0).append('<div class="edvisor-item"><input type="text" name="wp_edvisor[customPropertyValues]['+num+'][options][]" /><span class="edvisor-delete">x</span></div>');
		});

		// Custom Fields on select of dropdown, show dropdown menu
		$('.edvisor-cus-select').filter(function() {
    	return $(this).val() === 'Dropdown';
		}).parents('.edvisor-row').children('.edvisor-custom-dropdown').css('display','block');

		$(document).on('change', '.edvisor-cus-select', function(){
			if($(this).val() === 'Dropdown') {
				$(this).parents('.edvisor-row').children('.edvisor-custom-dropdown').css('display','block');
			} else {
				$(this).parents('.edvisor-row').children('.edvisor-custom-dropdown').css('display','none');
			}
		});

		// Custom Fields add new custom field
		$('.edvisor-custom-button').on('click', function(){
			var itemNum = $('.edvisor-custom .edvisor-row').length;

			var customField = '<fieldset class="edvisor-row"><div><div class="edvisor-cus-col-1">'
			+ '<select class="edvisor-cus-select" name="wp_edvisor[customPropertyValues]['+itemNum+'][type]"><option value="Text">Text</option><option value="Date">Date</option><option value="Dropdown">Dropdown</option></select>'
			+	'</div><div class="edvisor-cus-col-2"><input type="text" class="all-options" name="wp_edvisor[customPropertyValues]['+itemNum+'][label]" /></div>'
			+ '<div class="edvisor-cus-col-3"><input type="text" class="all-options" name="wp_edvisor[customPropertyValues]['+itemNum+'][id]"/></div>'
			+ '<div class="edvisor-cus-col-4"><input type="checkbox" class="edvisor-checked" name="wp_edvisor[customPropertyValues]['+itemNum+'][required]" value="1" /></div>'
			+ '<div class="edvisor-cus-col-5"><span class="edvisor-delete edvisor-delete-cus">x</span></div></div>'			
			+ '<div class="edvisor-custom-dropdown"><div class="edvisor-custom-item-container"></div><div class="edvisor-add" addTo="'+itemNum+'">+ Add More</div></div></fieldset>'

			$(this).before(customField);
		});

		
		// Custom Fields delete custom field
		$(document).on('click', '.edvisor-delete-cus', function(){
			$(this).parents('.edvisor-row').remove();
		})


		// Settings success action
		$('[name="wp_edvisor[success_radio]"][value="message"]:checked').parents('fieldset').find('#wp_edvisor-success_message').css('display','block');
		$('[name="wp_edvisor[success_radio]"][value="url"]:checked').parents('fieldset').find('#wp_edvisor-success_url').css('display','block');
		$('[name="wp_edvisor[success_radio]"]').on('change', function(){
			if($(this).attr('value') === "message") {
				$('#wp_edvisor-success_message').css('display','block');
				$('#wp_edvisor-success_url').css('display','none');
			} else {
				$('#wp_edvisor-success_url').css('display','block');
				$('#wp_edvisor-success_message').css('display','none');
			}
		})

	});	

})( jQuery );
