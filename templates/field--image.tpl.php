<?php //_debug($items); ?>
<?php foreach ($items as $delta => $item): ?>
<figure class="figure size--large">
	<div class="img-wrap">
	<?php
	if ($item['#image_style']) {
		$url = image_style_url($item['#image_style'], $item['#item']['uri']);
	} else {
		$url = file_create_url($item['#item']['uri']);
	}
	?>
	<img src="<?php print $url; ?>" alt="<?php print $item['#item']['alt']; ?>">
	</div>
	<?php if ($item['#item']['title']): ?>
	<figcaption class="figcaption"><p class="font--secondary--xs"><?php print $item['#item']['title']; ?></p></figcaption>
	<?php endif ?>
</figure>
<?php endforeach ?>
