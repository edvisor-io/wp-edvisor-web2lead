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

      /* Adds jquery and jquery autocomplete to admin */
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp_edvisor-admin.js', array( 'jquery', 'jquery-ui-autocomplete' ), $this->version, false );

      /* Sends the php variables to the javascript file */
      wp_localize_script($this->plugin_name, 'php_vars', get_option($this->plugin_name));
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

    $fieldArr = array(
      'firstname', 'lastname', 'email', 'phone', 'gender', 'birthdate', 'address', 'currentLocationGooglePlaceId', 'postalCode', 'nationalityId',
      'passportNumber', 'studentLocationPreferences', 'studentSchoolPreferences', 'studentCoursePreferences', 'startDay', 'startMonth', 'startYear',
      'durationWeekAmount', 'accommodation', 'hoursPerWeek', 'amOrPm', 'budget', 'notes'
    );

    for ($i = 0; $i < count($fieldArr); $i++) {
      $valid[$fieldArr[$i]]['checkbox'] = (isset($input[$fieldArr[$i].'_checkbox']) && !empty($input[$fieldArr[$i].'_checkbox'])) ? 1 : 0;

      if(!empty($input[$fieldArr[$i].'_required'])){
        $valid[$fieldArr[$i]]['required'] = 1;
      } else {
        if($this->wp_edvisor_options[$fieldArr[$i]]['required']) {
          $valid[$fieldArr[$i]]['required'] = 1;
        } else {
          $valid[$fieldArr[$i]]['required'] = 0;
        };
      };

      if(!empty($input[$fieldArr[$i].'_label'])){
        $valid[$fieldArr[$i]]['label'] = sanitize_text_field($input[$fieldArr[$i].'_label']);
      } else {
        if($this->wp_edvisor_options[$fieldArr[$i]]['label']) {
          $valid[$fieldArr[$i]]['label'] = $this->wp_edvisor_options[$fieldArr[$i]]['label'];
        } else {
          $valid[$fieldArr[$i]]['label'] = "";
        };
      };

      $valid[$fieldArr[$i]]['order'] = (isset($input[$fieldArr[$i].'_order']) && !empty($input[$fieldArr[$i].'_order']) && is_numeric($input[$fieldArr[$i].'_order'])) ? sanitize_text_field($input[$fieldArr[$i].'_order']) : 0;
    };
    
    
    // Constants
    $valid['firstname']['required'] = 1;
    $valid['firstname']['checkbox'] = 1;
    $valid['firstname']['name'] = 'First Name';
    $valid['lastname']['name'] = 'Last Name';
    $valid['email']['name'] = 'Email';
    $valid['phone']['name'] = 'Phone';
    $valid['gender']['name'] = 'Gender';
    $valid['birthdate']['name'] = 'Birthdate';
    $valid['address']['name'] = 'Address';
    $valid['currentLocationGooglePlaceId']['name'] = 'City, Province/Region';
    $valid['postalCode']['name'] = 'Postal Code/Zip Code';
    $valid['nationalityId']['name'] = 'Nationality';
    $valid['passportNumber']['name'] = 'Passport Number';
    $valid['studentLocationPreferences']['name'] = 'Destinations';
    $valid['studentSchoolPreferences']['name'] = 'Schools';
    $valid['studentCoursePreferences']['name'] = 'Programs/Courses';
    $valid['startDay']['name'] = 'Start Day';
    $valid['startMonth']['name'] = 'Start Month';
    $valid['startYear']['name'] = 'Start Year';
    $valid['durationWeekAmount']['name'] = 'Duration';
    $valid['accommodation']['name'] = 'Accommodation';
    $valid['hoursPerWeek']['name'] = 'Hours Per Week';
    $valid['amOrPm']['name'] = 'Am or Pm';
    $valid['budget']['name'] = 'Budget';
    $valid['notes']['name'] = 'Notes';

    /* Gender */
    $valid['gender']['option']['M'] = (isset($input['M']) && !empty($input['M'])) ? sanitize_text_field($input['M']) : 'Male';
    $valid['gender']['option']['F'] = (isset($input['F']) && !empty($input['F'])) ? sanitize_text_field($input['F']) : 'Female';

    /* City, Provice/Region */
    if(!empty($input['currentLocationGooglePlaceId_type'])){
      $valid['currentLocationGooglePlaceId']['type'] = sanitize_text_field($input['currentLocationGooglePlaceId_type']);
    } else {
      $valid['currentLocationGooglePlaceId']['type'] = $this->wp_edvisor_options['currentLocationGooglePlaceId']['type'];
    };

    if(!empty($input['currentLocationGooglePlaceId_options'])){
      $valid['currentLocationGooglePlaceId']['options'] = $input['currentLocationGooglePlaceId_options'];
    } else {
      if($this->wp_edvisor_options['currentLocationGooglePlaceId']['options']) {
        $valid['currentLocationGooglePlaceId']['options'] = $this->wp_edvisor_options['currentLocationGooglePlaceId']['options'];
      } else {
        $valid['currentLocationGooglePlaceId']['options'] = "";
      };
    };

    if(!empty($input['currentLocationGooglePlaceId_ids'])){
      $valid['currentLocationGooglePlaceId']['ids'] = $input['currentLocationGooglePlaceId_ids'];
    } else {
      if($this->wp_edvisor_options['currentLocationGooglePlaceId']['ids']) {
        $valid['currentLocationGooglePlaceId']['ids'] = $this->wp_edvisor_options['currentLocationGooglePlaceId']['ids'];
      } else {
        $valid['currentLocationGooglePlaceId']['ids'] = "";
      };
    };

    /* Nationality */
    $valid['nationalityId']['lang'] = (isset($input['nationalityId_lang']) && !empty($input['nationalityId_lang'])) ? sanitize_text_field($input['nationalityId_lang']) : '';

    /* Destinations */
    if(!empty($input['studentLocationPreferences_type'])){
      $valid['studentLocationPreferences']['type'] = sanitize_text_field($input['studentLocationPreferences_type']);
    } else {
      $valid['studentLocationPreferences']['type'] = $this->wp_edvisor_options['studentLocationPreferences']['type'];
    };

    if(!empty($input['studentLocationPreferences_options'])){
      $valid['studentLocationPreferences']['options'] = $input['studentLocationPreferences_options'];
    } else {
      if($this->wp_edvisor_options['studentLocationPreferences']['options']) {
        $valid['studentLocationPreferences']['options'] = $this->wp_edvisor_options['studentLocationPreferences']['options'];
      } else {
        $valid['studentLocationPreferences']['options'] = "";
      };
    };

    if(!empty($input['studentLocationPreferences_ids'])){
      $valid['studentLocationPreferences']['ids'] = $input['studentLocationPreferences_ids'];
    } else {
      if($this->wp_edvisor_options['studentLocationPreferences']['ids']) {
        $valid['studentLocationPreferences']['ids'] = $this->wp_edvisor_options['studentLocationPreferences']['ids'];
      } else {
        $valid['studentLocationPreferences']['ids'] = "";
      };
    };

    /* Schools */
    if(!empty($input['studentSchoolPreferences_type'])){
      $valid['studentSchoolPreferences']['type'] = sanitize_text_field($input['studentSchoolPreferences_type']);
    } else {
      $valid['studentSchoolPreferences']['type'] = $this->wp_edvisor_options['studentSchoolPreferences']['type'];
    };

    if(!empty($input['studentSchoolPreferences_options'])){
      $valid['studentSchoolPreferences']['options'] = $input['studentSchoolPreferences_options'];
    } else {
      if($this->wp_edvisor_options['studentSchoolPreferences']['options']) {
        $valid['studentSchoolPreferences']['options'] = $this->wp_edvisor_options['studentSchoolPreferences']['options'];
      } else {
        $valid['studentSchoolPreferences']['options'] = "";
      };
    };

    /* Courses */
    if(!empty($input['studentCoursePreferences_type'])){
      $valid['studentCoursePreferences']['type'] = sanitize_text_field($input['studentCoursePreferences_type']);
    } else {
      $valid['studentCoursePreferences']['type'] = $this->wp_edvisor_options['studentCoursePreferences']['type'];
    };

    if(!empty($input['studentCoursePreferences_options'])){
      $valid['studentCoursePreferences']['options'] = $input['studentCoursePreferences_options'];
    } else {
      if($this->wp_edvisor_options['studentCoursePreferences']['options']) {
        $valid['studentCoursePreferences']['options'] = $this->wp_edvisor_options['studentCoursePreferences']['options'];
      } else {
        $valid['studentCoursePreferences']['options'] = "";
      };
    };
    
    /* AM or PM */
    $valid['amOrPm']['option']['am'] = (isset($input['amOrPm_option_am']) && !empty($input['amOrPm_option_am'])) ? sanitize_text_field($input['amOrPm_option_am']) : 'AM';
    $valid['amOrPm']['option']['pm'] = (isset($input['amOrPm_option_pm']) && !empty($input['amOrPm_option_pm'])) ? sanitize_text_field($input['amOrPm_option_pm']) : 'PM';
    
    /* Custom Fields */
    if(!empty($input['customPropertyValues'])) {

	    foreach($input['customPropertyValues'] as $item => $unit ){

        if(!empty($input['customPropertyValues'][$item]['type'])){
          $type = $input['customPropertyValues'][$item]['type'];
        } else {
          if(isset($this->wp_edvisor_options['customPropertyValues'][$item]['type'])) {
            $type = $this->wp_edvisor_options['customPropertyValues'][$item]['type'];
          } else {
            $type = "Text";
          };
        };

        if(!empty($input['customPropertyValues'][$item]['label'])){
          $label = sanitize_text_field($input['customPropertyValues'][$item]['label']);
        } else {
          if(isset($this->wp_edvisor_options['customPropertyValues'][$item]['label'])) {
            $label = $this->wp_edvisor_options['customPropertyValues'][$item]['label'];
          } else {
            $label = "";
          };
        };

        if(!empty($input['customPropertyValues'][$item]['id'])){
          $id = sanitize_text_field($input['customPropertyValues'][$item]['id']);
        } else {
          if(isset($this->wp_edvisor_options['customPropertyValues'][$item]['id'])) {
            $id = $this->wp_edvisor_options['customPropertyValues'][$item]['id'];
          } else {
            $id = "";
          };
        };

        if(!empty($input['customPropertyValues'][$item]['required'])){
          $required = 1;
        } else {
          if(isset($this->wp_edvisor_options['customPropertyValues'][$item]['required'])) {
            $required = 1;
          } else {
            $required = 0;
          };
        };

        if(!empty($input['customPropertyValues'][$item]['options'])){
          $options = $input['customPropertyValues'][$item]['options'];
        } else {
          if(isset($this->wp_edvisor_options['customPropertyValues'][$item]['options'])) {
            $options = $this->wp_edvisor_options['customPropertyValues'][$item]['options'];
          } else {
            $options = "";
          };
        };

        if(!empty($input['customPropertyValues'][$item]['order'])){
          $order = sanitize_text_field($input['customPropertyValues'][$item]['order']);
        } else {
          if(isset($this->wp_edvisor_options['customPropertyValues'][$item]['order'])) {
            $order = $this->wp_edvisor_options['customPropertyValues'][$item]['order'];
          } else {
            $order = 0;
          };
        };

        $valid['customPropertyValues'][$item] = array('type'=>$type, 'label'=>$label, 'id'=>$id, 'required'=>$required, 'options'=>$options, 'order'=>$order);

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
    $valid['fail_message'] = (isset($input['fail_message']) && !empty($input['fail_message'])) ? sanitize_text_field($input['fail_message']) : 'message';

    /* css block */
		$valid['css'] = (isset($input['css']) && !empty($input['css'])) ? $input['css'] : '';

		/* javascript block */
		$valid['js'] = (isset($input['js']) && !empty($input['js'])) ? $input['js'] : '';
		$valid['jspost'] = (isset($input['jspost']) && !empty($input['jspost'])) ? $input['jspost'] : '';

    return $valid;
	}

}