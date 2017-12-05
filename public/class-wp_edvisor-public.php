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

		
		// Filtering array by items selected
		$filtered = array_filter($this->wp_edvisor_options, function($items) {
			return !empty($items['checkbox']);
		});

		$chosen = !empty($this->wp_edvisor_options['customPropertyValues']) ? array_merge($filtered, $this->wp_edvisor_options['customPropertyValues']) : $filtered;

		
		// Sort array by order
		function sortByOrder($a, $b) {
			return $a['order'] - $b['order'];
		}

		function edvisorData($field, $label, $type, $other='') {
			$markup = ' ';
			$markup = $markup . 'data-edvisor="id-'.$field.' type-'.$type;
			if(!empty($label['required'])) {
				$markup = $markup . ' validation-required';
			};
			if(!empty($other)) {
				$markup = $markup .' '.$other;
			}
			$markup = $markup .'"';
			return $markup;
		};

		uasort($chosen, 'sortByOrder');


		// var_dump($chosen);
		// Output markup
		$textFields = array("firstname", "lastname", "email", "phone", "address", "postalCode", "passportNumber", "accommodation", "budget", "hoursPerWeek");
		$textAreas = array("notes");
		$selectFields = array("startDay", "startMonth", "startYear", "durationWeekAmount", "nationalityId");
		$wasRadioFields = array("gender", "amOrPm");
		$addOwnFields = array("currentLocationGooglePlaceId", "studentSchoolPreferences", "studentCoursePreferences", "studentLocationPreferences");
		$tagFields = array("currentLocationGooglePlaceId", "studentLocationPreferences");

		$markup = '<form class="edvisor-form">';

		foreach($chosen as $field => $label){
			$markup = $markup . '<div class="edvisor-row">';
			$markup = $markup . '<label>' . $label['label'] . '</label>';

			// If its a regular text field
			if(in_array($field, $textFields, true)){	
				$markup = $markup . '<input type="text"';
				$markup = $markup . 'data-edvisor="id-'.$field.' type-text';
				if(!empty($label['required'])) {
					$markup = $markup . ' validation-required';
				};
				if($field == "email"){
					$markup = $markup . ' validation-email';
				};
				$markup = $markup . '"';
				$markup = $markup . '/>';
			};

			// If its a text area
			if(in_array($field, $textAreas, true)){	
				$markup = $markup . '<textarea ';
				$markup = $markup . edvisorData($field, $label, 'text');
				$markup = $markup . '></textarea>';
			};

			// If its was a radio now select
			if(in_array($field, $wasRadioFields, true)){
				$markup = $markup . '<select';
				$markup = $markup . edvisorData($field, $label, 'text');
				$markup = $markup . '>';
				$markup = $markup . '<option value="" disabled selected hidden></option>';
				foreach($label['option'] as $option => $item) {
					$markup = $markup . '<option value="'.$option.'">'.$item.'</option>';
				}
				$markup = $markup . '</select>';
			};

			// If its a select
			if(in_array($field, $addOwnFields, true)){

				if($label['type'] == "Text") {
					$markup = $markup . '<input type="text"';
					if(in_array($field, $tagFields, true)) {
						$markup = $markup . edvisorData($field, $label, 'google');
					} else {
						$markup = $markup . edvisorData($field, $label, 'tag');
					};
					$markup = $markup . '/>';
				} else if($label['type'] == "Dropdown") {
					$markup = $markup . '<select';
					if(in_array($field, $tagFields, true)) {
						$markup = $markup . edvisorData($field, $label, 'google');
					} else {
						$markup = $markup . edvisorData($field, $label, 'tag');
					};
					$markup = $markup . '>';
					$markup = $markup . '<option value="" disabled selected hidden></option>';

					if(in_array($field, $tagFields, true)) {
						foreach($label['options'] as $option => $item) {
							$markup = $markup . '<option value="'.$label['ids'][$option].'">'.$item.'</option>';
						}
					} else {
						foreach($label['options'] as $option => $item) {
							$markup = $markup . '<option value="'.$item.'">'.$item.'</option>';
						}
					}
					$markup = $markup . '</select>';
				};
			};

			// If its a date field
			if(in_array($field, array("birthdate"), true)){
				$markup = $markup . '<input type="text"';
				$markup = $markup . edvisorData($field, $label, 'text', 'calendar');
				$markup = $markup . '"';
				$markup = $markup . '/>';
			};

			// If its a prepopulated select field
			if(in_array($field, $selectFields, true)) {
				$markup = $markup . '<select';
				$markup = $markup . edvisorData($field, $label, 'text');
				$markup = $markup . '>';
				$markup = $markup . '<option value="" disabled selected hidden></option>';
				$markup = $markup . '</select>';
			};

			// If its a custom field
			if(is_numeric($field)){
				if($label['type'] == "Text") {
					$markup = $markup . '<input type="text"';
					$markup = $markup . edvisorData($label['id'], $label, 'custom');
					$markup = $markup . '/>';
				} else if($label['type'] == "Dropdown"){
					$markup = $markup . '<select';
					$markup = $markup . edvisorData($label['id'], $label, 'custom');
					$markup = $markup . '>';
					$markup = $markup . '<option value="" disabled selected hidden></option>';
					foreach($label['options'] as $option => $item) {
						$markup = $markup . '<option value="'.$item.'">'.$item.'</option>';
					}
					$markup = $markup . '</select>';
				} else if($label['type'] == "Date"){ 
					$markup = $markup . '<input type="text"';
					$markup = $markup . edvisorData($label['id'], $label, 'custom', 'calendar');
					$markup = $markup . '"';
					$markup = $markup . '/>';
				};
			}


			$markup = $markup . '</div>';
		};
		
		$markup = $markup . '<button type="submit" class="edvisor-button">' . $this->wp_edvisor_options["submit"] . '</button></form>';

		return $markup;
	}






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
		wp_deregister_script('edvisorjs');
    wp_register_script('edvisorjs', 'https://dxfy15tq6smtz.cloudfront.net/edvisor.js', false, '1.3.2');
    wp_enqueue_script('edvisorjs');

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp_edvisor-public.js', array( 'jquery', 'jquery-ui-autocomplete', 'jquery-ui-datepicker' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'formValues' , get_option($this->plugin_name) );
	}

}
