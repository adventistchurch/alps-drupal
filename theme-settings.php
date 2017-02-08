<?php

/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * Form override for theme settings.
 */

function alps_form_system_theme_settings_validate(array &$form, \Drupal\Core\Form\FormStateInterface $form_state) {
	if (function_exists('file_save_upload')) {
		// Handle file uploads.
		$image_factory = \Drupal::service('image.factory');
		$supported_extensions = $image_factory->getSupportedExtensions();
		$supported_extensions[] = 'svg';
		$validators = ['file_validate_extensions' => [implode(' ', $supported_extensions)]];

		// Check for a new uploaded logo.
		$file = file_save_upload('logo_upload', $validators, FALSE, 0);
		if (isset($file)) {
			// File upload was attempted.
			if ($file) {
				// Put the temporary file in form_values so we can save it on submit.
				$form_state->setValue('logo_upload', $file);
			} else {
				// File upload failed.
				$form_state->setErrorByName('logo_upload', t('The logo could not be uploaded.'));
			}
		}
	}
}

function alps_form_system_theme_settings_alter(&$form, \Drupal\Core\Form\FormStateInterface &$form_state, $form_id = NULL) {
	// Work-around for a core bug affecting admin themes. See issue #943212.
	if (isset($form_id)) {
		return;
	}
	$form['#validate'][] = 'alps_form_system_theme_settings_validate';

	$image_factory = \Drupal::service('image.factory');
	$supported_extensions = $image_factory->getSupportedExtensions();
	$supported_extensions[] = 'svg';
	$form['alps_logo_horiz'] = array(
		'#type'            => 'managed_file',
		'#title'           => t('Horizontal Logo'),
		'#default_value'   => theme_get_setting('alps_logo_horiz'),
		'#description'     => t("The horizontal logo is used in mobile mode."),
		'#upload_location' => 'public://logo/',
		'#upload_validators' => array(
			'file_validate_extensions' => array(implode(' ', $supported_extensions)),
			// 'file_validate_size' => array()
		),
	);

	$form['alps_logo_text'] = array(
		'#type'          => 'textfield',
		'#title'         => t('Sub Logo Brand'),
		'#default_value' => theme_get_setting('alps_logo_text'),
		'#maxlength'	 => 20,
		'#description'   => t("Use this setting to configure the text that appears below the site logo."),
	);

	$form['alps_primary_color'] = array(
		'#type'          => 'select',
		'#title'         => t('Primary Color'),
		'#options'		 => array(
			'emperor' => t('Emperor (Purple)'),
			'earth' => t('Earth (Brown)'),
			'grapevine' => t('Grapevine (Red/Purple)'),
			'denim' => t('Denim (Blue)'),
			'campfire' => t('Campfire (Orange)'),
			'treefrog' => t('Treefrog (Green)'),
			'ming' => t('Ming (Light Blue)'),
		),
		'#default_value' => theme_get_setting('alps_primary_color'),
		'#description'   => t("Primary color to use for this theme."),
	);

	$form['alps_secondary_color'] = array(
		'#type'          => 'select',
		'#title'         => t('Secondary Color'),
		'#options'		 => array(
			'cool' => t('Cool'),
			'warm' => t('Warm'),
		),
		'#default_value' => theme_get_setting('alps_secondary_color'),
		'#description'   => t("This selection will provide an accent color for buttons, components, etc."),
	);

	$form['alps_use_dark_theme'] = array(
		'#type'          => 'checkbox',
		'#title'         => t('Use dark theme'),
		'#default_value' => theme_get_setting('alps_use_dark_theme'),
		'#description'   => t("Some primary colors allow for the use of a darker themed version. Check this box if you would like to use the darker version."),
	);

	$form['alps_copyright'] = array(
		'#type'          => 'textfield',
		'#title'         => t('Copyright'),
		'#default_value' => theme_get_setting('alps_copyright'),
		'#description'   => t("Copyright text that appears in the footer next to the Copyright symbol and year."),
	);

	$form['alps_footer_address'] = array(
		'#type'          => 'textfield',
		'#title'         => t('Address'),
		'#default_value' => theme_get_setting('alps_footer_address'),
		'#description'   => t("This field will appear in the footer directly next to the copyright."),
	);
	
}