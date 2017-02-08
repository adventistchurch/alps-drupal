<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?> column__secondary can-be--dark-dark"<?php print $attributes; ?>>
	<aside class="aside spacing--double">
		<div class="pad--secondary spacing--double">
			<?php print render($title_prefix); ?>
			<?php if ($block->subject): ?>
			<h3 class="font--tertiary--m theme--secondary-text-color"<?php print $title_attributes; ?>><?php print $block->subject ?></h3>
			<?php endif;?>
			<?php print render($title_suffix); ?>

			<div class="media-block block spacing--quarter ">
				<?php print $content ?>
			</div>
		</div>
	</aside>
</div>