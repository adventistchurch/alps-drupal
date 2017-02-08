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
<section class="hero-carousel">
	<div class="carousel rel">
		<div class="carousel__slides js-carousel__single-item">
		<?php foreach ($rows as $key => $row): ?>
			<div class="carousel__item rel">
				<?php print $row; ?>
			</div>
		<?php endforeach ?>
		</div> <!-- /.carousel__slides -->
	</div> <!-- /.carousel -->
</section> <!-- /.hero-carousel -->