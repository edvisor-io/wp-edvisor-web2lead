(function( $ ) {
	'use strict';

	/**
	 * PHP variables are accessible via php_vars
	 */

	$( window ).load(function() {

		// Tabs Select
		$('a', '.nav-tab-wrapper').on('click', function() {
			$('a', '.nav-tab-wrapper').removeClass('nav-tab-active');
			$(this).addClass('nav-tab-active');
			$('[id*="edvisor-tab-"]').css('display', 'none');
			var tabId = $(this).data('tab');
			$(tabId).css('display', 'block');
		});

		// Add Modal
		$('#edvisor-add').on('click', function() {
			var middle = window.scrollY + 50;
			$('#edvisor-add-modal').css({'display': 'block', 'top': middle});
			$('body').addClass('modal-open');
			$('.edvisor-modal-bg').css('display', 'block');
		});

		// close modal
		$('.edvisor-close', '#edvisor-add-modal').on('click', function() {
			$('#edvisor-add-modal').css('display', 'none');
			$('.edvisor-modal-bg').css('display', 'none');
			$('body').removeClass('modal-open');
		});

		// Adding a field to the form list
		$('button', '#edvisor-add-modal').on('click', function(){
			var name = $(this).text();
			var label = $(this).attr('name');

			if(label === 'customPropertyValues') {
				var customFieldNum = $('.edvisor-list_item[name*="customPropertyValues"]').length;

				$('.edvisor-list_body').append('<div class="edvisor-list_item" name="'+label+'" cfId="'+customFieldNum+'">'
					+	'<div class="col-1"><input type="text" class="edvisor-list_order" name="wp_edvisor['+label+']['+customFieldNum+'][order]"></div>'
					+	'<div class="col-2"><span class="edvisor-list_field">'+name+'</span></div>'
					+	'<div class="col-3"><div class="edvisor-edit"></div></div>'
					+	'<div class="col-4"><div class="edvisor-close"></div></div>'
					+ '</div>');
			} else {
				$('.edvisor-list_body').append('<div class="edvisor-list_item" name="'+label+'">'
					+	'<div class="col-1"><input type="text" class="edvisor-list_order" name="wp_edvisor['+label+'_order]"></div>'
					+ '<input type="hidden" name="wp_edvisor['+label+'_checkbox]" value="1">'
					+ '<input type="hidden" name="wp_edvisor['+label+'_label]" value=\''+php_vars[label]["name"]+'\'>'
					+	'<div class="col-2"><span class="edvisor-list_field">'+name+'</span></div>'
					+	'<div class="col-3"><div class="edvisor-edit"></div></div>'
					+	'<div class="col-4"><div class="edvisor-close"></div></div>'
					+ '</div>');
			}

			$('#edvisor-add-modal').css('display', 'none');
			$('body').removeClass('modal-open');
			$('.edvisor-modal-bg').css('display', 'none');
		});

		// Delete form item
		$('.edvisor-list_body').on('click', '.edvisor-close', function(){
			$(this).parents('.edvisor-list_item').remove(); 
		});

		// Edit item

		var isRequired = function(type){ if(php_vars[type] && php_vars[type]["required"]){ return "checked" } };

		var isCustomRequired = function(type, id){ if(php_vars[type][id] && php_vars[type][id]["required"]){ return "checked" } };

		var isSelected = function(type, input){
			if(php_vars[type]["type"]=== input) {
				return "selected";
			};
		}

		var isCustomSelected = function(type, id, input){
			if(php_vars[type][id] && php_vars[type][id]["type"]=== input) {
				return "selected";
			};
		}

		// Types of templates use accorrding to type of field.
		var selectTemplate = function(type){
			if(type === 'gender' || type === 'amOrPm') {
				var selectTemplate = '<div><label>Option Names:</label></div>';

				for(var x in php_vars[type]['option']) {
					selectTemplate += '<div><label>'+x+'</label><input name="wp_edvisor['+x+']" value="'+php_vars[type]["option"][x]+'"></div>';
				}
				return selectTemplate;

			} else if(type === 'studentCoursePreferences' || type === 'studentSchoolPreferences' || type === 'studentLocationPreferences' || type === 'currentLocationGooglePlaceId') {
				var multiSelectTemplate = "";

				multiSelectTemplate += '<div class="edvisor-item"><label class="edvisor-label">Type:</label>'
					+ '<select id="typeSelect" name="wp_edvisor['+type+'_type]">'
					+ '<option '+isSelected(type, "Text")+'>Text</option>'
					+ '<option '+isSelected(type, "Dropdown")+'>Dropdown</option>'
					+	'</select></div>';

				multiSelectTemplate += '<div class="edvisor-option-container"><label>Options:</label><br/>'
					+ '<div class="edvisor-options">';

					var typeOptions = php_vars[type]['options'].length;

					if(typeOptions){
						for(var i = 0; i < typeOptions; i++) {
							multiSelectTemplate += '<div class="edvisor-option"><input type="text" name="wp_edvisor['+type+'_options][]" value="'+php_vars[type]["options"][i]+'">';
							if(type === 'studentLocationPreferences' || type === 'currentLocationGooglePlaceId') {
								multiSelectTemplate += '<input type="hidden" name="wp_edvisor['+type+'_ids]['+i+']" value="'+php_vars[type]["ids"][i]+'">'
							}
							multiSelectTemplate += '<div class="edvisor-close"></div></div>';
						}
					} else {
						multiSelectTemplate += '<div class="edvisor-option"><input type="text" name="wp_edvisor['+type+'_options][]" >';
						if(type === 'studentLocationPreferences' || type === 'currentLocationGooglePlaceId') {
							multiSelectTemplate += '<input type="hidden" name="wp_edvisor['+type+'_ids][]">'
						}
						multiSelectTemplate += '<div class="edvisor-close"></div></div>';
					}
				
				multiSelectTemplate	+= '</div><button type="button" class="edvisor-option-button">+ Add Option</button></div>';


				return multiSelectTemplate;

			} else {
				return '';
			}
		}

		var isDropdown = function(){
			 console.log($('#typeSelect'));
		}

		var exists = function(item, etx) {
			if(item) {
				return item[etx];
			} else {
				return '';
			}
		}

		// opening the edit modal
		$('.edvisor-list_body').on('click', '.edvisor-edit', function() {
			var middle = window.scrollY + 50;
			$('.edvisor-modal-bg').css('display', 'block');
			var type = $(this).parents('.edvisor-list_item').attr('name');

			$('#edvisor-edit-modal').css({'display':'block','top': middle});
			$('body').addClass('modal-open');

			if(type === 'customPropertyValues') {
				var cfId = $(this).parents('.edvisor-list_item').attr('cfId');

				$('.edvisor-modal_body', '#edvisor-edit-modal').append('<div class="edvisor-list_inner" name="'+type+'" cfId='+cfId+'>'
					+ '<div class="edvisor-field"><label>Edvisor Field: Custom Field</label></div>'
					+ '<div class="edvisor-item"><label class="edvisor-label">Label:</label><input name="wp_edvisor[customPropertyValues]['+cfId+'][label]" value="'+exists(php_vars[type][cfId],"label")+'"></div>'
					+ '<div class="edvisor-item"><label class="edvisor-label">Web2Lead ID:</label><input name="wp_edvisor[customPropertyValues]['+cfId+'][id]" value="'+exists(php_vars[type][cfId],"id")+'"></div>'
					+ '<div class="edvisor-item"><label class="edvisor-label">Type:</label>'
					+ '<select id="typeSelect" name="wp_edvisor[customPropertyValues]['+cfId+'][type]">'
					+ '<option '+isCustomSelected('customPropertyValues', cfId, "Text")+'>Text</option>'
					+ '<option '+isCustomSelected('customPropertyValues', cfId, "Dropdown")+'>Dropdown</option>'
					+ '<option '+isCustomSelected('customPropertyValues', cfId, "Date")+'>Date</option>'
					+	'</select></div>'
					+ '<div class="edvisor-option-container"><label>Options:</label><br/>'
					+ '<div class="edvisor-options">'
					+ (function(){ 
							if(php_vars['customPropertyValues'][cfId] && php_vars['customPropertyValues'][cfId]['options']){
								var templateCustomOptions = '';
								for(var i = 0; i < php_vars['customPropertyValues'][cfId]['options'].length; i++) {
									templateCustomOptions += '<div class="edvisor-option"><input type="text" name="wp_edvisor[customPropertyValues]['+cfId+'][options][]" value="'+php_vars["customPropertyValues"][cfId]["options"][i]+'"><div class="edvisor-close"></div></div>'
								}
								return templateCustomOptions;
							} else {
								return '';
							}
						})()
					+ '</div><button type="button" class="edvisor-option-button">+ Add Option</button></div>'
					+ '<div class="edvisor-item"><label class="edvisor-label">Required:</label><input type="checkbox" '+isCustomRequired(type, cfId)+' name="wp_edvisor[customPropertyValues]['+cfId+'][required]"></div>'
					+ '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save">'
					+ '</div>')

				// If type is dropdown
				if(php_vars['customPropertyValues'][cfId] && php_vars['customPropertyValues'][cfId]['type']==="Dropdown") {
					$('.edvisor-option-container').css('display','block')
				}
				
			} else {
				$('.edvisor-modal_body', '#edvisor-edit-modal').append('<div class="edvisor-list_inner" name="'+type+'">'
					+ '<div class="edvisor-field"><label>Edvisor Field: '+php_vars[type]["name"]+'</label></div>'
					+ '<div class="edvisor-item"><label class="edvisor-label">Label:</label><input name="wp_edvisor['+type+'_label]" value="'+php_vars[type]["label"]+'"></div>'
					+ selectTemplate(type)
					+ '<div class="edvisor-item"><label class="edvisor-label">Required:</label><input type="checkbox" '+isRequired(type)+' name="wp_edvisor['+type+'_required]"></div>'
					+ '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save">'
					+ '</div>')

				// If type is dropdown
				if(php_vars[type]['type'] && php_vars[type]['type']==="Dropdown") {
					$('.edvisor-option-container').css('display','block')
				}
			}

			// Add edvisor autocomplete
			if(type === 'studentLocationPreferences' || type === 'currentLocationGooglePlaceId') {
				$('#edvisor-edit-modal').on('click', '.edvisor-option input', function(){
					$(this).autocomplete({
				    source: function( request, response ) {
				      jQuery.ajax({
				        url: "https://app.edvisor.io/api/v1/google-place/search?public_key=" + php_vars.apiKey,
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
				      var googleId = ui.item.id;
				     	$(event.target).next().val(googleId);
				    },
				    change: function (event, ui) {
				      if(ui.item == null || ui.item == undefined) {
				        $(this).val("")
				      }
				    }
				  });
				});
			}
		});

		// closing the edit modal
		$('.edvisor-close', '#edvisor-edit-modal').on('click', function() {
			$('#edvisor-edit-modal').css('display', 'none');
			$('.edvisor-modal-bg').css('display', 'none');
			$('body').removeClass('modal-open');
			$('.edvisor-list_inner', '#edvisor-edit-modal').remove();
		});

		// removing of a multiselect option
		$('#edvisor-edit-modal').on('click', '.edvisor-option .edvisor-close', function() {
			$(this).parents('.edvisor-option').remove();
		});

		// Adding of a multiselect option
		$('#edvisor-edit-modal').on('click', '.edvisor-option-button', function() {
			var type = $(this).parents('.edvisor-list_inner').attr('name');
			// var num = $('.edvisor-option-button').parents('.edvisor-option-container').find('.edvisor-option').length

			if(type === 'customPropertyValues') {
				var cfId = $(this).parents('.edvisor-list_inner').attr('cfId');
				$('.edvisor-options').append('<div class="edvisor-option"><input type="text" name="wp_edvisor[customPropertyValues]['+cfId+'][options][]"><div class="edvisor-close"></div></div>');
			} else {
				$('.edvisor-options').append('<div class="edvisor-option"><input type="text" name="wp_edvisor['+type+'_options][]">'
				+ (function(){ if(type === 'studentLocationPreferences' || type === 'currentLocationGooglePlaceId') { return '<input type="hidden" name="wp_edvisor['+type+'_ids][]">' } else { return ''}})()
				+ '<div class="edvisor-close"></div></div>');
			}
		});

		// Watching for type select change
		$('#edvisor-edit-modal').on('change', '#typeSelect', function() {
			if($(this).val()==='Dropdown') {
				$('.edvisor-option-container').css('display', 'block');
			} else {
				$('.edvisor-option-container').css('display', 'none');
			}
		});



	});	

})( jQuery );
