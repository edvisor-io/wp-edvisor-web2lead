<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       edvisor.io
 * @since      1.0.0
 *
 * @package    Wp_edvisor
 * @subpackage Wp_edvisor/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_edvisor
 * @subpackage Wp_edvisor/public
 * @author     Clarence <clarence@edvisor.io>
 */
class Wp_edvisor_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->wp_edvisor_options = get_option($this->plugin_name);
		add_shortcode('edvisor_form', array($this, 'wp_edvisor_add_shortcode'));

	}

	public function wp_edvisor_add_shortcode() {
		// var_dump($this->wp_edvisor_options);

		$textFields = array("firstname", "lastname", "email", "phone", "address", "postalCode", "passportNumber", "notes", "accommodation", "budget", "hoursPerWeek");
		$selectFields = array(
			"startDay" => range(1, 31), 
			"startMonth" => range(1, 12), 
			"startYear" => range(date("Y"), date("Y") + 19),
			"durationWeekAmount" => range(1, 208)
		);
		$wasRadioFields = array("gender", "amOrPm");
		$addOwnFields = array("currentLocationGooglePlaceId", "studentSchoolPreferences", "studentCoursePreferences", "studentLocationPreferences");
		$tagFields = array("studentCoursePreferences", "studentSchoolPreferences");
		$googleFields = array("currentLocationGooglePlaceId", "studentLocationPreferences");
		$nationality = array(
			"Andorra",
			"United Arab Emirates",
			"Afghanistan",
			"Antigua and Barbuda",
			"Anguilla",
			"Albania",
			"Armenia",
			"Angola",
			"Antarctica",
			"Argentina",
			"American Samoa",
			"Austria",
			"Australia",
			"Aruba",
			"Azerbaijan",
			"Bosnia and Herzegovina",
			"Barbados",
			"Bangladesh",
			"Belgium",
			"Burkina Faso",
			"Bulgaria",
			"Bahrain",
			"Burundi",
			"Benin",
			"Bermuda",
			"Brunei",
			"Bolivia",
			"Bonaire, Sint Eustatius and Saba",
			"Brazil",
			"The Bahamas",
			"Bhutan",
			"Botswana",
			"Belarus",
			"Belize",
			"Canada",
			"Cocos (Keeling) Islands",
			"Congo",
			"Central African Republic",
			"Congo",
			"Switzerland",
			"Côte d'Ivoire",
			"Cook Islands",
			"Chile",
			"Cameroon",
			"China",
			"Colombia",
			"Costa Rica",
			"Cuba",
			"Cape Verde",
			"Curaçao",
			"Christmas Island",
			"Cyprus",
			"Czech Republic",
			"Germany",
			"Djibouti",
			"Denmark",
			"Dominica",
			"Dominican Republic",
			"Algeria",
			"Ecuador",
			"Estonia",
			"Egypt",
			"Eritrea",
			"Spain",
			"Ethiopia",
			"Finland",
			"Fiji",
			"Micronesia",
			"Faroe Islands",
			"France",
			"Gabon",
			"United Kingdom",
			"Grenada",
			"Georgia",
			"French Guiana",
			"Guernsey",
			"Ghana",
			"Gibraltar",
			"Greenland",
			"Gambia",
			"Guinea",
			"Guadeloupe",
			"Equatorial Guinea",
			"Greece",
			"Guatemala",
			"Guam",
			"Guinea-Bissau",
			"Guyana",
			"Hong Kong",
			"Honduras",
			"Croatia",
			"Haiti",
			"Hungary",
			"Indonesia",
			"Ireland",
			"Israel",
			"Isle of Man",
			"India",
			"Iraq",
			"Iran",
			"Iceland",
			"Italy",
			"Jersey",
			"Jamaica",
			"Jordan",
			"Japan",
			"Kenya",
			"Kyrgyzstan",
			"Cambodia",
			"Kiribati",
			"Comoros",
			"Saint Kitts and Nevis",
			"North Korea",
			"South Korea",
			"Kuwait",
			"Cayman Islands",
			"Kazakhstan",
			"Laos",
			"Lebanon",
			"Saint Lucia",
			"Liechtenstein",
			"Sri Lanka",
			"Liberia",
			"Lesotho",
			"Lithuania",
			"Luxembourg",
			"Latvia",
			"Libya",
			"Morocco",
			"Monaco",
			"Moldova",
			"Montenegro",
			"Madagascar",
			"Marshall Islands",
			"Macedonia",
			"Mali",
			"Myanmar",
			"Mongolia",
			"Macao",
			"Northern Mariana Islands",
			"Martinique",
			"Mauritania",
			"Montserrat",
			"Malta",
			"Mauritius",
			"Maldives",
			"Malawi",
			"Mexico",
			"Malaysia",
			"Mozambique",
			"Namibia",
			"New Caledonia",
			"Niger",
			"Norfolk Island",
			"Nigeria",
			"Nicaragua",
			"Netherlands",
			"Norway",
			"Nepal",
			"Nauru",
			"Niue",
			"New Zealand",
			"Oman",
			"Panama",
			"Peru",
			"French Polynesia",
			"Papua New Guinea",
			"Philippines",
			"Pakistan",
			"Poland",
			"Pitcairn",
			"Puerto Rico",
			"Palestine",
			"Portugal",
			"Palau",
			"Paraguay",
			"Qatar",
			"Réunion",
			"Romania",
			"Serbia",
			"Russia",
			"Rwanda",
			"Saudi Arabia",
			"Solomon Islands",
			"Seychelles",
			"Sudan",
			"Sweden",
			"Singapore",
			"Slovenia",
			"Slovakia",
			"Sierra Leone",
			"San Marino",
			"Senegal",
			"Somalia",
			"Suriname",
			"South Sudan",
			"Sao Tome and Principe",
			"El Salvador",
			"Sint Maarten (dutch Part)",
			"Syria",
			"Swaziland",
			"Turks and Caicos Islands",
			"Chad",
			"Togo",
			"Thailand",
			"Tajikistan",
			"Tokelau",
			"Timor-Leste",
			"Turkmenistan",
			"Tunisia",
			"Tonga",
			"Turkey",
			"Trinidad and Tobago",
			"Tuvalu",
			"Taiwan",
			"Tanzania",
			"Ukraine",
			"Uganda",
			"United States",
			"Uruguay",
			"Uzbekistan",
			"Holy See (Vatican City State)",
			"Saint Vincent and The Grenadines",
			"Venezuela",
			"British Virgin Islands",
			"US Virgin Islands",
			"Vietnam",
			"Vanuatu",
			"Wallis and Futuna",
			"Samoa",
			"Serbia",
			"Yemen",
			"Mayotte",
			"South Africa",
			"Zambia",
			"Zimbabwe",
			"United States Minor Outlying Islands",
			"British Indian Ocean Territory"
		);


		$markup = '<form id="edvisor-form">';
		foreach ( $this->wp_edvisor_options as $field => $label ) {

			if( !empty($label['checkbox'])) {
				if($label['required'] == "1") {
					$markup = $markup . '<fieldset class="e-required">';
				} else {
					$markup = $markup . '<fieldset>';
				}
				
				$markup = $markup . '<label>' . $label['label'] . '</label>';

				// If its a regular text field
				if ( in_array($field, $textFields)) {	
					if ($field == "notes") {
						$markup = $markup . '<textarea name="' . $field . '" e="text"></textarea>';
					} else {
						$markup = $markup . '<input type="text" name="' . $field . '" e="text"/>';
					}	
				}

				// If its was a radio now select
				if ( in_array($field, $wasRadioFields)) {
					$markup = $markup . '<select name="' . $field . '" e="radio">';
					foreach($label['option'] as $option => $item) {
						$markup = $markup . '<option custom="'. $option .'">' . $item . '</option>';
					}
					$markup = $markup . '</select>';
				}

				// If Birthday
				if($field == "birthdate") {
					$markup = $markup . '<input type="text" name="' . $field . '" e="text" e-date/>';
				}

				// If Nationality
				if($field == "nationalityId") {
					$markup = $markup . '<select name="' . $field . '" e="nationality">';
					foreach($nationality as $index => $item) {
						$markup = $markup . '<option index="'. $index.'">' . $item . '</option>';
					}
					$markup = $markup . '</select>';
				}

				// If its a predefined select
				if( array_key_exists($field, $selectFields) ) {
					$markup = $markup . '<select name="' . $field . '" e="text">';
						foreach($selectFields[$field] as $num){
							$markup = $markup . '<option>' . $num . '</option>';
						}
					$markup = $markup . '</select>';
				}

				// If it was checked as create own dropdown
				if(in_array($field, $addOwnFields)) {
					if( $label['manual'] == "1" ) {
						if($field == "studentLocationPreferences") {
							$markup = $markup . '<select name="' . $field . '" e="google-manual-tag">';
							foreach($label["options"] as $item => $option){
								$markup = $markup . '<option google="'. $label["ids"][$item] .'">' . $option . '</option>';
							}
						}
						if($field == "currentLocationGooglePlaceId") {
							$markup = $markup . '<select name="' . $field . '" e="google-manual">';
							foreach($label["options"] as $item => $option){
								$markup = $markup . '<option google="'. $label["ids"][$item] .'">' . $option . '</option>';
							}
						}
						if(in_array( $field, $tagFields )) {
							$markup = $markup . '<select name="' . $field . '" e="tag">';
							foreach($label["options"] as $item => $option){
								$markup = $markup . '<option google="'. $label["options"][$item] .'">' . $option . '</option>';
							}
						}
						$markup = $markup . '</select>';
					} else if(in_array( $field, $tagFields )) {
						$markup = $markup . '<input type="text" name="' . $field . '" e="tag"/>';
					} else if(in_array( $field, $googleFields )) {
						$markup = $markup . '<input type="text" name="' . $field . '" e="google"/>';
					}
				}
				$markup = $markup . '</fieldset>';
			}

			// if custom Field
			if($field == "customPropertyValues" && is_array($label)) {
				foreach($label as $custom => $prop) {
					if($prop['required'] == "1") {
						$markup = $markup . '<fieldset class="e-required">';
					} else {
						$markup = $markup . '<fieldset>';
					}
					$markup = $markup . '<label>' . $prop['label'] . '</label>';
					if($prop["type"] == "Dropdown") {
						$markup = $markup . '<select name="' . $field . '" e="custom" custom="' . $prop["id"] . '">';
						if($prop["options"] !== "") {
							foreach($prop["options"] as $option){
								$markup = $markup . '<option>' . $option . '</option>';
							}
						}
						$markup = $markup . '</select>';
					} else if ($prop["type"] == "Date") {
						$markup = $markup . '<input type="text" name="' . $field . '" e="custom" e-date custom="' . $prop["id"] . '"/>';
					} else {
						$markup = $markup . '<input type="text" name="' . $field . '" e="custom" custom="' . $prop["id"] . '"/>';
					}
					$markup = $markup . '</fieldset>';
				}
				
			}

		}
		$markup = $markup . '<button type="submit" class="edvisor-button">' . $this->wp_edvisor_options["submit"] . '</button></form>';

		return $markup;
	}


	// public function wp_edvisor_cdn_jquery(){
	// 	if(!empty($this->wp_edvisor_options['jquery_cdn'])){
	// 		if(!is_admin()){
	// 			if(!empty($this->wp_edvisor_options['cdn_provider'])){
	// 					$link = $this->wp_edvisor_options['cdn_provider'];
	// 				}else{
	// 					$link = 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js';
	// 				}
	// 				$try_url = @fopen($link,'r');
	// 				if( $try_url !== false ) {
	// 					wp_deregister_script( 'jquery' );
	// 					wp_register_script('jquery', $link, array(), null, false);
	// 			}
	// 		}
	// 	}
	// }





	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_edvisor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_edvisor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp_edvisor-public.css', array(), $this->version, 'all' );
		wp_add_inline_style($this->plugin_name, $this->wp_edvisor_options['css']);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_edvisor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_edvisor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp_edvisor-public.js', array( 'jquery', 'jquery-ui-autocomplete', 'jquery-ui-datepicker' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'formValues' , get_option($this->plugin_name) );
	}

}
