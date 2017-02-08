<?php
require_once __DIR__ . '/alps-view-helper.inc.php';
?>
<div class="media-block__inner spacing--quarter block__row--small-to-large">
	<?php if ($image): ?>
		<?php AlpsViewHelper::renderImage($image, $row, array('class' => 'media-block__image block__image')); ?>
	<?php endif ?>
	<div class="media-block__content block__content">
		<?php if ($fields['title']): ?>
			<h3 class="media-block__title block__title font--secondary--m theme--primary-text-color"><?php print $fields['title']->content; ?></h3>
		<?php endif ?>
		<?php if ($fields['created']): ?>
			<time class="block__date font--secondary--xs brown space-half--btm"><?php print $fields['created']->content; ?></time>
		<?php endif ?>
		<div class="spacing--half">
			<?php AlpsViewHelper::renderFields(alps_without($fields, 'title', 'created', $image_field)); ?>
			<?php if (!isset($fields['view_node'])): ?>
				<p>
					<a class="media-block__cta block__cta btn theme--secondary-background-color" href="<?php print url('node/'.$row->nid); ?>">Read More</a>
				</p>
			<?php endif ?>
		</div>
	</div>
</div>