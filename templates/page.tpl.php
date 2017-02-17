<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_breakout']: Items for the first sidebar.
 * - $page['sidebar']: Items for the second sidebar.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
require_once path_to_theme().'/templates/inc/menu.inc.php';
?>
<div class="content cf" role="document">
	<header class="header can-be--dark-dark" role="banner" id="header">
		<div class="header__inner">
			<span class="nav-toggle js-toggle" data-toggled="header" data-prefix="nav">
				<div class="nav-toggle__inner">
					<span class="nav-toggle__segment nav-toggle__segment--1 theme--primary-background-color"></span><span class="nav-toggle__segment nav-toggle__segment--2 theme--primary-background-color"></span><span class="nav-toggle__segment nav-toggle__segment--3 theme--primary-background-color"></span><span class="nav-toggle__segment nav-toggle__segment--4 theme--primary-background-color"></span>
				</div> <!-- /.nav-toggle__inner -->
				<strong class="nav-toggle__text upper theme--primary-text-color font--secondary--s">Menu</strong>
			</span> <!-- /.nav-toggle -->
			<div class="header__unify-logo-nav">
				<a href="<?php print $front_page; ?>" class="logo__link logo__link--horiz theme--primary-background-color show-until--large logo--with-text">
					<img src="<?php print $alps_logo_horiz['url']; ?>" class="logo" alt=The Official Site of the Seventh-day Adventist world church logo">
					<?php if ($alps_logo_text): ?><span class="logo__text"><span><?php print $alps_logo_text; ?></span></span><?php endif ?>
				</a>
				<a href="<?php print $front_page; ?>" class="logo__link logo__link--square theme--primary-background-color show-at--large logo--with-text">
					<img src="<?php print $alps_logo_square['url']; ?>" class="logo" alt="The Official Site of the Seventh-day Adventist world church logo">
					<?php if ($alps_logo_text): ?><span class="logo__text"><span><?php print $alps_logo_text; ?></span></span><?php endif ?>
				</a>
				<nav id="primary-nav" role="navigation" aria-labelledby="primary-nav" class="navigation primary-nav toggled-element">
					<?php AlpsMenuHelper::create(menu_tree_page_data('main-menu'), 'primary-nav', 'theme--primary-text-color')->render(); ?>
				</nav>
			</div> <!-- /.header__unify-logo-nav -->
			<div class="header__utility">
				<div class="header__utility__inner full--until-large">
					<nav id="secondary-nav" role="navigation" aria-labelledby="secondary-nav" class="navigation">
						<?php AlpsMenuHelper::create(menu_tree_page_data('user-menu'))->render(1); ?>
					</nav>
					<form action="/search/node" role="search" method="get" class="search-form toggled-element">
						<fieldset>
							<legend class="is-vishidden">Search</legend>
							<input type="search" name="s" placeholder="Search…" class="search-form__input font--secondary--s" required="">
							<button class="search-form__submit is-vishidden">
								<span class="is-vishidden">Submit</span>
							</button> <!-- /.search-form__submit -->
						</fieldset>
					</form>
				</div>
			</div>
		</div> <!-- /.header__inner -->
	</header> <!-- .header -->
	<div id="page-wrapper">
		<div id="page">
			<main class="main can-be--dark-dark" role="main">
				<?php // content for image ?>
				<?php print render($page['hero']); ?>
				<?php if (!$is_front): ?>
					<?php 
					$has_header_image = isset($node) && isset($node->field_header_image);
					if ($has_header_image) {
						$header_image_field = $node->field_header_image[LANGUAGE_NONE][0];
						$header_image_url = image_style_url('large', $header_image_field['uri']);
					}
					?>
					<header class="header__swath theme--primary-background-color header-swath--with-image blend-mode--multiply" <?php if ($has_header_image): ?> style="background-image: url(<?php print $header_image_url; ?>);"<?php endif ?>>
						<div class="layout-container cf">
							<div class="flex-container cf">
								<div class="shift-left--fluid">
									<?php if (isset($node) && $node->field_sub_title[LANGUAGE_NONE][0]['value']): ?>
										<span class="kicker white"><?php print $node->field_sub_title[LANGUAGE_NONE][0]['value']; ?></span>
									<?php endif ?>
									<h1 class="font--tertiary--xl white"><?php print $title; ?></h1>
								</div>
								<div class="shift-right--fluid"></div> <!-- /.shift-right--fluid -->
							</div>
						</div>
					</header> <!-- /.header__swath -->
				<?php endif ?>
				<?php $has_sidebar_content = $page['sidebar_breakout'] || $page['sidebar']; ?>
				<?php // $has_sidebar_content = false; ?>
				<div class="layout-container full--until-large">
					<?php print render($page['full_width_first']); ?>
					<?php if ($has_sidebar_content): ?>
						<div class="flex-container cf ">
							<div class="shift-left--fluid column__primary bg--white can-be--dark-light <?php if ($is_front): ?>no-pad--btm<?php endif ?>">
								<?php print render($page['primary_first']); ?>
								<div class="pad--primary spacing">
									<?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
									<?php print $breadcrumb; ?>
									<?php print render($page['content_first']); ?>
									<?php print render($page['content']); ?>
									<?php print render($page['content_last']); ?>
								</div>
								<?php print render($page['primary_last']); ?>
							</div>
							<div class="shift-right--fluid bg--beige can-be--dark-dark">
								<?php print render($page['sidebar_breakout']); ?>
								<?php print render($page['sidebar']); ?>
								<?php print render($page['sidebar_last']); ?>
							</div> <!-- /.shift-right--fluid -->
						</div>
					<?php else: ?>
					<div class="column__primary bg--white can-be--dark-light spacing--double <?php if ($is_front): ?>no-pad--btm<?php endif ?>">
						<?php print render($page['primary_first']); ?>
						<div class="pad--primary spacing">
							<?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
							<?php print $breadcrumb; ?>
							<?php print render($page['content_first']); ?>
							<?php print render($page['content']); ?>
							<?php print render($page['content_last']); ?>
						</div>
						<?php print render($page['primary_last']); ?>
					</div>
					<?php endif ?>
					<?php print render($page['full_width_last']); ?>
				</div>
			</main> <!-- /.main --> 
		</div>
	</div>
	<footer class="footer" role="contentinfo">
		<div class="footer__inner cf bg--medium-brown white can-be--dark-dark">
			<div class="layout-container">
				<div class="footer__unify-nav-desc spacing--until-large">
					<nav id="footer-nav" role="navigation" aria-labelledby="footer-nav" class="navigation footer-nav toggled-element">
						<?php AlpsMenuHelper::create(menu_load_links('menu-footer'), 'footer__nav', 'footer__nav-link font--secondary link--white', 'inline-list', 'footer__nav-item inline-list__item')->render(); ?>
					</nav>
					<div class="footer__desc">
						<span class="icon footer__logo">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 89.2 79.54">
								<title>Seventh Day Adventist Logo</title>
								<path d="M36.5,66h5v-0.3c0-3.5-1.6-6.1-12.7-4.1l-18.3,3.3L0,79.54,25.3,75c7.6-1.3,14.2-1.6,16.3,4.4v-9.9H36.5V66Z" class="fill--light-brown" fill="#b4aa9c"></path>
								<path d="M57.5,61.64l-4,4c-5.8,5.8-8.6,9-8.6,13.8,2.2-6.3,9.2-5.8,17.3-4.1l24.3,4.2L76,64.94Z" class="fill--light-brown" fill="#b4aa9c"></path>
								<path d="M53.9,56.34c-2.3,2.2-6.2,5.8-8,9.7H50l4.7-4.7c4.3-4.3,7.6-7.6,9-11.7a14.79,14.79,0,0,0,.8-7.5,4.69,4.69,0,0,0-.5-1.7c-0.4,4.7-1.7,7.5-8.5,14.3Z" class="fill--light-brown" fill="#b4aa9c"></path>
								<path d="M39.6,23l-8.8,8.8c-4.6,4.7-8.4,9.7-7.9,15.2,0.3,3.1,1.3,4.8,2,5.3,0.4,0.3.3,0.1,0.2-.1-2.7-6.1,3.7-12.4,6.9-15.6l9.2-9.2c2.5-2.4,8.8-8.1,8.8-13V9c0-.1-0.1,0-0.1,0C49.4,12.74,48.6,14.34,39.6,23Z" class="fill--light-brown" fill="#b4aa9c"></path>
								<path d="M50,18.44c0-.1-0.1,0-0.1,0-0.4,3.7-1.3,5.2-10.2,14.1l-8.2,8.2c-3,3-5.7,6.1-5.6,11.1,0.1,3.1,1.6,5.6,4,6.2,1,0.2.9,0.1,0.7,0-3.3-1.6-3.1-7.5,2.3-12.8l8.3-8.4c2.5-2.5,8.8-8.1,8.8-13v-5.4Z" class="fill--light-brown" fill="#b4aa9c"></path>
								<path d="M22.4,42.94c0.4-4.7,1.7-7.5,8.5-14.3l10.2-10.2c2.5-2.4,8.8-8.1,8.8-13V0c0-.1-0.1,0-0.1,0-0.4,3.6-1.3,5.2-10.2,14.1L31.7,22c-4.3,4.3-7.6,7.6-9,11.7a14.79,14.79,0,0,0-.8,7.5A4.69,4.69,0,0,0,22.4,42.94Z" class="fill--light-brown" fill="#b4aa9c"></path>
								<path d="M44.9,74.94H45a11.29,11.29,0,0,1,2.2-5.4H44.9v5.4Z" class="fill--light-brown" fill="#b4aa9c"></path>
								<path d="M55.5,45.44L52.9,48c-4,3.9-8,8.4-8,12.5V66H45c0.5-4,2.4-6.6,8.2-12.3l2.4-2.4c4.6-4.7,8.4-9.7,7.9-15.2-0.3-3.1-1.3-4.8-2-5.3-0.4-.3-0.3-0.1-0.2.1C64,37,57.6,43.34,55.5,45.44Z" class="fill--light-brown" fill="#b4aa9c"></path>
								<path d="M44.9,56.54H45c0.5-3.8,2.6-6.7,7.7-11.7l2.4-2.4c2.9-3,5.6-6.1,5.5-11.1-0.1-3-1.7-5.6-4-6.2-1-.2-0.9-0.1-0.7,0,3.3,1.5,3,7.5-2.3,12.8l-2.9,2.9c-1.9,1.9-5.8,6.2-5.8,10.1v5.6Z" class="fill--light-brown" fill="#b4aa9c"></path>
								<path d="M88.6,69.84a2,2,0,0,0-1.5-.6,1.82,1.82,0,0,0-1.6.8,2.39,2.39,0,0,0-.5,1.4,2.11,2.11,0,0,0,.5,1.3,2,2,0,0,0,1.6.7A2.12,2.12,0,0,0,88.6,69.84Zm-0.12,2.6H88.4a0.54,0.54,0,0,1-.4-0.3L87.9,72l-0.5-.7a4.35,4.35,0,0,0,.6-0.7c0-.4-0.2-0.6-0.8-0.6H86.4a0.1,0.1,0,0,0-.1.1c0,0.1,0,.1.1,0.1h0.1a0.25,0.25,0,0,1,.2.3v1.4c0,0.2.1,0.4,0,.4s-0.1.1-.2,0.1l-0.1.1c0,0.1,0,.1.1,0.1h0.8a0.1,0.1,0,0,0,.1-0.1c0-.1,0-0.1-0.1-0.1a0.35,0.35,0,0,1-.2-0.1A0.37,0.37,0,0,1,87,72v-0.6h0.2l0.1,0.1,0.4,0.7a0.74,0.74,0,0,0,.56.39A2,2,0,0,1,87.1,73a1.66,1.66,0,0,1-1.3-.5,2.11,2.11,0,0,1-.5-1.3,1.66,1.66,0,0,1,.5-1.3,2.11,2.11,0,0,1,1.3-.5,1.71,1.71,0,0,1,1.8,1.8A1.67,1.67,0,0,1,88.48,72.44Zm-1.78-2v-0.1c0-.1.1-0.1,0.2-0.1a0.76,0.76,0,0,1,.4.2,0.52,0.52,0,0,1,.2.4,0.4,0.4,0,0,1-.5.4H86.8c-0.1,0-.1-0.1,0,0Z" class="fill--light-brown" fill="#b4aa9c"></path>
							</svg>
						</span>
						<p class="footer__desc-text brown--light font--secondary">
							<?php print t("@domain is a website of the Seventh-day Adventist world church.", array('@domain' => $_SERVER['SERVER_NAME'])); ?>
						</p>
					</div> <!-- /.footer_desc -->
				</div> <!-- /.footer__unify-nav-desc -->
			</div> <!-- /.layout-container -->

			<div class="footer__legal bg--brown  can-be--dark-light">
				<div class="footer__legal__inner layout-container spacing--quarter--until-large">
					<div class="footer__unify-copyright-address spacing--quarter--until-large">
						<p class="footer__copyright font--secondary--xs brown--light no-space--btm">
							Copyright © <?php print "now"; ?><?php if ($alps_copyright): ?>, <?php print $alps_copyright; ?><?php endif ?>
						</p>
						<address class="footer__address font--secondary--xs brown--light"><?php print $alps_footer_address; ?></address>
					</div> <!-- /.footer__unify-copyright-address -->
					<div class="footer__legal-links font--secondary--xs">
						<?php $menu_legal_links = menu_load_links('menu-legal'); ?>
						<?php foreach ($menu_legal_links as $key => $link): ?>
							<a href="<?php print $link['link_path']; ?>" class="hover brown--light <?php if (end($menu_legal_links) !== $link): ?>space-half--right<?php endif ?> "><?php print $link['link_title']; ?></a>
						<?php endforeach ?>
					</div>
				</div> <!-- /.layout-container -->
			</div> <!-- /.legal -->
		</div> <!-- /.footer__inner -->
	</footer> <!-- /.footer -->
</div> <!-- /.content -->