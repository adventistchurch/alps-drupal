<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?> media-block block spacing--quarter bg--tan can-be--dark-dark block--breakout pad--secondary--for-breakouts"<?php print $attributes; ?>>

	<?php print render($title_prefix); ?>
	<?php if ($block->subject): ?>
	<h2 class="font--tertiary--m theme--primary-text-color pad--btm"<?php print $title_attributes; ?>><div class="icon icon--s"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 77.22 99.29"><title>List Icon</title><path d="M34.68,54.8H65.57V44.87H34.68V54.8ZM77.58,0.36H22.42a11.06,11.06,0,0,0-11,11V88.61a11.06,11.06,0,0,0,11,11H77.58a11.06,11.06,0,0,0,11-11V11.39A11.06,11.06,0,0,0,77.58.36Zm0,88.26H22.42V11.39H77.58V88.61ZM65.44,23.35H34.56V33H65.44V23.35Zm0,43.3H34.56v9.65H65.44V66.66Z" transform="translate(-11.39 -0.36)" fill="#010101" class="theme--primary-fill-color"></path></svg></div> <?php print $block->subject ?></h2>
	<?php endif;?>
	<?php print render($title_suffix); ?>

	<div class="media-block__inner spacing--quarter ">
		<div class="media-block__content block__content ">
			<div class="spacing--half">
				<?php print $content ?>
			</div>
		</div>
	</div>
</div>