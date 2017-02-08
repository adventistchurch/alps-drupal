<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */

$classes = array(
	$options['columns'] == 2 ? 'g g-2up--at-medium' : 'g g-3up--at-medium'
);
$with_divider = FALSE;
if (strpos($row_classes[0], 'alps-without-divider') === false && strpos($column_classes[0][0], 'alps-without-divider') === false) {
	$with_divider = TRUE;
	$classes[] = 'with-divider';
}
?>
<?php if (!empty($title)): ?>
	<div class="spacing--half">
		<h2 class="font--tertiary--l theme--primary-text-color pad pad-double--top pad-half--btm"><?php print $title; ?></h2>
	</div>
<?php endif; ?>
<?php if ($with_divider): ?><hr><?php endif ?>
<div <?php print drupal_attributes(array('class' => $classes)); ?>>
<?php foreach ($rows as $row_number => $columns): ?>
	<?php foreach ($columns as $column_number => $item): ?>
		<div class="gi">
			<div class="spacing">
				<div class="pad">
					<div class="media-block block spacing--quarter">
						<?php print $item; ?>
					</div>
				</div>
				<?php if ($with_divider): ?><hr><?php endif ?>
			</div>
		</div>
	<?php endforeach; ?>
<?php endforeach; ?>
</div>
