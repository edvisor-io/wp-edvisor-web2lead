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

<form class="edvisor-container" method="post" name="cleanup_options" action="options.php">
 <?php
	$options = get_option($this->plugin_name);

	$agencyId = $options['agencyId'];
	$apiKey = $options['apiKey'];

	$customPropertyValues = $options['customPropertyValues'];

	$submit = $options['submit'];
	$valid_required = $options['valid_required'];
	$valid_email = $options['valid_email'];
	$success_message = $options['success_message'];
	$success_radio = $options['success_radio'];
	$success_url = $options['success_url'];
	$fail_message = $options['fail_message'];

	$css = $options['css'];
	$js = $options['js'];
	$jspost = $options['jspost'];

	// var_dump($options);

?>

<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<?php
		settings_fields($this->plugin_name);
		do_settings_sections($this->plugin_name);
	?>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<!-- NAVIGATION -->
				<h2 id='tabs' class="nav-tab-wrapper">
					<a data-tab="#edvisor-tab-settings" class="nav-tab nav-tab-active">Settings</a>
					<a data-tab="#edvisor-tab-form" class="nav-tab">Form</a>
					<a data-tab="#edvisor-tab-custom" class="nav-tab">Custom</a>
				</h2>

				<div class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<div class="inside">

							<!-- FORM -->
							<div id='edvisor-tab-form'>
								
								<div class='edvisor-list'>
									<div class='edvisor-list_header'>
										<div class='col-1'>Order</div>
										<div class='col-2'>Field</div>
										<div class='col-3'>Edit</div>
										<div class='col-4'>Delete</div>
									</div>

									<div class='edvisor-list_body'>
										<?php foreach($options as $item => $unit): ?>
											<?php if(is_array($unit) && array_key_exists('checkbox', $unit) && $unit['checkbox'] == 1): ?>
												<div class='edvisor-list_item' name='<?php echo $item?>'>
													<input type='hidden' name='<?php echo $this->plugin_name; ?>[<?php echo $item ?>_checkbox]' value='1'>
													<div class='col-1'><input type='text' class='edvisor-list_order' name="<?php echo $this->plugin_name; ?>[<?php echo $item ?>_order]" value="<?php echo $unit['order']?>"></div>
													<div class='col-2'><span class='edvisor-list_field'><?php echo $unit['label']?></span></div>
													<div class='col-3'><div class='edvisor-edit'></div></div>
													<div class='col-4'><div class='edvisor-close'></div></div>
												</div>
											<?php endif; ?>
										<?php endforeach; ?>
										
										<?php if ($customPropertyValues) : ?>
											<?php foreach($customPropertyValues as $item => $unit): ?>
												<div class='edvisor-list_item' name='customPropertyValues' cfId='<?php echo $item ?>'>
													<div class='col-1'><input type='text' class='edvisor-list_order' name="<?php echo $this->plugin_name; ?>[customPropertyValues][<?php echo $item ?>][order]" value="<?php echo $unit['order']?>"></div>
													<div class='col-2'><span class='edvisor-list_field'><?php echo $unit['label']?></span></div>
													<div class='col-3'><div class='edvisor-edit'></div></div>
													<div class='col-4'><div class='edvisor-close'></div></div>
												</div>
											<?php endforeach; ?>
										<?php endif; ?>
									</div>

								</div>

								<button type='button' id='edvisor-add' class='edvisor-form-button'>+ Add Field</button>
							</div>


							<!-- SETTINGS -->
							<div id='edvisor-tab-settings'>

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
										<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-success_message" name="<?php echo $this->plugin_name; ?>[success_message]" value="<?php echo $success_message?:$success_message='Success! You will be contacted by one of our agents!' ?>"/>
										
									</div>
									<div class="edvisor-cus-col-3">
										<span><label>URL</label></span>
										<input type="radio" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[success_radio]" value="url" <?php if(isset($success_radio) && $success_radio == "url") echo "checked"; ?>/>
										<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-success_url" name="<?php echo $this->plugin_name; ?>[success_url]" value="<?php echo $success_url?:$success_url='' ?>"/>
									</div>
								</fieldset>
								<fieldset>
									<div class="edvisor-cus-col-1">
										<label>Fail Action</label>
									</div>
									<div class="edvisor-cus-col-2">
										<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-fail_message" name="<?php echo $this->plugin_name; ?>[fail_message]" value="<?php echo $fail_message?:$fail_message='There was an error, please email us instead!' ?>"/>
									</div>
								</fieldset>
							</div>


							<!-- CUSTOM -->
							<div id='edvisor-tab-custom'>

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

							</div>


							<?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>
						</div>
					</div>
				</div>
			</div>



			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox">
						<div class="inside">
							<h2>Important</h2>
							<p>Make sure add your <b>Agency ID</b> and <b>API Key</b> in the settings section.</p>
							<p>Use the shortcode to add the form to your page: <b>[edvisor_form]</b></p>
							<h2>Docs</h2>
							<p>You can find our API at docs.edvisor.io</p>
							<h2>Help</h2>
							<p>If you have any questions for concerns, feel free to contact us at contact@edvisor.io</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br class="clear">
	</div>
</div>

<div class="edvisor-modal-bg"></div>

<!-- Add MODAL -->
<div id='edvisor-add-modal' class='edvisor-modal'>
	<div class='edvisor-modal_header'>
		<h3>Add Field</h3>
		<div class="edvisor-close"></div>
	</div>
	<div class='edvisor-modal_body'>
		<?php foreach($options as $item => $unit): ?>
			<?php if(is_array($unit) && array_key_exists('checkbox', $unit) && $unit['checkbox'] == 0): ?>
				<button type='button' name=<?php echo $item?>><?php echo $unit['name']?></button>
			<?php endif; ?>
		<?php endforeach; ?>
		<button type='button' name="customPropertyValues">Custom Field</button>
	</div>
</div>


<!-- EDIT MODAL -->
<div id='edvisor-edit-modal' class='edvisor-modal'>
	<div class='edvisor-modal_header'>
		<h3>Edit</h3>
		<div class="edvisor-close"></div>
	</div>
	<div class='edvisor-modal_body'>

	</div>
</div>



<hr>



</form>

</div>