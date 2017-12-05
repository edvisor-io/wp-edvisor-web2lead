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

	edvisorForm.constants.jqueryRequired = false;
  edvisorForm.constants.jqueryUiRequired = false;
  edvisorForm.constants.agencyID = formValues.agencyId;
  edvisorForm.constants.publicKeyApi = formValues.apiKey;
  edvisorForm.constants.requiredFieldError = formValues.valid_required;
  edvisorForm.constants.emailAddressError = formValues.valid_email;
  edvisorForm.constants.successType = formValues.success_radio;
  edvisorForm.constants.successMessage = formValues.success_message;
  edvisorForm.constants.successURL = formValues.success_url;
  edvisorForm.constants.failMessage = formValues.fail_message;
  edvisorForm.constants.customElements = true;
  edvisorForm.methods.grabCustomData = function(data){
  	eval(formValues.jspost)
  }

	jQuery('document').ready(function(){

    $('input[data-edvisor*=type-google]').autocomplete({
      source: function( request, response ) {
        $.ajax({
          url: 'https://app.edvisor.io/api/v1/google-place/search?public_key=' + edvisorForm.constants.publicKeyApi,
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
        event.target.setAttribute('data-google_place_id', googleId)
      },
      change: function (event, ui) {
        if(ui.item == null || ui.item == undefined) {
          $(this).val("")
        }
      }
    });


    // prevent hitting the enter button on the google field.
    $('[data-edvisor*=type-google]').keypress(function(event) {
      if (event.keyCode == 13) {
        event.preventDefault();
      }
    });

    // Setting the date picker
    $('[data-edvisor*=calendar]').datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: '-90:-0D',
      dateFormat: 'yy-mm-dd'
    });

	  eval(formValues.js)

	});
	 

})( jQuery );
