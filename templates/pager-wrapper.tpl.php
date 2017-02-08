<div class="pad spacing">
	<nav class="pagination center-block align--center" role="navigation" aria-labelledby="pagination-heading">
		<ul class="pager__items js-pager__items">
			<?php $items = $content['pager']['#items']; ?>
			<?php if (isset($items['previous'])): ?>
				<a href="<?php print $items['previous']['href']; ?>" class="pagination__page pagination__next theme--secondary-background-color white" title="<?php print t('Go to previous page'); ?>" rel="previous">
					Previous
				</a>
			<?php endif ?>
			<?php if (isset($items['ellipsis.previous'])): ?>
				<span class="pagination__divide">&hellip;</span>
			<?php endif ?>
			<?php foreach ($items['current'] as $key => $item): ?>
				<?php if ($item['class'] === 'pager-current'): ?>
					<span class="pagination__page pagination__page--current white bg--gray">
						<?php print $item['data']; ?>
					</span>
				<?php else: ?>
					<a href="<?php print $item['href']; ?>" class="pagination__page theme--secondary-background-color white">
						<?php print $item['data']; ?>
					</a>
				<?php endif ?>
			<?php endforeach ?>
			<?php if (isset($items['mini.current'])): ?>
				<div class="pagination__pages show-at--medium dib">
					<span class="pagination__page pagination__page--current white bg--gray"><?php print $items['mini.current']['data']; ?></span>
				</div>
			<?php endif ?>
			<?php if (isset($items['ellipsis.next'])): ?>
				<span class="pagination__divide">&hellip;</span>
			<?php endif ?>
			<?php if (isset($items['next'])): ?>
				<a href="<?php print $items['next']['href']; ?>" class="pagination__page pagination__next theme--secondary-background-color white" title="<?php print t('Go to next page'); ?>" rel="next">
					Next
				</a>
			<?php endif ?>
		</ul>
	</nav>
</div>