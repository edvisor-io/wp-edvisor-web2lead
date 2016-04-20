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

	$options = get_option($this->plugin_name);
	if($options == false) {
    $options = array(wp_edvisor_template($this->wp_edvisor_options, $input, 0), 'using' => 0, 'formNum' => 0);
	} else {
		$formNum = $options['formNum'];
		$using = $options['using'];
	};
	// var_dump($options);
	
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

<h2><?php echo esc_html(get_admin_page_title()); ?></h2>

<form id='edvisor-form'class="edvisor-container" method="post" name="cleanup_options" action="options.php">
<button type='button' class="button button-small edvisor-add-new">Add New Form</button>

<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<?php
		settings_fields($this->plugin_name);
		do_settings_sections($this->plugin_name);
	?>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
		<div id="post-body-content">
		<div class="edvisor-modal-bg"></div>
		
		<input type='hidden' id='edvisor-form-num' name='<?php echo $this->plugin_name; ?>[formNum]' value='<?php echo $formNum ?>'>
		<input type='hidden' id='edvisor-form-using' name='<?php echo $this->plugin_name; ?>[using]' value='<?php echo $using ?>'>

		<?php foreach($options as $num => $itemArr): ?>
			<?php if(is_numeric($num)): ?>

				<div class="edvisor-item" data-num='<?php echo $num; ?>'>
					<div class="edvisor-block">
						<span>Name: <?php echo $options[$num]['formName']?></span>
						<span>Shortcode: [edvisor_form name="<?php echo $options[$num]['formName']?>"]</span>
						<span class='edvisor-close'>Delete</span>
						<span class='edvisor-edit'>Edit</span>

					</div>

					<div class="edvisor-form-item">
					<!-- NAVIGATION -->
						<a class="edvisor-close edvisor-close-form">Close</a>
						<h2 id='tabs' class="nav-tab-wrapper">
							<a data-tab=".edvisor-tab-settings" class="nav-tab nav-tab-active">Settings</a>
							<a data-tab=".edvisor-tab-form" class="nav-tab">Form</a>
							<a data-tab=".edvisor-tab-custom" class="nav-tab">Custom</a>
						</h2>


						<div class="meta-box-sortables ui-sortable">
							<div class="postbox">
								<div class="inside">

									<!-- FORM -->
									<div class='edvisor-tab-form'>
										
										<div class='edvisor-list'>
											<div class='edvisor-list_header'>
												<div class='col-1'>Required</div>
												<div class='col-1'>Order</div>
												<div class='col-2'>Field</div>
												<div class='col-3'>Edit</div>
												<div class='col-4'>Delete</div>
											</div>

											<div class='edvisor-list_body'>
												<?php foreach($options[$num] as $item => $unit): ?>
													<?php if(is_array($unit) && array_key_exists('checkbox', $unit) && $unit['checkbox'] == 1): ?>
														<div class='edvisor-list_item' name='<?php echo $item?>'>
															<input type='hidden' name='<?php echo $this->plugin_name; ?>[<?php echo $num ?>][<?php echo $item ?>_checkbox]' value='1'>
															<div class='col-1'><input type='checkbox' name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][<?php echo $item ?>_required]" <?php if(isset($unit['required']) && $unit['required']) echo 'checked' ?> ></div>
															<div class='col-1'><input type='text' class='edvisor-list_order' name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][<?php echo $item ?>_order]" value="<?php echo $unit['order']?>"></div>
															<div class='col-2'><span class='edvisor-list_field'><?php echo $unit['label']?></span></div>
															<div class='col-3'><div class='edvisor-edit'></div></div>
															<div class='col-4'><div class='edvisor-close'></div></div>
														</div>
													<?php endif; ?>
												<?php endforeach; ?>
												
												<?php if ($options[$num]['customPropertyValues']) : ?>
													<?php foreach($options[$num]['customPropertyValues'] as $item => $unit): ?>
														<div class='edvisor-list_item' name='customPropertyValues' cfId='<?php echo $item ?>'>
															<div class='col-1'><input type='checkbox' name="<?php echo $this->plugin_name; ?>[<?php echo $num; ?>][customPropertyValues][<?php echo $item ?>][required]" <?php if(isset($unit['required']) && $unit['required']) echo 'checked' ?> ></div>
															<div class='col-1'><input type='text' class='edvisor-list_order' name="<?php echo $this->plugin_name; ?>[<?php echo $num; ?>][customPropertyValues][<?php echo $item ?>][order]" value="<?php echo $unit['order']?>"></div>
															<div class='col-2'><span class='edvisor-list_field'><?php echo $unit['label']?></span></div>
															<div class='col-3'><div class='edvisor-edit'></div></div>
															<div class='col-4'><div class='edvisor-close'></div></div>
														</div>
													<?php endforeach; ?>
												<?php endif; ?>
											</div>

										</div>

										<button type='button' class='edvisor-add edvisor-form-button'>+ Add Field</button>
									</div>


									<!-- SETTINGS -->
									<div class='edvisor-tab-settings'>
										<fieldset class="edvisor-row">
											<label class="edvisor-field edvisor-non-form-label">Form Name</label>
											<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-formName" name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][formName]" value="<?php if(!(empty($options[$num]['formName']))) echo $options[$num]['formName'] ?>"/>
										</fieldset>

										<!-- Agency ID -->
										<fieldset class="edvisor-row">
											<legend class="screen-reader-text"><span><?php _e('Agency ID', $this->plugin_name);?></span></legend>
											<label class="edvisor-field edvisor-non-form-label" for="<?php echo $this->plugin_name; ?>-id"><?php esc_attr_e('Agency ID', $this->plugin_name); ?></label>
											<input type='text' class="small-text" id="<?php echo $this->plugin_name; ?>-agencyid" name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][agencyId]" value="<?php if(!(empty($options[$num]['agencyId']))) echo $options[$num]['agencyId'] ?>"/>
											<p class="edvisor-info">You can find your Agency ID in your office settings. This field puts all your form information into an Edvisor office. </p>
										</fieldset>

										<!-- API Key -->
										<fieldset class="edvisor-row">
											<legend class="screen-reader-text"><span><?php _e('API Key', $this->plugin_name);?></span></legend>
											<label class="edvisor-field edvisor-non-form-label" for="<?php echo $this->plugin_name; ?>-id"><?php esc_attr_e('API Key', $this->plugin_name); ?></label>
											<input type='text' class="regular-text" id="<?php echo $this->plugin_name; ?>-apikey" name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][apiKey]" value="<?php if(!(empty($options[$num]['apiKey']))) echo $options[$num]['apiKey'] ?>"/>
											<p class="edvisor-info">Please contact us if you don't know your API Key. An API Key gives you access to Edvisor.io's API. Without it, you won't be able to submit your forms to Edvisor.</p>
										</fieldset>

										<fieldset>
											<div class="edvisor-cus-col-1">
												<label>Submit Text</label>
											</div>
											<div class="edvisor-cus-col-2">
												<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-submit" name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][submit]" value="<?php echo $options[$num]['submit']?:$options[$num]['submit']='Submit' ?>"/>
											</div>
										</fieldset>
										<fieldset>
											<div class="edvisor-cus-col-1">
												<label>Required Validation Message</label>
											</div>
											<div class="edvisor-cus-col-2">
												<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-valid" name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][valid_required]" value="<?php echo $options[$num]['valid_required']?:$options[$num]['valid_required']='This field is required' ?>"/>
											</div>
										</fieldset>
										<fieldset>
											<div class="edvisor-cus-col-1">
												<label>Email Validation Message</label>
											</div>
											<div class="edvisor-cus-col-2">
												<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-valid" name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][valid_email]" value="<?php echo $options[$num]['valid_email']?:$options[$num]['valid_email']='This email is invalid' ?>"/>
											</div>
										</fieldset>
										<fieldset>
											<div class="edvisor-cus-col-1">
												<label>Success Action</label>
											</div>
											<div class="edvisor-cus-col-2">
												<span><label>Message</label></span>
												<input type="radio" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][success_radio]" value="message" <?php if(isset($options[$num]['success_radio']) && $options[$num]['success_radio'] == "message") echo "checked"; ?>/>
												<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-success_message" name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][success_message]" value="<?php echo $options[$num]['success_message']?:$options[$num]['success_message']='Success! You will be contacted by one of our agents!' ?>"/>
												
											</div>
											<div class="edvisor-cus-col-3">
												<span><label>URL</label></span>
												<input type="radio" class="edvisor-checked" name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][success_radio]" value="url" <?php if(isset($options[$num]['success_radio']) && $options[$num]['success_radio'] == "url") echo "checked"; ?>/>
												<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-success_url" name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][success_url]" value="<?php echo $options[$num]['success_url']?:$options[$num]['success_url']='' ?>"/>
											</div>
										</fieldset>
										<fieldset>
											<div class="edvisor-cus-col-1">
												<label>Fail Action</label>
											</div>
											<div class="edvisor-cus-col-2">
												<input type='text' class="all-options" id="<?php echo $this->plugin_name; ?>-fail_message" name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][fail_message]" value="<?php echo $options[$num]['fail_message']?:$options[$num]['fail_message']='There was an error, please email us instead!' ?>"/>
											</div>
										</fieldset>
									</div>


									<!-- CUSTOM -->
									<div class='edvisor-tab-custom'>

										<h4 class="edvisor-cus-headers">css</h4>
										<button type='button' class='button-small'>I know what I'm doing</button>
										<textarea class="e-css" name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][css]" ><?php echo $options[$num]['css']?:$options[$num]['css']='' ?></textarea>
										<hr>
										<h4 class="edvisor-cus-headers">Javascript</h4>
										<div class="e-js">
											<div>General</div>
											<button type='button' class='button-small'>I know what I'm doing</button>
											<textarea name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][js]" ><?php echo $options[$num]['js']?:$options[$num]['js']='' ?></textarea>
										</div>
										<div class="e-js">
											<div>Before Post</div>
											<button type='button' class='button-small'>I know what I'm doing</button>
											<textarea name="<?php echo $this->plugin_name; ?>[<?php echo $num ?>][jspost]" ><?php echo $options[$num]['jspost']?:$options[$num]['jspost']='' ?></textarea>
										</div>

									</div>

								</div>
							</div>
						</div>

					</div>

					<!-- Add MODAL -->
				<div class='edvisor-modal edvisor-add-modal'>
					<div class='edvisor-modal_header'>
						<h3>Add Field</h3>
						<div class="edvisor-close"></div>
					</div>
					<div class='edvisor-modal_body'>
						<?php foreach($options[$num] as $item => $unit): ?>
							<?php if(is_array($unit) && array_key_exists('checkbox', $unit) && $unit['checkbox'] == 0): ?>
								<button type='button' name=<?php echo $item?>><?php echo $unit['name']?></button>
							<?php endif; ?>
						<?php endforeach; ?>
						<button type='button' name="customPropertyValues">Custom Field</button>
					</div>
				</div>


				<!-- EDIT MODAL -->
				<div class='edvisor-edit-modal edvisor-modal'>
					<div class='edvisor-modal_header'>
						<h3>Edit</h3>
						<div class="edvisor-close"></div>
					</div>
					<div class='edvisor-modal_body'>

					</div>
				</div>

				</div>
				<?php endif; ?>
				<?php endforeach; ?>
				
				<?php submit_button(__('Save all changes', $this->plugin_name), 'primary','submit', TRUE); ?>
			</div>


			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox">
						<div class="inside">
							<h2>Important</h2>
							<p>Make sure add your Agency ID and API Key in the settings section.</p>
							<p>Use the shortcode to add the form to your page: [edvisor_form name="Your-Form-Name"]</p>
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




<hr>



</form>

</div>