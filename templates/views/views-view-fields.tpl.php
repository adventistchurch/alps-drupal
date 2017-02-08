<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 * - $style_id: The style, unformatted list, grid, etc.
 *
 * @ingroup views_templates
 */
?>
<?php

$image = NULL;
$image_field = '';
if (isset($fields['field_image']->raw) && $fields['field_image']->handler->options['type'] === 'image') {
	$image = $fields['field_image'];
	$image_field = 'field_image';
} else if (isset($fields['field_header_image']->raw) && $fields['field_header_image']->handler->options['type'] === 'image') {
	$image = $fields['field_header_image'];
	$image_field = 'field_header_image';
}
switch ($style_id) {
	case 'grid':
		require __DIR__.'/alps-views-view-fields-grid.inc.php';
		break;
	
	default:
		require __DIR__.'/alps-views-view-fields-default.inc.php';
		break;
}