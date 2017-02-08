<?php
require_once __DIR__ . '/alps-view-helper.inc.php';
$image = NULL;
if (isset($fields['field_image']) && (AlpsViewHelper::getRowField($row, 'field_image'))) {
	$image = $fields['field_image'];
} else if (isset($fields['field_header_image']) && (AlpsViewHelper::getRowField($row, 'field_header_image'))) {
	$image = $fields['field_header_image'];
}
$sub_title = AlpsViewHelper::getRowField($row, 'field_sub_title');
?>
<div class="story-block block spacing--half pad " style="background-image: url(//unsplash.it/g/1100/1100?blur);">
	<div class="story-block__image-wrap round">
		<?php if ($image): ?>
			<?php print $image->content; ?>
		<?php endif ?>
	</div>
	<div class="story-block__content spacing">
		<div>
			<h2 class="story-block__heading font--secondary--l theme--secondary-text-color"><?php print $fields['title']->raw; ?></h2>
			<p class="font--secondary--xs white"><?php if ($sub_title): ?><?php print $sub_title[0]['raw']['value']; ?><?php endif ?></p>
		</div>
		<div class="spacing">
			<div class="text story-block__description block__description white">
				<?php print $fields['body']->content; ?>
			</div>
			<?php if (isset($fields['view_node'])): ?>
				<a class="story-block__cta block__cta btn theme--secondary-background-color" href="<?php print url('node/'.$row->nid); ?>"><?php $options = AlpsViewHelper::getOptions($fields['view_node']); print $options['text']; ?></a>
			<?php else: ?>
				<a class="story-block__cta block__cta btn theme--secondary-background-color" href="<?php print url('node/'.$row->nid); ?>">Find out more</a>
			<?php endif ?>
		</div> <!-- /.spacing -->
	</div> <!-- story-block__content -->
</div>