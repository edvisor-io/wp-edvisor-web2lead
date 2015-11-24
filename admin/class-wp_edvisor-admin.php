<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       edvisor.io
 * @since      1.0.0
 *
 * @package    Wp_edvisor
 * @subpackage Wp_edvisor/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_edvisor
 * @subpackage Wp_edvisor/admin
 * @author     Clarence <clarence@edvisor.io>
 */
class Wp_edvisor_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->wp_edvisor_options = get_option($this->plugin_name);

	}

	/**
	 * Register the stylesheets for the admin area.
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

		if ( 'settings_page_wp_edvisor' == get_current_screen() -> id ) {
			wp_enqueue_style( 'wp_edvisor-form' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp_edvisor-admin.css', array(), $this->version, 'all' );
		}
		

	}

	/**
	 * Register the JavaScript for the admin area.
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

		if ( 'settings_page_wp_edvisor' == get_current_screen() -> id ) {
			wp_enqueue_media();
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp_edvisor-admin.js', array( 'jquery', 'jquery-ui-autocomplete' ), $this->version, false );
		}
		

	}

	public function add_plugin_admin_menu() {

	    /*
	     * Add a settings page for this plugin to the Settings menu.
	     *
	     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
	     *
	     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
	     *
	     */
	    add_options_page( 'Edvisor Forms for WordPress', 'Edvisor Forms', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
	    );
	}

	 /**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	 
	public function add_action_links( $links ) {
	    /*
	    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	    */
	   $settings_link = array(
	    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	 
	public function display_plugin_setup_page() {
	    include_once( 'partials/wp_edvisor-admin-display.php' );
	}


	public function options_update() {
    register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
 	}

	public function validate($input) {       
    $valid = array();

    /* Agency ID & API KEY */
    $valid['agencyId'] = (isset($input['agencyId']) && !empty($input['agencyId'])) ? sanitize_text_field($input['agencyId']) : '';
	    if (empty($input['agencyId'])) {
	    	add_settings_error( 'Agency Id','1','Please Enter an Agency Id' );
	    }
    $valid['apiKey'] = (isset($input['apiKey']) && !empty($input['apiKey'])) ? sanitize_text_field($input['apiKey']) : '';
    	if (empty($input['apiKey'])) {
	    	add_settings_error( 'API Key','2','Please Enter an API Key' );
	    }

    /* First Name */
    $valid['firstname']['checkbox'] = (isset($input['firstname_checkbox']) && !empty($input['firstname_checkbox'])) ? 1 : 0;
    $valid['firstname']['required'] = (isset($input['firstname_required']) && !empty($input['firstname_required'])) ? 1 : 0;
    $valid['firstname']['label'] = (isset($input['firstname_label']) && !empty($input['firstname_label'])) ? sanitize_text_field($input['firstname_label']) : '';
    
    /* Last Name */
    $valid['lastname']['checkbox'] = (isset($input['lastname_checkbox']) && !empty($input['lastname_checkbox'])) ? 1: 0;
    $valid['lastname']['required'] = (isset($input['lastname_required']) && !empty($input['lastname_required'])) ? 1: 0;
    $valid['lastname']['label'] = (isset($input['lastname_label']) && !empty($input['lastname_label'])) ? sanitize_text_field($input['lastname_label']) : '';
    
    /* Email */
    $valid['email']['checkbox'] = (isset($input['email_checkbox']) && !empty($input['email_checkbox'])) ? 1 : 0;
    $valid['email']['required'] = (isset($input['email_required']) && !empty($input['email_required'])) ? 1 : 0;
    $valid['email']['label'] = (isset($input['email_label']) && !empty($input['email_label'])) ? sanitize_text_field($input['email_label']) : '';

    /* Phone Number */
    $valid['phone']['checkbox'] = (isset($input['phone_checkbox']) && !empty($input['phone_checkbox'])) ? 1 : 0;
    $valid['phone']['required'] = (isset($input['phone_required']) && !empty($input['phone_required'])) ? 1 : 0;
    $valid['phone']['label'] = (isset($input['phone_label']) && !empty($input['phone_label'])) ? sanitize_text_field($input['phone_label']) : '';
    
    /* Gender */
    $valid['gender']['checkbox'] = (isset($input['gender_checkbox']) && !empty($input['gender_checkbox'])) ? 1 : 0;
    $valid['gender']['required'] = (isset($input['gender_required']) && !empty($input['gender_required'])) ? 1 : 0;
    $valid['gender']['label'] = (isset($input['gender_label']) && !empty($input['gender_label'])) ? sanitize_text_field($input['gender_label']) : '';
    $valid['gender']['option']['M'] = (isset($input['gender_option_m']) && !empty($input['gender_option_m'])) ? sanitize_text_field($input['gender_option_m']) : '';
    $valid['gender']['option']['F'] = (isset($input['gender_option_f']) && !empty($input['gender_option_f'])) ? sanitize_text_field($input['gender_option_f']) : '';

    /* Birthdate */
    $valid['birthdate']['checkbox'] = (isset($input['birthdate_checkbox']) && !empty($input['birthdate_checkbox'])) ? 1 : 0;
    $valid['birthdate']['required'] = (isset($input['birthdate_required']) && !empty($input['birthdate_required'])) ? 1 : 0;
    $valid['birthdate']['label'] = (isset($input['birthdate_label']) && !empty($input['birthdate_label'])) ? sanitize_text_field($input['birthdate_label']) : '';
    
    /* Home Address */
    $valid['address']['checkbox'] = (isset($input['address_checkbox']) && !empty($input['address_checkbox'])) ? 1 : 0;
    $valid['address']['required'] = (isset($input['address_required']) && !empty($input['address_required'])) ? 1 : 0;
    $valid['address']['label'] = (isset($input['address_label']) && !empty($input['address_label'])) ? sanitize_text_field($input['address_label']) : '';
    
    /* City, Provice/Region */
    $valid['currentLocationGooglePlaceId']['checkbox'] = (isset($input['currentLocationGooglePlaceId_checkbox']) && !empty($input['currentLocationGooglePlaceId_checkbox'])) ? 1 : 0;
    $valid['currentLocationGooglePlaceId']['required'] = (isset($input['currentLocationGooglePlaceId_required']) && !empty($input['currentLocationGooglePlaceId_required'])) ? 1 : 0;
    $valid['currentLocationGooglePlaceId']['label'] = (isset($input['currentLocationGooglePlaceId_label']) && !empty($input['currentLocationGooglePlaceId_label'])) ? sanitize_text_field($input['currentLocationGooglePlaceId_label']) : '';
    $valid['currentLocationGooglePlaceId']['manual'] = (isset($input['currentLocationGooglePlaceId_manual']) && !empty($input['currentLocationGooglePlaceId_manual'])) ? sanitize_text_field($input['currentLocationGooglePlaceId_manual']) : '';
    $valid['currentLocationGooglePlaceId']['options'] = (isset($input['currentLocationGooglePlaceId_options']) && !empty($input['currentLocationGooglePlaceId_options'])) ? $input['currentLocationGooglePlaceId_options'] : '';
    $valid['currentLocationGooglePlaceId']['ids'] = (isset($input['currentLocationGooglePlaceId_ids']) && !empty($input['currentLocationGooglePlaceId_ids'])) ? $input['currentLocationGooglePlaceId_ids'] : '';

    /* Postal Code */
    $valid['postalCode']['checkbox'] = (isset($input['postalcode_checkbox']) && !empty($input['postalcode_checkbox'])) ? 1 : 0;
    $valid['postalCode']['required'] = (isset($input['postalcode_required']) && !empty($input['postalcode_required'])) ? 1 : 0;
    $valid['postalCode']['label'] = (isset($input['postalcode_label']) && !empty($input['postalcode_label'])) ? sanitize_text_field($input['postalcode_label']) : '';
    
    /* Nationality */
    $valid['nationalityId']['checkbox'] = (isset($input['nationalityId_checkbox']) && !empty($input['nationalityId_checkbox'])) ? 1 : 0;
    $valid['nationalityId']['required'] = (isset($input['nationalityId_required']) && !empty($input['nationalityId_required'])) ? 1 : 0;
    $valid['nationalityId']['label'] = (isset($input['nationalityId_label']) && !empty($input['nationalityId_label'])) ? sanitize_text_field($input['nationalityId_label']) : '';
    $valid['nationalityId']['lang'] = (isset($input['nationalityId_lang']) && !empty($input['nationalityId_lang'])) ? sanitize_text_field($input['nationalityId_lang']) : '';

    /* Passport Number */
    $valid['passportNumber']['checkbox'] = (isset($input['passportnumber_checkbox']) && !empty($input['passportnumber_checkbox'])) ? 1 : 0;
    $valid['passportNumber']['required'] = (isset($input['passportnumber_required']) && !empty($input['passportnumber_required'])) ? 1 : 0;
    $valid['passportNumber']['label'] = (isset($input['passportnumber_label']) && !empty($input['passportnumber_label'])) ? sanitize_text_field($input['passportnumber_label']) : '';
    
    /* Destinations */
    $valid['studentLocationPreferences']['checkbox'] = (isset($input['studentLocationPreferences_checkbox']) && !empty($input['studentLocationPreferences_checkbox'])) ? 1 : 0;
    $valid['studentLocationPreferences']['required'] = (isset($input['studentLocationPreferences_required']) && !empty($input['studentLocationPreferences_required'])) ? 1 : 0;
    $valid['studentLocationPreferences']['label'] = (isset($input['studentLocationPreferences_label']) && !empty($input['studentLocationPreferences_label'])) ? sanitize_text_field($input['studentLocationPreferences_label']) : '';
    $valid['studentLocationPreferences']['manual'] = (isset($input['studentLocationPreferences_manual']) && !empty($input['studentLocationPreferences_manual'])) ? sanitize_text_field($input['studentLocationPreferences_manual']) : '';
    $valid['studentLocationPreferences']['options'] = (isset($input['studentLocationPreferences_options']) && !empty($input['studentLocationPreferences_options'])) ? $input['studentLocationPreferences_options'] : '';
    $valid['studentLocationPreferences']['ids'] = (isset($input['studentLocationPreferences_ids']) && !empty($input['studentLocationPreferences_ids'])) ? $input['studentLocationPreferences_ids'] : '';

    /* Schools */
    $valid['studentSchoolPreferences']['checkbox'] = (isset($input['studentSchoolPreferences_checkbox']) && !empty($input['studentSchoolPreferences_checkbox'])) ? 1 : 0;
    $valid['studentSchoolPreferences']['required'] = (isset($input['studentSchoolPreferences_required']) && !empty($input['studentSchoolPreferences_required'])) ? 1 : 0;
    $valid['studentSchoolPreferences']['label'] = (isset($input['studentSchoolPreferences_label']) && !empty($input['studentSchoolPreferences_label'])) ? sanitize_text_field($input['studentSchoolPreferences_label']) : '';
    $valid['studentSchoolPreferences']['manual'] = (isset($input['studentSchoolPreferences_manual']) && !empty($input['studentSchoolPreferences_manual'])) ? sanitize_text_field($input['studentSchoolPreferences_manual']) : '';
    $valid['studentSchoolPreferences']['options'] = (isset($input['studentSchoolPreferences_options']) && !empty($input['studentSchoolPreferences_options'])) ? $input['studentSchoolPreferences_options'] : '';

    /* Courses */
    $valid['studentCoursePreferences']['checkbox'] = (isset($input['studentCoursePreferences_checkbox']) && !empty($input['studentCoursePreferences_checkbox'])) ? 1 : 0;
    $valid['studentCoursePreferences']['required'] = (isset($input['studentCoursePreferences_required']) && !empty($input['studentCoursePreferences_required'])) ? 1 : 0;
    $valid['studentCoursePreferences']['label'] = (isset($input['studentCoursePreferences_label']) && !empty($input['studentCoursePreferences_label'])) ? sanitize_text_field($input['studentCoursePreferences_label']) : '';
    $valid['studentCoursePreferences']['manual'] = (isset($input['studentCoursePreferences_manual']) && !empty($input['studentCoursePreferences_manual'])) ? sanitize_text_field($input['studentCoursePreferences_manual']) : '';
    $valid['studentCoursePreferences']['options'] = (isset($input['studentCoursePreferences_options']) && !empty($input['studentCoursePreferences_options'])) ? $input['studentCoursePreferences_options'] : '';

    /* Start Day */
    $valid['startDay']['checkbox'] = (isset($input['startDay_checkbox']) && !empty($input['startDay_checkbox'])) ? 1 : 0;
    $valid['startDay']['required'] = (isset($input['startDay_required']) && !empty($input['startDay_required'])) ? 1 : 0;
    $valid['startDay']['label'] = (isset($input['startDay_label']) && !empty($input['startDay_label'])) ? sanitize_text_field($input['startDay_label']) : '';
    
    /* Start Month */
    $valid['startMonth']['checkbox'] = (isset($input['startMonth_checkbox']) && !empty($input['startMonth_checkbox'])) ? 1 : 0;
    $valid['startMonth']['required'] = (isset($input['startMonth_required']) && !empty($input['startMonth_required'])) ? 1 : 0;
    $valid['startMonth']['label'] = (isset($input['startMonth_label']) && !empty($input['startMonth_label'])) ? sanitize_text_field($input['startMonth_label']) : '';

    /* Start Year */
    $valid['startYear']['checkbox'] = (isset($input['startYear_checkbox']) && !empty($input['startYear_checkbox'])) ? 1 : 0;
    $valid['startYear']['required'] = (isset($input['startYear_required']) && !empty($input['startYear_required'])) ? 1 : 0;
    $valid['startYear']['label'] = (isset($input['startYear_label']) && !empty($input['startYear_label'])) ? sanitize_text_field($input['startYear_label']) : '';

    /* Duration */
    $valid['durationWeekAmount']['checkbox'] = (isset($input['durationWeekAmount_checkbox']) && !empty($input['durationWeekAmount_checkbox'])) ? 1 : 0;
    $valid['durationWeekAmount']['required'] = (isset($input['durationWeekAmount_required']) && !empty($input['durationWeekAmount_required'])) ? 1 : 0;
    $valid['durationWeekAmount']['label'] = (isset($input['durationWeekAmount_label']) && !empty($input['durationWeekAmount_label'])) ? sanitize_text_field($input['durationWeekAmount_label']) : '';

    /* Accommodations */
    $valid['accommodation']['checkbox'] = (isset($input['accommodation_checkbox']) && !empty($input['accommodation_checkbox'])) ? 1 : 0;
    $valid['accommodation']['required'] = (isset($input['accommodation_required']) && !empty($input['accommodation_required'])) ? 1 : 0;
    $valid['accommodation']['label'] = (isset($input['accommodation_label']) && !empty($input['accommodation_label'])) ? sanitize_text_field($input['accommodation_label']) : '';
    
    /* Hours Per Week */
    $valid['hoursPerWeek']['checkbox'] = (isset($input['hoursperweek_checkbox']) && !empty($input['hoursperweek_checkbox'])) ? 1 : 0;
    $valid['hoursPerWeek']['required'] = (isset($input['hoursperweek_required']) && !empty($input['hoursperweek_required'])) ? 1 : 0;
    $valid['hoursPerWeek']['label'] = (isset($input['hoursperweek_label']) && !empty($input['hoursperweek_label'])) ? sanitize_text_field($input['hoursperweek_label']) : '';
    
    /* AM or PM */
    $valid['amOrPm']['checkbox'] = (isset($input['amOrPm_checkbox']) && !empty($input['amOrPm_checkbox'])) ? 1 : 0;
    $valid['amOrPm']['required'] = (isset($input['amOrPm_required']) && !empty($input['amOrPm_required'])) ? 1 : 0;
    $valid['amOrPm']['label'] = (isset($input['amOrPm_label']) && !empty($input['amOrPm_label'])) ? sanitize_text_field($input['amOrPm_label']) : '';
    $valid['amOrPm']['option']['am'] = (isset($input['amOrPm_option_am']) && !empty($input['amOrPm_option_am'])) ? sanitize_text_field($input['amOrPm_option_am']) : '';
    $valid['amOrPm']['option']['pm'] = (isset($input['amOrPm_option_pm']) && !empty($input['amOrPm_option_pm'])) ? sanitize_text_field($input['amOrPm_option_pm']) : '';

    /* Budget */
    $valid['budget']['checkbox'] = (isset($input['budget_checkbox']) && !empty($input['budget_checkbox'])) ? 1 : 0;
    $valid['budget']['required'] = (isset($input['budget_required']) && !empty($input['budget_required'])) ? 1 : 0;
    $valid['budget']['label'] = (isset($input['budget_label']) && !empty($input['budget_label'])) ? sanitize_text_field($input['budget_label']) : '';
    
    /* Notes */
    $valid['notes']['checkbox'] = (isset($input['notes_checkbox']) && !empty($input['notes_checkbox'])) ? 1 : 0;
    $valid['notes']['required'] = (isset($input['notes_required']) && !empty($input['notes_required'])) ? 1 : 0;
    $valid['notes']['label'] = (isset($input['notes_label']) && !empty($input['notes_label'])) ? sanitize_text_field($input['notes_label']) : '';

    /* Custom Fields */
    if(!empty($input['customPropertyValues'])) {
	    foreach($input['customPropertyValues'] as $item => $unit ){
				$valid['customPropertyValues'][$item]['type'] = (isset($input['customPropertyValues'][$item]['type']) && !empty($input['customPropertyValues'][$item]['type'])) ? sanitize_text_field($input['customPropertyValues'][$item]['type']) : '';
				$valid['customPropertyValues'][$item]['label'] = (isset($input['customPropertyValues'][$item]['label']) && !empty($input['customPropertyValues'][$item]['label'])) ? sanitize_text_field($input['customPropertyValues'][$item]['label']) : '';
				$valid['customPropertyValues'][$item]['id'] = (isset($input['customPropertyValues'][$item]['id']) && !empty($input['customPropertyValues'][$item]['id'])) ? sanitize_text_field($input['customPropertyValues'][$item]['id']) : '';
				$valid['customPropertyValues'][$item]['required'] = (isset($input['customPropertyValues'][$item]['required']) && !empty($input['customPropertyValues'][$item]['required'])) ? $input['customPropertyValues'][$item]['required'] : '';
				$valid['customPropertyValues'][$item]['options'] = (isset($input['customPropertyValues'][$item]['options']) && !empty($input['customPropertyValues'][$item]['options'])) ? $input['customPropertyValues'][$item]['options'] : '';
	    }
    } else {
    	$valid['customPropertyValues'] = '';
    }

    /* Settings */
    $valid['submit'] = (isset($input['submit']) && !empty($input['submit'])) ? sanitize_text_field($input['submit']) : '';
    $valid['valid_required'] = (isset($input['valid_required']) && !empty($input['valid_required'])) ? sanitize_text_field($input['valid_required']) : 'This field is required';
    $valid['valid_email'] = (isset($input['valid_email']) && !empty($input['valid_email'])) ? sanitize_text_field($input['valid_email']) : 'This email is invalid';
    $valid['success_radio'] = (isset($input['success_radio']) && !empty($input['success_radio'])) ? sanitize_text_field($input['success_radio']) : '';
    $valid['success_message'] = (isset($input['success_message']) && !empty($input['success_message'])) ? sanitize_text_field($input['success_message']) : 'message';
    $valid['success_url'] = (isset($input['success_url']) && !empty($input['success_url'])) ? sanitize_text_field($input['success_url']) : 'http://';

    /* css block */
		$valid['css'] = (isset($input['css']) && !empty($input['css'])) ? sanitize_text_field($input['css']) : '';

		/* javascript block */
		$valid['js'] = (isset($input['js']) && !empty($input['js'])) ? $input['js'] : '';
		$valid['jspost'] = (isset($input['jspost']) && !empty($input['jspost'])) ? $input['jspost'] : '';

    return $valid;
	}

}
