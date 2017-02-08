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
require_once __DIR__ . '/alps-view-helper.inc.php';
$image = NULL;
if (isset($fields['field_image']) && (AlpsViewHelper::getRowField($row, 'field_image'))) {
	$image = AlpsViewHelper::getRowField($row, 'field_image');
} else if (isset($fields['field_header_image']) && (AlpsViewHelper::getRowField($row, 'field_header_image'))) {
	$image = AlpsViewHelper::getRowField($row, 'field_header_image');
}
?>
<?php if ($image): ?>
	<img src="<?php print file_create_url($image[0]['raw']['uri']); ?>" class="lazy">
<?php else: ?>
	<img src="" alt="Missing Image">
<?php endif ?>
<?php
$teaser = NULL;
if (isset($fields['field_teaser'])) {
	$teaser = $fields['field_teaser'];
} else if (isset($fields['field_description'])) {
	$teaser = $fields['field_description'];
}
$sub_title = AlpsViewHelper::getRowField($row, 'field_sub_title');
?>
<div class="carousel__item-text__wrap">
	<div class="layout-container">
		<div class="carousel__item-text  spacing--half">
			<div>
				<h2 class="font--tertiary--xl carousel__item-heading theme--primary-transparent-background-color">
					<?php print $fields['title']->raw; ?>
				</h2>
				<br>
				<?php if ($sub_title): ?>
				<h3 class="carousel__item-subtitle font--secondary--m theme--primary-transparent-background-color">
					<?php print $sub_title[0]['raw']['value']; ?>
				</h3>
				<?php endif ?>
				<?php if ($teaser): ?>
				<div class="carousel__item-dek pad-half--btm theme--primary-transparent-background-color">
					<?php print $teaser->content; ?>
				</div> <!-- /.carousel__item-dek -->
				<?php endif ?>
			</div>
			<?php if (isset($fields['view_node'])): ?>
				<a class="btn theme--secondary-background-color" href="<?php print url('node/'.$row->nid); ?>"><?php $options = AlpsViewHelper::getOptions($fields['view_node']); print $options['text']; ?></a>
			<?php else: ?>
				<a class="btn theme--secondary-background-color" href="<?php print url('node/'.$row->nid); ?>">Find out more</a>
			<?php endif ?>
		</div>
	</div>
</div>