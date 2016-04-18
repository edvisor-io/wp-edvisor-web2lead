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
   *
   *
   * Form varibles are accessible through formValues
	 */

	edvisorForm.constants.jqueryRequired = false;
  edvisorForm.constants.jqueryUiRequired = false;

  function setup(keys, x) {
    if(!isNaN(parseFloat(keys[x])) && isFinite(keys[x])) {
      var name = formValues[keys[x]]['formName'].replace(/\s/g, '');

      if(document.querySelector('#' + name + '.edvisor-form')){
        edvisorForm.constants.agencyID = formValues[keys[x]].agencyId;
        edvisorForm.constants.publicKeyApi = formValues[keys[x]].apiKey;
        edvisorForm.constants.requiredFieldError = formValues[keys[x]].valid_required;
        edvisorForm.constants.emailAddressError = formValues[keys[x]].valid_email;
        edvisorForm.constants.successType = formValues[keys[x]].success_radio;
        edvisorForm.constants.successMessage = formValues[keys[x]].success_message;
        edvisorForm.constants.successURL = formValues[keys[x]].success_url;
        edvisorForm.constants.failMessage = formValues[keys[x]].fail_message;
        edvisorForm.constants.customElements = true;
        edvisorForm.methods.grabCustomData = function(data){
          if(formValues[keys[x]].jspost.length) {
            (function() {
              'use strict';
              return (new Function('data', 'return (' + formValues[keys[x]].jspost + ')' )(data));
            }());
          }
        };

        if(formValues[keys[x]].js.length) {
          (function() {
            return (new Function( 'return (' + formValues[keys[x]].js + ')' )());
          }());
        };

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

      }
    }
  }

  jQuery('document').ready(function(){
    var keys = Object.keys(formValues);
    for(var i = 0; i < keys.length; i++){
      setup(keys, i);
    }

  });
	 

})( jQuery );
