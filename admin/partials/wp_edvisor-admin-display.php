<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       edvisor.io
 * @since      1.0.0
 *
 * @package    Wp_edvisor
 * @subpackage Wp_edvisor/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

<h2><?php echo esc_html(get_admin_page_title()); ?></h2>

<div class='edvisor-text'>Build your edvisor form
<p> Use the shortcode to add the form to your page: [edvisor_form] </p>
</div>

<form class="edvisor-container" method="post" name="cleanup_options" action="options.php">
 <?php
	$options = get_option($this->plugin_name);

	$agencyId = $options['agencyId'];
	$apiKey = $options['apiKey'];

	$firstname_checkbox = $options['firstname']['checkbox'];
	$firstname_required = $options['firstname']['required'];
	$firstname_label = $options['firstname']['label'];

	$lastname_checkbox = $options['lastname']['checkbox'];
	$lastname_required = $options['lastname']['required'];
	$lastname_label = $options['lastname']['label'];

	$email_checkbox = $options['email']['checkbox'];
	$email_required = $options['email']['required'];
	$email_label = $options['email']['label'];

	$phone_checkbox = $options['phone']['checkbox'];
	$phone_required = $options['phone']['required'];
	$phone_label = $options['phone']['label'];

	$gender_checkbox = $options['gender']['checkbox'];
	$gender_required = $options['gender']['required'];
	$gender_label = $options['gender']['label'];
	$gender_option_m = $options['gender']['option']['M'];
	$gender_option_f = $options['gender']['option']['F'];

	$birthdate_checkbox = $options['birthdate']['checkbox'];
	$birthdate_required = $options['birthdate']['required'];
	$birthdate_label = $options['birthdate']['label'];

	$address_checkbox = $options['address']['checkbox'];
	$address_required = $options['address']['required'];
	$address_label = $options['address']['label'];

	$currentLocationGooglePlaceId_checkbox = $options['currentLocationGooglePlaceId']['checkbox'];
	$currentLocationGooglePlaceId_required = $options['currentLocationGooglePlaceId']['required'];
	$currentLocationGooglePlaceId_label = $options['currentLocationGooglePlaceId']['label'];
	$currentLocationGooglePlaceId_manual = $options['currentLocationGooglePlaceId']['manual'];
	$currentLocationGooglePlaceId_options = $options['currentLocationGooglePlaceId']['options'];
	$currentLocationGooglePlaceId_ids = $options['currentLocationGooglePlaceId']['ids'];

	$postalcode_checkbox = $options['postalCode']['checkbox'];
	$postalcode_required = $options['postalCode']['required'];
	$postalcode_label = $options['postalCode']['label'];

	$nationalityId_checkbox = $options['nationalityId']['checkbox'];
	$nationalityId_required = $options['nationalityId']['required'];
	$nationalityId_label = $options['nationalityId']['label'];
	$nationalityId_lang = $options['nationalityId']['lang'];

	$passportnumber_checkbox = $options['passportNumber']['checkbox'];
	$passportnumber_required = $options['passportNumber']['required'];
	$passportnumber_label = $options['passportNumber']['label'];

	$studentLocationPreferences_checkbox = $options['studentLocationPreferences']['checkbox'];
	$studentLocationPreferences_required = $options['studentLocationPreferences']['required'];
	$studentLocationPreferences_label = $options['studentLocationPreferences']['label'];
	$studentLocationPreferences_manual = $options['studentLocationPreferences']['manual'];
	$studentLocationPreferences_options = $options['studentLocationPreferences']['options'];
	$studentLocationPreferences_ids = $options['studentLocationPreferences']['ids'];

	$studentSchoolPreferences_checkbox = $options['studentSchoolPreferences']['checkbox'];
	$studentSchoolPreferences_required = $options['studentSchoolPreferences']['required'];
	$studentSchoolPreferences_label = $options['studentSchoolPreferences']['label'];
	$studentSchoolPreferences_manual = $options['studentSchoolPreferences']['manual'];
	$studentSchoolPreferences_options = $options['studentSchoolPreferences']['options'];

	$studentCoursePreferences_checkbox = $options['studentCoursePreferences']['checkbox'];
	$studentCoursePreferences_required = $options['studentCoursePreferences']['required'];
	$studentCoursePreferences_label = $options['studentCoursePreferences']['label'];
	$studentCoursePreferences_manual = $options['studentCoursePreferences']['manual'];
	$studentCoursePreferences_options = $options['studentCoursePreferences']['options'];

	$startDay_checkbox = $options['startDay']['checkbox'];
	$startDay_required = $options['startDay']['required'];
	$startDay_label = $options['startDay']['label'];

	$startMonth_checkbox = $options['startMonth']['checkbox'];
	$startMonth_required = $options['startMonth']['required'];
	$startMonth_label = $options['startMonth']['label'];

	$startYear_checkbox = $options['startYear']['checkbox'];
	$startYear_required = $options['startYear']['required'];
	$startYear_label = $options['startYear']['label'];

	$durationWeekAmount_checkbox = $options['durationWeekAmount']['checkbox'];
	$durationWeekAmount_required = $options['durationWeekAmount']['required'];
	$durationWeekAmount_label = $options['durationWeekAmount']['label'];

	$accommodation_checkbox = $options['accommodation']['checkbox'];
	$accommodation_required = $options['accommodation']['required'];
	$accommodation_label = $options['accommodation']['label'];

	$hoursperweek_checkbox = $options['hoursPerWeek']['checkbox'];
	$hoursperweek_required = $options['hoursPerWeek']['required'];
	$hoursperweek_label = $options['hoursPerWeek']['label'];

	$amOrPm_checkbox = $options['amOrPm']['checkbox'];
	$amOrPm_required = $options['amOrPm']['required'];
	$amOrPm_label = $options['amOrPm']['label'];
	$amOrPm_option_am = $options['amOrPm']['option']['am'];
	$amOrPm_option_pm = $options['amOrPm']['option']['pm'];

	$budget_checkbox = $options['budget']['checkbox'];
	$budget_required = $options['budget']['required'];
	$budget_label = $options['budget']['label'];

	$notes_checkbox = $options['notes']['checkbox'];
	$notes_required = $options['notes']['required'];
	$notes_label = $options['notes']['label'];

	$customPropertyValues = $options['customPropertyValues'];

	$submit = $options['submit'];
	$valid_required = $options['valid_required'];
	$valid_email = $options['valid_email'];
	$success_message = $options['success_message'];
	$success_radio = $options['success_radio'];
	$success_url = $options['success_url'];

	$css = $options['css'];
	$js = $options['js'];
	$jspost = $options['jspost'];

	// var_dump($options);

?>
<?php
	settings_fields($this->plugin_name);
	do_settings_sections($this->plugin_name);
?>

<hr>
<!-- Agency ID -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Agency ID', $this->plugin_name);?></span></legend>
	<label class="edvisor-field edvisor-non-form-label" for="<?php echo $this->plugin_name; ?>-id"><?php esc_attr_e('Agency ID', $this->plugin_name); ?></label>
	<input type='text' class="small-text" id="<?php echo $this->plugin_name; ?>-agencyid" name="<?php echo $this->plugin_name; ?>[agencyId]" value="<?php if(!(empty($agencyId))) echo $agencyId ?>"/>
	<p class="edvisor-info">You can find your Agency ID in your office settings. This field puts all your form information into an Edvisor office. </p>
</fieldset>

<!-- API Key -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('API Key', $this->plugin_name);?></span></legend>
	<label class="edvisor-field edvisor-non-form-label" for="<?php echo $this->plugin_name; ?>-id"><?php esc_attr_e('API Key', $this->plugin_name); ?></label>
	<input type='text' class="regular-text" id="<?php echo $this->plugin_name; ?>-apikey" name="<?php echo $this->plugin_name; ?>[apiKey]" value="<?php if(!(empty($apiKey))) echo $apiKey ?>"/>
	<p class="edvisor-info">Please contact us if you don't know your API Key. An API Key gives you access to Edvisor.io's API. Without it, you won't be able to submit your forms to Edvisor.</p>
</fieldset>

<hr>
<h4 class='edvisor-headers'>
	<span><?php _e('Edvisor Field', $this->plugin_name);?></span>
	<span><?php _e('Label Name', $this->plugin_name);?></span>
	<span><?php _e('Required', $this->plugin_name);?></span>
	<span><?php _e('Other', $this->plugin_name);?></span>
</h4>
<hr>

<!-- First Name -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('First Name', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-firstname">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-firstname_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[firstname_checkbox]" value="1" checked onclick="return false" <?php checked($firstname_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('First Name', $this->plugin_name); ?></span>
		<input type="text" class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-firstname_label" name="<?php echo $this->plugin_name; ?>[firstname_label]" value="<?php echo $firstname_label?:$firstname_label='First Name' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-firstname_required" name="<?php echo $this->plugin_name; ?>[firstname_required]" value="1" checked onclick="return false" <?php checked($firstname_required, 1); ?>/>
	</label>
</fieldset>

<!-- Last Name -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Last Name', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-lastname">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-lastname_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[lastname_checkbox]" value="1" <?php checked($lastname_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Last Name', $this->plugin_name); ?></span>
		<input type="text" class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-lastname_label" name="<?php echo $this->plugin_name; ?>[lastname_label]" value="<?php echo $lastname_label?:$lastname_label='Last Name' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-lastname_required" name="<?php echo $this->plugin_name; ?>[lastname_required]" value="1" <?php checked($lastname_required, 1); ?>/>
	</label>
</fieldset>

<!-- Email -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Email Address', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-email">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-email_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[email_checkbox]" value="1" <?php checked($email_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Email Address', $this->plugin_name); ?></span>
		<input type="text" class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-email_label" name="<?php echo $this->plugin_name; ?>[email_label]" value="<?php echo $email_label?:$email_label='Email' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-email_required" name="<?php echo $this->plugin_name; ?>[email_required]" value="1" <?php checked($email_required, 1); ?>/>
	</label>
</fieldset>

<!-- Phone -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Phone Number', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-phone">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-phone_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[phone_checkbox]" value="1" <?php checked($phone_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Phone Number', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-phone_label" name="<?php echo $this->plugin_name; ?>[phone_label]" value="<?php echo $phone_label?:$phone_label='Phone Number' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-phone_required" name="<?php echo $this->plugin_name; ?>[phone_required]" value="1" <?php checked($phone_required, 1); ?>/>
	</label>
</fieldset>

<!-- Gender -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Gender', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-gender">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-gender_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[gender_checkbox]" value="1" <?php checked($gender_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Gender', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-gender_label" name="<?php echo $this->plugin_name; ?>[gender_label]" value="<?php echo $gender_label?:$gender_label='Gender' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-gender_required" name="<?php echo $this->plugin_name; ?>[gender_required]" value="1" <?php checked($gender_required, 1); ?>/>
		<input type="text" class="edvisor-other-input" name="<?php echo $this->plugin_name; ?>[gender_option_m]" value="<?php echo $gender_option_m?:$gender_option_m='Male' ?>">
		<input type="text" class="edvisor-other-input" name="<?php echo $this->plugin_name; ?>[gender_option_f]" value="<?php echo $gender_option_f?:$gender_option_f='Female' ?>">
	</label>
</fieldset>

<!-- Birthdate -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Birthdate', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-birthdate">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-birthdate_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[birthdate_checkbox]" value="1" <?php checked($birthdate_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Birthdate', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-birthdate_label" name="<?php echo $this->plugin_name; ?>[birthdate_label]" value="<?php echo $birthdate_label?:$birthdate_label='Birthdate' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-birthdate_required" name="<?php echo $this->plugin_name; ?>[birthdate_required]" value="1" <?php checked($birthdate_required, 1); ?>/>
	</label>
</fieldset>

<!-- Address -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Home Address', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-address">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-address_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[address_checkbox]" value="1" <?php checked($address_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Home Address', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-address_label" name="<?php echo $this->plugin_name; ?>[address_label]" value="<?php echo $address_label?:$address_label='Home Address' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-address_required" name="<?php echo $this->plugin_name; ?>[address_required]" value="1" <?php checked($address_required, 1); ?>/>
	</label>
</fieldset>

<!-- City, Province/Region -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('City, Provinces/Region', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-location">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-location_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[currentLocationGooglePlaceId_checkbox]" value="1" <?php checked($currentLocationGooglePlaceId_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('City, Provinces/Region', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-location_label" name="<?php echo $this->plugin_name; ?>[currentLocationGooglePlaceId_label]" value="<?php echo $currentLocationGooglePlaceId_label?:$currentLocationGooglePlaceId_label='City, Provinces/Region' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-location_required" name="<?php echo $this->plugin_name; ?>[currentLocationGooglePlaceId_required]" value="1" <?php checked($currentLocationGooglePlaceId_required, 1); ?>/>
		<span class="edvisor-manual-text"><?php _e('Add your own dropdown', $this->plugin_name);?></span>
		<input type="checkbox" class="edvisor-manual" id="<?php echo $this->plugin_name; ?>-location_manual" name="<?php echo $this->plugin_name; ?>[currentLocationGooglePlaceId_manual]" value="1" <?php checked($currentLocationGooglePlaceId_manual, 1); ?>/>
		<div id="<?php echo $this->plugin_name; ?>-location_dropdown" class='edvisor-dropdown' type='location'>
			<div id='<?php echo $this->plugin_name; ?>-location_container'>
				<?php 
					if( $currentLocationGooglePlaceId_options ){
						foreach($currentLocationGooglePlaceId_options as $item => $option){ 
						echo '<div class="edvisor-item"><input type="text" class="edvisor-dropdown-input" e-google name="wp_edvisor[currentLocationGooglePlaceId_options][]" value="' . $option . '"/><input type="text" name="wp_edvisor[currentLocationGooglePlaceId_ids][]" value="' . $currentLocationGooglePlaceId_ids[$item] . '" hidden/><span class="edvisor-delete">x</span></div>'; } 
					} 
				?>
			</div>
			<div class='edvisor-add'>+ <?php _e('Add More', $this->plugin_name);?></div>
		</div>
	</label>
</fieldset>

<!-- Postal Code -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Postal Code', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-postalcode">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-postalcode_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[postalcode_checkbox]" value="1" <?php checked($postalcode_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Postal Code', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-postalcode_label" name="<?php echo $this->plugin_name; ?>[postalcode_label]" value="<?php echo $postalcode_label?:$postalcode_label='Postal Code' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-postalcode_required" name="<?php echo $this->plugin_name; ?>[postalcode_required]" value="1" <?php checked($postalcode_required, 1); ?>/>
	</label>
</fieldset>

<!-- Nationality -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Nationality', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-nationality">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-nationality_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[nationalityId_checkbox]" value="1" <?php checked($nationalityId_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Nationality', $this->plugin_name); ?></span>
		<input type="text" class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-nationality_label" name="<?php echo $this->plugin_name; ?>[nationalityId_label]" value="<?php echo $nationalityId_label?:$nationalityId_label='Nationality' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-nationality_required" name="<?php echo $this->plugin_name; ?>[nationalityId_required]" value="1" <?php checked($nationalityId_required, 1); ?>/>
<!-- 		<span class="edvisor-manual-text">Language</span>
		<select id="<?php echo $this->plugin_name; ?>-nationality_lang" class="edvisor-select" name="<?php echo $this->plugin_name; ?>[nationalityId_lang]">
			<option value='English' <?php if($nationalityId_lang == "English") echo "selected"; ?>>English</option>
			<option value='Spanish' <?php if($nationalityId_lang == "Spanish") echo "selected"; ?>>Spanish</option>
			<option value='Portuguese' <?php if($nationalityId_lang == "Portuguese") echo "selected"; ?>>Portuguese</option>
		</select> -->
	</label>
</fieldset>

<!-- Passport Number -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Passport Number', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-passportnumber">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-passportnumber_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[passportnumber_checkbox]" value="1" <?php checked($passportnumber_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Passport Number', $this->plugin_name); ?></span>
		<input type="text" class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-passportnumber_label" name="<?php echo $this->plugin_name; ?>[passportnumber_label]" value="<?php echo $passportnumber_label?:$passportnumber_label='Passport Number' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-passportnumber_required" name="<?php echo $this->plugin_name; ?>[passportnumber_required]" value="1" <?php checked($passportnumber_required, 1); ?>/>
	</label>
</fieldset>

<!-- Destinations -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Destinations', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-destinations">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-destinations_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[studentLocationPreferences_checkbox]" value="1" <?php checked($studentLocationPreferences_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Destinations', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-destinations_label" name="<?php echo $this->plugin_name; ?>[studentLocationPreferences_label]" value="<?php echo $studentLocationPreferences_label?:$studentLocationPreferences_label='Destinations' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-destinations_required" name="<?php echo $this->plugin_name; ?>[studentLocationPreferences_required]" value="1" <?php checked($studentLocationPreferences_required, 1); ?>/>
		<span class="edvisor-manual-text"><?php _e('Add your own dropdown', $this->plugin_name);?></span>
		<input type="checkbox" class="edvisor-manual" id="<?php echo $this->plugin_name; ?>-destinations_manual" name="<?php echo $this->plugin_name; ?>[studentLocationPreferences_manual]" value="1" <?php checked($studentLocationPreferences_manual, 1); ?>/>
		<div id="<?php echo $this->plugin_name; ?>-destinations_dropdown" class='edvisor-dropdown' type='destinations'>
			<div id='<?php echo $this->plugin_name; ?>-destinations_container'>
				<?php 
					if( $studentLocationPreferences_options ){
						foreach($studentLocationPreferences_options as $item => $option){ 
						echo '<div class="edvisor-item"><input type="text" class="edvisor-dropdown-input" e-google name="wp_edvisor[studentLocationPreferences_options][]" value="' . $option . '"/><input type="text" name="wp_edvisor[studentLocationPreferences_ids][]" value="' . $studentLocationPreferences_ids[$item] . '" hidden/><span class="edvisor-delete">x</span></div>'; } 
					} 
				?>
			</div>
			<div class='edvisor-add'>+ <?php _e('Add More', $this->plugin_name);?></div>
		</div>
	</label>
</fieldset>

<!-- Schools -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Schools', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-schools">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-schools_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[studentSchoolPreferences_checkbox]" value="1" <?php checked($studentSchoolPreferences_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Schools', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-schools_label" name="<?php echo $this->plugin_name; ?>[studentSchoolPreferences_label]" value="<?php echo $studentSchoolPreferences_label?:$studentSchoolPreferences_label='Schools' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-schools_required" name="<?php echo $this->plugin_name; ?>[studentSchoolPreferences_required]" value="1" <?php checked($studentSchoolPreferences_required, 1); ?>/>
		<span class="edvisor-manual-text"><?php _e('Add your own dropdown', $this->plugin_name);?></span>
		<input type="checkbox" class="edvisor-manual" id="<?php echo $this->plugin_name; ?>-schools_manual" name="<?php echo $this->plugin_name; ?>[studentSchoolPreferences_manual]" value="1" <?php checked($studentSchoolPreferences_manual, 1); ?>/>
		<div id="<?php echo $this->plugin_name; ?>-schools_dropdown" class='edvisor-dropdown' type='schools'>
			<div id='<?php echo $this->plugin_name; ?>-schools_container'>
				<?php 
					if( $studentSchoolPreferences_options ){
						foreach($studentSchoolPreferences_options as $option){ 
						echo '<div class="edvisor-item"><input type="text" class="edvisor-dropdown-input" name="wp_edvisor[studentSchoolPreferences_options][]" value="' . $option . '"/><span class="edvisor-delete">x</span></div>'; } 
					} 
				?>
			</div>
			<div class='edvisor-add'>+ <?php _e('Add More', $this->plugin_name);?></div>
		</div>
	</label>
</fieldset>

<!-- Programs/Courses -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Programs/Courses', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-courses">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-courses_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[studentCoursePreferences_checkbox]" value="1" <?php checked($studentCoursePreferences_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Programs/Courses', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-courses_label" name="<?php echo $this->plugin_name; ?>[studentCoursePreferences_label]" value="<?php echo $studentCoursePreferences_label?:$studentCoursePreferences_label='Programs/Courses' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-courses_required" name="<?php echo $this->plugin_name; ?>[studentCoursePreferences_required]" value="1" <?php checked($studentCoursePreferences_required, 1); ?>/>
		<span class="edvisor-manual-text"><?php _e('Add your own dropdown', $this->plugin_name);?></span>
		<input type="checkbox" class="edvisor-manual" id="<?php echo $this->plugin_name; ?>-courses_manual" name="<?php echo $this->plugin_name; ?>[studentCoursePreferences_manual]" value="1" <?php checked($studentCoursePreferences_manual, 1); ?>/>
		<div id="<?php echo $this->plugin_name; ?>-courses_dropdown" class='edvisor-dropdown' type='courses'>
			<div id='<?php echo $this->plugin_name; ?>-courses_container'>
				<?php 
					if( $studentCoursePreferences_options ){
						foreach($studentCoursePreferences_options as $option){ 
						echo '<div class="edvisor-item"><input type="text" class="edvisor-dropdown-input" e-google name="wp_edvisor[studentCoursePreferences_options][]" value="' . $option . '"/><span class="edvisor-delete">x</span></div>'; } 
					} 
				?>
			</div>
			<div class='edvisor-add'>+ <?php _e('Add More', $this->plugin_name);?></div>
		</div>
	</label>
</fieldset>

<!-- Start Date Day -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Start Day', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-startday">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-startday_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[startDay_checkbox]" value="1" <?php checked($startDay_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Start Day', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-startday_label" name="<?php echo $this->plugin_name; ?>[startDay_label]" value="<?php echo $startDay_label?:$startDay_label='Start Day' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-startday_required" name="<?php echo $this->plugin_name; ?>[startDay_required]" value="1" <?php checked($startDay_required, 1); ?>/>
	</label>
</fieldset>

<!-- Start Date Month -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Start Month', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-startmonth">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-startmonth_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[startMonth_checkbox]" value="1" <?php checked($startMonth_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Start Month', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-startmonth_label" name="<?php echo $this->plugin_name; ?>[startMonth_label]" value="<?php echo $startMonth_label?:$startMonth_label='Start Month' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-startmonth_required" name="<?php echo $this->plugin_name; ?>[startMonth_required]" value="1" <?php checked($startMonth_required, 1); ?>/>
	</label>
</fieldset>

<!-- Start Date Year -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Start Year', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-startyear">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-startyear_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[startYear_checkbox]" value="1" <?php checked($startYear_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Start Year', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-startyear_label" name="<?php echo $this->plugin_name; ?>[startYear_label]" value="<?php echo $startYear_label?:$startYear_label='Start Year' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-startyear_required" name="<?php echo $this->plugin_name; ?>[startYear_required]" value="1" <?php checked($startYear_required, 1); ?>/>
	</label>
</fieldset>

<!-- Duration -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Duration', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-budget">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-duration_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[durationWeekAmount_checkbox]" value="1" <?php checked($durationWeekAmount_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Duration', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-duration_label" name="<?php echo $this->plugin_name; ?>[durationWeekAmount_label]" value="<?php echo $durationWeekAmount_label?:$durationWeekAmount_label='Duration' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-duration_required" name="<?php echo $this->plugin_name; ?>[durationWeekAmount_required]" value="1" <?php checked($durationWeekAmount_required, 1); ?>/>
	</label>
</fieldset>

<!-- Accommodation -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Accommodation', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-accommodation">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-accommodation_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[accommodation_checkbox]" value="1" <?php checked($accommodation_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Accommodation', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-accommodation_label" name="<?php echo $this->plugin_name; ?>[accommodation_label]" value="<?php echo $accommodation_label?:$accommodation_label='Accommodation' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-accommodation_required" name="<?php echo $this->plugin_name; ?>[accommodation_required]" value="1" <?php checked($accommodation_required, 1); ?>/>
	</label>
</fieldset>

<!-- Hours Per Week -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Hours Per Week', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-hoursperweek">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-hoursperweek_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[hoursperweek_checkbox]" value="1" <?php checked($hoursperweek_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Hours Per Week', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-hoursperweek_label" name="<?php echo $this->plugin_name; ?>[hoursperweek_label]" value="<?php echo $hoursperweek_label?:$hoursperweek_label='Hours Per Week' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-hoursperweek_required" name="<?php echo $this->plugin_name; ?>[hoursperweek_required]" value="1" <?php checked($hoursperweek_required, 1); ?>/>
	</label>
</fieldset>

<!-- AM or PM -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('AM or PM', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-amorpm">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-amorpm_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[amOrPm_checkbox]" value="1" <?php checked($amOrPm_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('AM or PM', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-amorpm_label" name="<?php echo $this->plugin_name; ?>[amOrPm_label]" value="<?php echo $amOrPm_label?:$amOrPm_label='AM or PM' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-amorpm_required" name="<?php echo $this->plugin_name; ?>[amOrPm_required]" value="1" <?php checked($amOrPm_required, 1); ?>/>
		<input type="text" class="edvisor-other-input" name="<?php echo $this->plugin_name; ?>[amOrPm_option_am]" value="<?php echo $amOrPm_option_am?:$amOrPm_option_am='AM' ?>">
		<input type="text" class="edvisor-other-input" name="<?php echo $this->plugin_name; ?>[amOrPm_option_pm]" value="<?php echo $amOrPm_option_pm?:$amOrPm_option_pm='PM' ?>">
	</label>
</fieldset>

<!-- Budget -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Budget', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-budget">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-budget_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[budget_checkbox]" value="1" <?php checked($budget_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Budget', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-budget_label" name="<?php echo $this->plugin_name; ?>[budget_label]" value="<?php echo $budget_label?:$budget_label='Budget' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-budget_required" name="<?php echo $this->plugin_name; ?>[budget_required]" value="1" <?php checked($budget_required, 1); ?>/>
	</label>
</fieldset>

<!-- Notes -->
<fieldset class="edvisor-row">
	<legend class="screen-reader-text"><span><?php _e('Notes', $this->plugin_name);?></span></legend>
	<label class="edvisor-field" for="<?php echo $this->plugin_name; ?>-notes">
		<input type="checkbox" id="<?php echo $this->plugin_name; ?>-notes_checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[notes_checkbox]" value="1" <?php checked($notes_checkbox, 1); ?>/>
		<span class="edvisor-title"><?php esc_attr_e('Notes', $this->plugin_name); ?></span>
		<input type='text' class="all-options edvisor-label" id="<?php echo $this->plugin_name; ?>-notes_label" name="<?php echo $this->plugin_name; ?>[notes_label]" value="<?php echo $notes_label?:$notes_label='Notes' ?>"/>
		<input type="checkbox" class="edvisor-required" id="<?php echo $this->plugin_name; ?>-notes_required" name="<?php echo $this->plugin_name; ?>[notes_required]" value="1" <?php checked($notes_required, 1); ?>/>
	</label>
</fieldset>

<hr>

<h4 class="edvisor-cus-headers">
	<div class="edvisor-cus-col-1"><?php _e('Custom Field', $this->plugin_name);?></div>
	<div class="edvisor-cus-col-2"><?php _e('Label Name', $this->plugin_name);?></div>
	<div class="edvisor-cus-col-3"><?php _e('ID', $this->plugin_name);?></div>
	<div class="edvisor-cus-col-4"><?php _e('Required', $this->plugin_name);?></div>
</h4>

<hr>

<!-- Custom Fields -->
<div class="edvisor-custom">
<?php if ($customPropertyValues) : ?>
<?php foreach($customPropertyValues as $item => $unit): ?>
	<fieldset class="edvisor-row">
		<div>
			<div class="edvisor-cus-col-1">
				<select class="edvisor-cus-select" name="<?php echo $this->plugin_name; ?>[customPropertyValues][<?php echo $item ?>][type]">
					<option value='Text' <?php if($unit['type'] == "Text") echo "selected"; ?>>Text</option>
					<option value='Date' <?php if($unit['type'] == "Date") echo "selected"; ?>>Date</option>
					<option value='Dropdown' <?php if($unit['type'] == "Dropdown") echo "selected"; ?>>Dropdown</option>
				</select>
			</div>
			<div class="edvisor-cus-col-2">
				<input type="text" class="all-options" name="<?php echo $this->plugin_name; ?>[customPropertyValues][<?php echo $item ?>][label]" value="<?php if(!(empty($unit['label']))) echo $unit['label'] ?>"/>
			</div>
			<div class="edvisor-cus-col-3">
				<input type="text" class="all-options" name="<?php echo $this->plugin_name; ?>[customPropertyValues][<?php echo $item ?>][id]" value="<?php if(!(empty($unit['id']))) echo $unit['id'] ?>"/>
			</div>
			<div class="edvisor-cus-col-4">
				<input type="checkbox" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[customPropertyValues][<?php echo $item ?>][required]" value="1" <?php (!(empty($unit['required']))) ? checked($unit['required'], 1) : 0; ?>/>
			</div>
			<div class="edvisor-cus-col-5">
				<span class="edvisor-delete edvisor-delete-cus">x</span>
			</div>
		</div>

		<div class="edvisor-custom-dropdown">
			<div class="edvisor-custom-item-container">
				<?php 
					if($unit['options']){
						foreach($unit['options'] as $option){ 
							echo '<div class="edvisor-item"><input type="text" name="wp_edvisor[customPropertyValues][' . $item . '][options][]" value="' . $option . '"/><span class="edvisor-delete">x</span></div>' ;
						}
					} 
				?>
			</div>
			<div class="edvisor-add" addTo="<?php echo $item ?>">+ <?php _e('Add More', $this->plugin_name);?></div>
		</div>
	</fieldset>
<?php endforeach; ?>
<?php endif; ?>

	<div class="edvisor-custom-button">+ Add Custom Field</button>

</div>

<hr>
<h4 class="edvisor-cus-headers">Settings</h4>
<fieldset>
	<div class="edvisor-cus-col-1">
		<label>Submit Text</label>
	</div>
	<div class="edvisor-cus-col-2">
		<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-submit" name="<?php echo $this->plugin_name; ?>[submit]" value="<?php echo $submit?:$submit='Submit' ?>"/>
	</div>
</fieldset>
<fieldset>
	<div class="edvisor-cus-col-1">
		<label>Required Validation Message</label>
	</div>
	<div class="edvisor-cus-col-2">
		<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-valid" name="<?php echo $this->plugin_name; ?>[valid_required]" value="<?php echo $valid_required?:$valid_required='This field is required' ?>"/>
	</div>
</fieldset>
<fieldset>
	<div class="edvisor-cus-col-1">
		<label>Email Validation Message</label>
	</div>
	<div class="edvisor-cus-col-2">
		<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-valid" name="<?php echo $this->plugin_name; ?>[valid_email]" value="<?php echo $valid_email?:$valid_email='This email is invalid' ?>"/>
	</div>
</fieldset>
<fieldset>
	<div class="edvisor-cus-col-1">
		<label>Success Action</label>
	</div>
	<div class="edvisor-cus-col-2">
		<span><label>Message</label></span>
		<input type="radio" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[success_radio]" value="message" <?php if(isset($success_radio) && $success_radio == "message") echo "checked"; ?>/>
		<span><label>URL</label></span>
		<input type="radio" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[success_radio]" value="url" <?php if(isset($success_radio) && $success_radio == "url") echo "checked"; ?>/>
	</div>
	<div class="edvisor-cus-col-3">
		<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-success_message" name="<?php echo $this->plugin_name; ?>[success_message]" value="<?php echo $success_message?:$success_message='Success! You will be contacted by one of our agents!' ?>"/>
		<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-success_url" name="<?php echo $this->plugin_name; ?>[success_url]" value="<?php echo $success_url?:$success_url='' ?>"/>
	</div>
</fieldset>
<hr>

<h4 class="edvisor-cus-headers">css</h4>
<textarea class="e-css" name="<?php echo $this->plugin_name; ?>[css]" ><?php echo $css?:$css='' ?></textarea>
<hr>
<h4 class="edvisor-cus-headers">Javascript</h4>
<div class="e-js">
	<div>General</div>
	<textarea name="<?php echo $this->plugin_name; ?>[js]" ><?php echo $js?:$js='' ?></textarea>
</div>
<div class="e-js">
	<div>Before Post</div>
	<textarea name="<?php echo $this->plugin_name; ?>[jspost]" ><?php echo $jspost?:$jspost='' ?></textarea>
</div>
<hr>



<?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>

</form>

</div>