(function( $ ) {
	'use strict';

	/**
	 * PHP variables are accessible via php_vars
	 */

	$( window ).load(function() {

		// var num = $(this).parents('.edvisor-item').attr('data-num');

		// Add New Form
		$('.edvisor-add-new').on('click', function() {
			var newFormNum = parseInt($('#edvisor-form-num').val()) + 1;
			$('#edvisor-form-num').val(newFormNum);
			$('#edvisor-form-using').val(newFormNum - 1);
			$('#submit').click();
		});


		// Delete form
		$('.edvisor-block .edvisor-close').on('click', function() {
			if(confirm('Are you sure you want to delete this form?')) {
				if($(this).parents('.edvisor-item').attr('data-num') < $('#edvisor-form-num').val) {
					$(this).parents('.edvisor-item').nextAll('.edvisor-item').find('[name*=wp_edvisor]').each(function(item) {
						$(this).attr('name', $(this).attr('name').replace(/\d/, function(x){
							return x - 1;
						}));
					});
				}
				$(this).parents('.edvisor-item').remove();
				var removeFormNum = parseInt($('#edvisor-form-num').val()) - 1;
				$('#edvisor-form-num').val(removeFormNum);
				$('#edvisor-form-using').val(removeFormNum - 1);
				$('#submit').click();
			};
		});


		// Form Select
		$('.edvisor-item').each(function(x) {
			if($(this).attr('data-num') === php_vars.using) {
				$(this).children('.edvisor-block').css('display', 'none');
				$(this).children('.edvisor-form-item').css('display', 'block');
			};
		});

		$('.edvisor-block .edvisor-edit').on('click', function() {
			$('.edvisor-form-item').css('display', 'none');
			$('.edvisor-block').css('display', 'block');
			$(this).parent().next().css('display', 'block');
			$(this).parent().css('display', 'none');
			$('#edvisor-form-using').val($(this).parents('.edvisor-item').attr('data-num'));
		});

		$('.edvisor-close-form').on('click', function() {
			$(this).parent().css('display', 'none');
			$(this).parent().prev().css('display', 'block');
		});


		// Tabs Select
		var requiredInput = ['formName', 'agencyId', 'apiKey'];
		$('a', '.nav-tab-wrapper').on('click', function() {
			var set = 0;
			for(var i = 0; i < requiredInput.length; i++){
				if($(this).parents('.edvisor-form-item').find('[name*="'+requiredInput[i]+'"]').val().length === 0) {
					$(this).parents('.edvisor-form-item').find('[name*="'+requiredInput[i]+'"]').css('border-color', 'red');
					set += 1;
				}
			}
			if(set === 0 ){
				$('a', '.nav-tab-wrapper').removeClass('nav-tab-active');
				$('[class*=edvisor-tab]').css('display', 'none');
				$(this).addClass('nav-tab-active');
				var tabId = $(this).data('tab');
				$(tabId).css('display', 'block');
			} else {
				alert('Please fill in the required fields');
			}
		});


		// Add Modal
		$('.edvisor-add').on('click', function() {
			var middle = window.scrollY + 50;
			$(this).parents('.edvisor-item').find('.edvisor-add-modal').css({'display': 'block', 'top': middle});
			$('body').addClass('modal-open');
			$('.edvisor-modal-bg').css('display', 'block');
		});

		// close modal
		$('.edvisor-close', '.edvisor-add-modal').on('click', function() {
			$('.edvisor-add-modal').css('display', 'none');
			$('.edvisor-modal-bg').css('display', 'none');
			$('body').removeClass('modal-open');
		});

		// Adding a field to the form list
		$('.edvisor-add-modal button').on('click', function(){
			var name = $(this).text();
			var label = $(this).attr('name');
			var num2 = $(this).parents('.edvisor-item').attr('data-num');

			if(label === 'customPropertyValues') {
				var customFieldNum = $('.edvisor-list_item[name*="customPropertyValues"]').length;

				$(this).parents('.edvisor-item').find('.edvisor-list_body').append('<div class="edvisor-list_item" name="'+label+'" cfId="'+customFieldNum+'">'
					+	'<div class="col-1"><input type="text" class="edvisor-list_order" name="wp_edvisor['+num2+']['+label+']['+customFieldNum+'][order]"></div>'
					+	'<div class="col-2"><span class="edvisor-list_field">'+name+'</span></div>'
					+	'<div class="col-3"><div class="edvisor-edit"></div></div>'
					+	'<div class="col-4"><div class="edvisor-close"></div></div>'
					+ '</div>');
			} else {

				$(this).parents('.edvisor-item').find('.edvisor-list_body').append('<div class="edvisor-list_item" name="'+label+'">'
					+	'<div class="col-1"><input type="text" class="edvisor-list_order" name="wp_edvisor['+num2+']['+label+'_order]"></div>'
					+ '<input type="hidden" name="wp_edvisor['+num2+']['+label+'_checkbox]" value="1">'
					+ '<input type="hidden" name="wp_edvisor['+num2+']['+label+'_label]" value=\''+php_vars[num2][label]["name"]+'\'>'
					+	'<div class="col-2"><span class="edvisor-list_field">'+name+'</span></div>'
					+	'<div class="col-3"><div class="edvisor-edit"></div></div>'
					+	'<div class="col-4"><div class="edvisor-close"></div></div>'
					+ '</div>');
			}

			$('.edvisor-add-modal').css('display', 'none');
			$('body').removeClass('modal-open');
			$('.edvisor-modal-bg').css('display', 'none');
		});

		// Delete form item
		$('.edvisor-list_body').on('click', '.edvisor-close', function(){
			$(this).parents('.edvisor-list_item').remove(); 
		});

		// Edit item

		var isSelected = function(type, input, num){
			if(php_vars[num][type]["type"]=== input) {
				return "selected";
			};
		}

		var isCustomSelected = function(type, id, input, num){
			if(php_vars[num][type][id] && php_vars[num][type][id]["type"]=== input) {
				return "selected";
			};
		}

		// Types of templates use accorrding to type of field.
		var selectTemplate = function(type, num){
			if(type === 'gender' || type === 'amOrPm') {
				var selectTemplate2 = '<div><label>Option Names:</label></div>';

				for(var x in php_vars[num][type]['option']) {
					selectTemplate2 += '<div><label>'+x+'</label><input name="wp_edvisor['+num+']['+x+']" value="'+php_vars[num][type]["option"][x]+'"></div>';
				}
				return selectTemplate2;

			} else if(type === 'studentCoursePreferences' || type === 'studentSchoolPreferences' || type === 'studentLocationPreferences' || type === 'currentLocationGooglePlaceId') {
				var multiSelectTemplate = "";

				multiSelectTemplate += '<div class="edvisor-item"><label class="edvisor-label">Type:</label>'
					+ '<select class="typeSelect" name="wp_edvisor['+num+']['+type+'_type]">'
					+ '<option '+isSelected(type, "Text", num)+'>Text</option>'
					+ '<option '+isSelected(type, "Dropdown", num)+'>Dropdown</option>'
					+	'</select></div>';

				multiSelectTemplate += '<div class="edvisor-option-container"><label>Options:</label><br/>'
					+ '<div class="edvisor-options">';

					var thereAreNumOptions = php_vars[num][type]['options'] ? php_vars[num][type]['options'].length : false;

					if(thereAreNumOptions){
						for(var i = 0; i < thereAreNumOptions; i++) {
							multiSelectTemplate += '<div class="edvisor-option"><input type="text" name="wp_edvisor['+num+']['+type+'_options][]" value="'+php_vars[num][type]["options"][i]+'">';
							if(type === 'studentLocationPreferences' || type === 'currentLocationGooglePlaceId') {
								multiSelectTemplate += '<input type="hidden" name="wp_edvisor['+num+']['+type+'_ids]['+i+']" value="'+php_vars[num][type]["ids"][i]+'">'
							}
							multiSelectTemplate += '<div class="edvisor-close"></div></div>';
						}
					} else {
						multiSelectTemplate += '<div class="edvisor-option"><input type="text" name="wp_edvisor['+num+']['+type+'_options][]" >';
						if(type === 'studentLocationPreferences' || type === 'currentLocationGooglePlaceId') {
							multiSelectTemplate += '<input type="hidden" name="wp_edvisor['+num+']['+type+'_ids][]">'
						}
						multiSelectTemplate += '<div class="edvisor-close"></div></div>';
					}
				
				multiSelectTemplate	+= '</div><button type="button" class="edvisor-option-button">+ Add Option</button></div>';


				return multiSelectTemplate;

			} else {
				return '';
			}
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
			$('.edvisor-modal-bg').css('display', 'block');

			var middle = window.scrollY + 50;
			var type = $(this).parents('.edvisor-list_item').attr('name');
			var num3 = $(this).parents('.edvisor-item').attr('data-num');

			$(this).parents('.edvisor-item').find('.edvisor-edit-modal').css({'display':'block','top': middle});
			$('body').addClass('modal-open');

			if(type === 'customPropertyValues') {
				var cfId = $(this).parents('.edvisor-list_item').attr('cfId');

				$(this).parents('.edvisor-item').find('.edvisor-edit-modal').append('<div class="edvisor-list_inner" name="'+type+'" cfId='+cfId+'>'
					+ '<div class="edvisor-field"><label>Edvisor Field: Custom Field</label></div>'
					+ '<div class="edvisor-item"><label class="edvisor-label">Label:</label><input name="wp_edvisor['+num3+'][customPropertyValues]['+cfId+'][label]" value="'+exists(php_vars[num3][type][cfId],"label")+'"></div>'
					+ '<div class="edvisor-item"><label class="edvisor-label">Web2Lead ID:</label><input name="wp_edvisor['+num3+'][customPropertyValues]['+cfId+'][id]" value="'+exists(php_vars[num3][type][cfId],"id")+'"></div>'
					+ '<div class="edvisor-item"><label class="edvisor-label">Type:</label>'
					+ '<select class="typeSelect" name="wp_edvisor['+num3+'][customPropertyValues]['+cfId+'][type]">'
					+ '<option '+isCustomSelected('customPropertyValues', cfId, "Text", num3)+'>Text</option>'
					+ '<option '+isCustomSelected('customPropertyValues', cfId, "Dropdown", num3)+'>Dropdown</option>'
					+ '<option '+isCustomSelected('customPropertyValues', cfId, "Date", num3)+'>Date</option>'
					+	'</select></div>'
					+ '<div class="edvisor-option-container"><label>Options:</label><br/>'
					+ '<div class="edvisor-options">'
					+ (function(){ 
							if(php_vars[num3]['customPropertyValues'][cfId] && php_vars[num3]['customPropertyValues'][cfId]['options']){
								var templateCustomOptions = '';
								for(var i = 0; i < php_vars[num3]['customPropertyValues'][cfId]['options'].length; i++) {
									templateCustomOptions += '<div class="edvisor-option"><input type="text" name="wp_edvisor['+num3+'][customPropertyValues]['+cfId+'][options][]" value="'+php_vars[num3]["customPropertyValues"][cfId]["options"][i]+'"><div class="edvisor-close"></div></div>'
								}
								return templateCustomOptions;
							} else {
								return '';
							}
						})()
					+ '</div><button type="button" class="edvisor-option-button">+ Add Option</button></div>'
					+ '<div class="edvisor-item"><label class="edvisor-label">Required:</label><input type="checkbox" '
					+ (function(){ 
							if(php_vars[num3][type][cfId] && php_vars[num3][type][cfId]["required"]){
								return "checked"
							} 
						})()
					+ ' name="wp_edvisor['+num3+'][customPropertyValues]['+cfId+'][required]"></div>'
					+ '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save">'
					+ '</div>')

				// If type is dropdown
				if(php_vars[num3]['customPropertyValues'][cfId] && php_vars[num3]['customPropertyValues'][cfId]['type']==="Dropdown") {
					$(this).parents('.edvisor-item').find('.edvisor-option-container').css('display','block')
				}
				
			} else {
				$(this).parents('.edvisor-item').find('.edvisor-edit-modal').append('<div class="edvisor-list_inner" name="'+type+'">'
					+ '<div class="edvisor-field"><label>Edvisor Field: '+php_vars[num3][type]["name"]+'</label></div>'
					+ '<div class="edvisor-item"><label class="edvisor-label">Label:</label><input name="wp_edvisor['+num3+']['+type+'_label]" value="'+php_vars[num3][type]["label"]+'"></div>'
					+ selectTemplate(type, num3)
					+ '<div class="edvisor-item"><label class="edvisor-label">Required:</label><input type="checkbox" '
					+ (function(){ 
							if(php_vars[num3][type] && php_vars[num3][type]["required"]){ 
								return "checked"
							} 
						})()
					+ ' name="wp_edvisor['+num3+']['+type+'_required]"></div>'
					+ '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save">'
					+ '</div>')

				// If type is dropdown
				if(php_vars[num3][type]['type'] && php_vars[num3][type]['type']==="Dropdown") {
					$(this).parents('.edvisor-item').find('.edvisor-option-container').css('display','block')
				}
			}

			// Add edvisor autocomplete
			if(type === 'studentLocationPreferences' || type === 'currentLocationGooglePlaceId') {
				$('.edvisor-edit-modal').on('click', '.edvisor-option input', function(){
					$(this).autocomplete({
				    source: function( request, response ) {
				      jQuery.ajax({
				        url: "https://app.edvisor.io/api/v1/google-place/search?public_key=" + php_vars[num3].apiKey,
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
		$('.edvisor-close', '.edvisor-edit-modal').on('click', function() {
			$('.edvisor-edit-modal').css('display', 'none');
			$('.edvisor-modal-bg').css('display', 'none');
			$('body').removeClass('modal-open');
			$('.edvisor-list_inner', '.edvisor-edit-modal').remove();
		});

		// removing of a multiselect option
		$('.edvisor-edit-modal').on('click', '.edvisor-option .edvisor-close', function() {
			$(this).parents('.edvisor-option').remove();
		});

		// Adding of a multiselect option
		$('.edvisor-edit-modal').on('click', '.edvisor-option-button', function() {
			var type = $(this).parents('.edvisor-list_inner').attr('name');
			var num = $(this).parents('.edvisor-item').attr('data-num');
			// var num = $('.edvisor-option-button').parents('.edvisor-option-container').find('.edvisor-option').length

			if(type === 'customPropertyValues') {
				var cfId = $(this).parents('.edvisor-list_inner').attr('cfId');
				$('.edvisor-options').append('<div class="edvisor-option"><input type="text" name="wp_edvisor['+num+'][customPropertyValues]['+cfId+'][options][]"><div class="edvisor-close"></div></div>');
			} else {
				$('.edvisor-options').append('<div class="edvisor-option"><input type="text" name="wp_edvisor['+num+']['+type+'_options][]">'
				+ (function(){ if(type === 'studentLocationPreferences' || type === 'currentLocationGooglePlaceId') { return '<input type="hidden" name="wp_edvisor['+num+']['+type+'_ids][]">' } else { return ''}})()
				+ '<div class="edvisor-close"></div></div>');
			}
		});

		// Watching for type select change
		$('.edvisor-edit-modal').on('change', '.typeSelect', function() {
			if($(this).val()==='Dropdown') {
				$('.edvisor-option-container').css('display', 'block');
			} else {
				$('.edvisor-option-container').css('display', 'none');
			}
		});

		// button action for custom text area
		$('.edvisor-tab-custom button').on('click', function(){
			$(this).next().css('display', 'block');
			$(this).remove();
		});



	});	

})( jQuery );
