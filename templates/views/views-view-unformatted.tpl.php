<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
	<div class="spacing--half">
		<h2 class="font--tertiary--l theme--primary-text-color pad pad-double--top pad-half--btm"><?php print $title; ?></h2>
	</div>
<?php endif; ?>
<div class="spacing--double">
<?php foreach ($rows as $id => $row): ?>
	<div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
		<?php print $row; ?>
	</div>
<?php endforeach; ?>
</div>
