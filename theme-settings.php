<?php
/**
 * @file
 * theme-settings.php
 *
 * Provides theme settings for Bootstrap based themes when admin theme is not.
 *
 * @see ./includes/settings.inc
 */

/**
 * Implements hook_form_FORM_ID_alter().
 */
function alps_form_system_theme_settings_alter(&$form, $form_state, $form_id = NULL) {
	// Do not add alps specific settings to non-bootstrap based themes,
	// including a work-around for a core bug affecting admin themes.
	// @see https://drupal.org/node/943212
	$theme = !empty($form_state['build_info']['args'][0]) ? $form_state['build_info']['args'][0] : FALSE;
	if (isset($form_id) || $theme === FALSE) {
		return;
	}

	// TODO: it's saying the function doesn't exist once submitted
	// $form['#validate'][] = 'validate_alps_settings';

	$form['alps_logo_horiz'] = array(
		'#type'            => 'managed_file',
		'#title'           => t('Horizontal Logo'),
		'#default_value'   => theme_get_setting('alps_logo_horiz'),
		'#description'     => t("The horizontal logo is used in mobile mode."),
		'#upload_location' => 'public://logo/',
		'#upload_validators' => array(
			'file_validate_extensions' => array('ico png gif jpg jpeg apng svg'),
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

/* 
 * Form override for theme settings.
 */
function validate_alps_settings(&$form, &$form_state) {
	if (function_exists('file_save_upload')) {
		// Handle file uploads.
		$validators = array('file_validate_extensions' => array('ico png gif jpg jpeg apng svg'));

		// Check for a new uploaded logo.
		$file = file_save_upload('logo_upload', $validators);
		if (isset($file)) {
			// File upload was attempted.
			if ($file) {
				// Put the temporary file in form_values so we can save it on submit.
				$form_state['values']['logo_upload'] = $file;
			} else {
				// File upload failed.
				form_set_error('logo_upload', t('The logo could not be uploaded.'));
			}
		}
	}
}
