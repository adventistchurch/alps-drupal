<?php

	function getThemeSetting($key, $defaul_value = NULL) {
		$value = theme_get_setting($key);
		if ($key === 'alps_primary_color') {
			switch ($value) {
				case 'emperor':
				case 'earth':
				case 'grapevine':
				case 'denim':
				case 'campfire':
				case 'treefrog':
				case 'ming':
					// this code merely forces one of the above options
					// to be present, otherwise, it will use the default of `emperor`
					break;
				default:
					$value = 'emperor'; // this ensures a proper theme is being used
			}
		} else if ($key === 'alps_secondary_color') {
			switch ($value) {
				case 'cool':
				case 'warm':
					// this code merely forces one of the above options
					// to be present, otherwise, it will use the default of `emperor`
					break;
				default:
					$value = 'cool'; // this ensures a proper theme is being used
			}
		} else if ($key === 'alps_use_dark_theme') {
			if ($value === 1 || $value === '1' || $value === TRUE) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else if ($key === 'logo') {
			// _debug($value);
			$path = path_to_theme().'/images/sda-logo--square--en.svg';
			$url = "/$path";
			if ($value != "") {
				$url = $value;
			}
			return array(
				'path' => $path,
				'url' => $url,
				'use_default' => 0
			);
		} else if ($key === 'alps_logo_horiz') {
			if (is_array($value) && array_key_exists('url', $value) && $value['url'] != "") {
				return $value;
			}
			$path = path_to_theme().'/images/sda-logo--horiz--en.svg';
			$url = '/'.path_to_theme().'/images/sda-logo--horiz--en.svg';
			if ($value != "") {
				$file = file_load($value);
				if ($file) {
					$path = $file->uri; // TODO: make sure $file is the URI
					$url = file_create_url($file->uri);
				}
			}
			return array(
				'path' => $path,
				'url' => $url,
				'use_default' => 0
			);
		}
		// use $default_value if the theme setting has been left NULL
		// NOTE: if the string is empty that could be intentional so we
		// won't use the provided $default_value in that scenario
		return is_null($value) ? $defaul_value : $value;
	}

	/**
	 * This function returns an array map to display alternate urls for different languages.
	 * @param  [Drupal\node\NodeInterface] $node 
	 * @return [mixed]       [description]
	 */
	function getAlternateLanguageUrlsForNode($node) {
		// Get all languages of the site
		$languages = getLanguagesInUse();
		$urls = array();
		if ($node) {
			foreach ($languages as $language) {
				$url = \Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => $node->id()], ['language' => $language]);
				$urls[$language->getId()] = \Drupal::service('path.alias_manager')->getAliasByPath($url->toString());
			}
		}
		return $urls;
	}

	function getLanguagesInUse() {
		$languages = \Drupal::languageManager()->getLanguages();
		return $languages;
	}

	function _debug() {
		if (function_exists('kpr')) {
			kpr(func_get_args());
			return;
		}
		var_dump(func_get_args());
	}

	function alps_without($element) {
		if ($element instanceof ArrayAccess) {
			$filtered_element = clone $element;
		}
		else {
			$filtered_element = $element;
		}
		$args = func_get_args();
		unset($args[0]);
		foreach ($args as $arg) {
			if (isset($filtered_element[$arg])) {
				unset($filtered_element[$arg]);
			}
		}
		return $filtered_element;
	}

	function alps_js_alter(&$javascript) {
		// $javascript['misc/jquery.js']['data'] = 'https://code.jquery.com/jquery-2.2.4.min.js';
		// $javascript['misc/jquery.migrate.js'] = array( 'data' => 'https://code.jquery.com/jquery-migrate-3.0.0.min.js' );
		// _debug($javascript);
	}

	function alps_css_alter(&$css) {
		$exclude = array(
			'misc/vertical-tabs.css' => FALSE,
			'modules/aggregator/aggregator.css' => FALSE,
			'modules/book/book.css' => FALSE,
			'modules/comment/comment.css' => FALSE,
			'modules/dblog/dblog.css' => FALSE,
			'modules/file/file.css' => FALSE,
			'modules/filter/filter.css' => FALSE,
			'modules/forum/forum.css' => FALSE,
			'modules/help/help.css' => FALSE,
			'modules/menu/menu.css' => FALSE,
			'modules/openid/openid.css' => FALSE,
			'modules/poll/poll.css' => FALSE,
			'modules/search/search.css' => FALSE,
			'modules/statistics/statistics.css' => FALSE,
			'modules/syslog/syslog.css' => FALSE,
			'modules/system/maintenance.css' => FALSE,
			'modules/system/system.maintenance.css' => FALSE,
			'modules/system/system.menus.css' => FALSE,
			'modules/system/system.messages.css' => FALSE,
			'modules/system/system.theme.css' => FALSE,
			'modules/taxonomy/taxonomy.css' => FALSE,
			'modules/tracker/tracker.css' => FALSE,
			'modules/update/update.css' => FALSE,
			'modules/user/user.css' => FALSE,
		);
		$css = array_diff_key($css, $exclude);
	}

	/**
	* Implements hook_preprocess_block().
	*/
	function alps_preprocess(&$variables, $hook)
	{
		$variables['base_path'] = base_path();
		global $language;
		$variables['current_language'] = $language;
		$variables['current_path'] = current_path();
		$variables['alps_primary_color'] = getThemeSetting('alps_primary_color');
		$variables['alps_secondary_color'] = getThemeSetting('alps_secondary_color');
		$variables['alps_use_dark_theme'] = getThemeSetting('alps_use_dark_theme');
		$variables['alps_logo_square'] = getThemeSetting('logo');
		$variables['alps_logo_horiz'] = getThemeSetting('alps_logo_horiz');
		$variables['alps_logo_text'] = getThemeSetting('alps_logo_text');
		$variables['alps_copyright'] = getThemeSetting('alps_copyright');
		$variables['alps_footer_address'] = getThemeSetting('alps_footer_address');
		// $variables['urls_lang_map'] = getAlternateLanguageUrlsForNode(\Drupal::routeMatch()->getParameter('node'));
		// $variables['languages_in_use'] = getLanguagesInUse();
	}

	function alps_preprocess_page(&$variables, $hook) {
		return;
		// $variables['alps_base_domain'] = \Drupal::request()->getHost();
		// $request = \Drupal::request();
		// if ($route = $request->attributes->get(\Symfony\Cmf\Component\Routing\RouteObjectInterface::ROUTE_OBJECT)) {
		// 	$title = \Drupal::service('title_resolver')->getTitle($request, $route);
		// 	$variables['page_title'] = $title;
		// }

		// if (isset($variables['node'])) {
		// 	try {
		// 		// We `try` because the user might not have a `field_header_image` setup
		// 		$images = $variables['node']->get('field_header_image');
		// 		if ($images) {
		// 			$header_images = array();
		// 			foreach ($images as $key => $image) {
		// 				$header_images[] = array(
		// 					'url' => \Drupal\image\Entity\ImageStyle::load('large')->buildUrl($image->entity->getFileUri()),
		// 					'attributes' => $image->getValue(),
		// 					'original' => $image
		// 				);
		// 			}
		// 			$variables['homepage_header_images'] = $header_images;
		// 		}
		// 	} catch (Exception $e) {}
		// }
	} 

	function alps_preprocess_node(&$variables) {
		$variables['theme_hook_suggestions'][] = 'node__' . $variables['view_mode'];
		$variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type . '__' . $variables['view_mode'];
		$variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->nid . '__' . $variables['view_mode'];
	}

	function alps_theme($existing, $type, $theme, $path) {
		return array(
			'alps__container__pager' => array(
				'render element' => 'content',
				'template' => 'pager-wrapper',
				'path' => drupal_get_path('theme', 'alps') . '/templates',
			)
		);
	}

	/**
	 * Copied from theme_form_element with one modification.
	 * We are removing the wrapper <div> if there is no #title
	 */
	function alps_form_element($variables) {
		$element = &$variables['element'];
		// This function is invoked as theme wrapper, but the rendered form element
		// may not necessarily have been processed by form_builder().
		$element += array(
			'#title_display' => 'before',
		);

		// Add element #id for #type 'item'.
		if (isset($element['#markup']) && !empty($element['#id'])) {
			$attributes['id'] = $element['#id'];
		}
		// Add element's #type and #name as class to aid with JS/CSS selectors.
		$attributes['class'] = array('form-item');
		if (!empty($element['#type'])) {
			$attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
		}
		if (!empty($element['#name'])) {
			$attributes['class'][] = 'form-item-' . strtr($element['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
		}
		// Add a class for disabled elements to facilitate cross-browser styling.
		if (!empty($element['#attributes']['disabled'])) {
			$attributes['class'][] = 'form-disabled';
		}
		if (isset($element['#title']) && $element['#title'] != "") {
			$output = '<div' . drupal_attributes($attributes) . '>' . "\n";
		}

		// If #title is not set, we don't display any label or required marker.
		if (!isset($element['#title'])) {
			$element['#title_display'] = 'none';
		}
		$prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
		$suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

		switch ($element['#title_display']) {
			case 'before':
			case 'invisible':
				$output .= ' ' . theme('form_element_label', $variables);
				$output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
				break;

			case 'after':
				$output .= ' ' . $prefix . $element['#children'] . $suffix;
				$output .= ' ' . theme('form_element_label', $variables) . "\n";
				break;

			case 'none':
			case 'attribute':
				// Output no label and no required marker, only the children.
				$output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
				break;
		}

		if (!empty($element['#description'])) {
			$output .= '<div class="description">' . $element['#description'] . "</div>\n";
		}

		if (isset($element['#title']) && $element['#title'] != "") {
			$output .= "</div>\n";
		}

		return $output;
	}

	/**
	 * Modify the search form on the search page to look like ALPS.
	 * This is done mainly by adding the correct classes, but removing the
	 * #title is also necessary.
	 */
	function alps_form_search_form_alter(&$form, &$form_state, $form_id) {
		$form['#attributes']['class'] = array('search__results__form');
		$form['#attributes']['data-drupal-selector'] = 'search__results__form';
		$form['basic']['#attributes']['class'] = array('field-container', 'field-container--inline');
		$form['basic']['keys']['#placeholder'] = $form['basic']['keys']['#title'];
		unset($form['basic']['keys']['#title']); // this will remove the input's div wrapper
		$form['basic']['submit']['#attributes']['class'][] = 'search__submit';
	}

	function alps_preprocess_views_view_fields(&$variables) {
		$variables['style_id'] = $variables['view']->style_plugin->plugin_name;
	}

	function alps_preprocess_links(&$variables) {
		if (isset($variables['links']['node-readmore'])) {
			foreach ($variables['links'] as $key => $link) {
				$classes = array();
				if (isset($link['#options']['attributes']['class'])) {
					$classes = $link['#options']['attributes']['class'];
				}
				if (!is_array($classes)) $classes = array();
				$classes[] = 'btn theme--secondary-background-color';
				$variables['links'][$key]['link']['#options']['attributes']['class'] = $classes;
			}
		}

	}

	/**
	 * Implements hook_page_attachments_alter().
	 */
	function alps_page_attachments_alter(array &$attachments) {
		return;
		foreach ($attachments['#attached']['html_head'] as $key => $attachment) {
			if ($attachment[1] == 'system_meta_generator') {
				unset($attachments['#attached']['html_head'][$key]);
			}
		}
	}

	function getPagerLink($variables) {
		$text = $variables['text'];
		$element = $variables['element'];
		$interval = $variables['interval'];
		$parameters = $variables['parameters'];
		global $pager_page_array, $pager_total;
		$output = '';

		// If we are anywhere but the last page
		if ($variables['next']) {
			$page_new = pager_load_array($pager_page_array[$element] + $interval, $element, $pager_page_array);
		} else {
			$page_new = pager_load_array($pager_page_array[$element] - $interval, $element, $pager_page_array);
		}
		$page = isset($_GET['page']) ? $_GET['page'] : '';
		if ($new_page = implode(',', pager_load_array($page_new[$element], $element, explode(',', $page)))) {
			$parameters['page'] = $new_page;
		}

		$query = array();
		if (count($parameters)) {
			$query = drupal_get_query_parameters($parameters, array());
		}
		if ($query_pager = pager_get_query_parameters()) {
			$query = array_merge($query, $query_pager);
		}
		return url($_GET['q'], array('query' => $query));
	}

	function alps_pager($variables) {
		$tags = $variables['tags'];
		$element = $variables['element'];
		$parameters = $variables['parameters'];
		$quantity = $variables['quantity'];
		global $pager_page_array, $pager_total;

		// Calculate various markers within this pager piece:
		// Middle is used to "center" pages around the current page.
		$pager_middle = ceil($quantity / 2);
		// current is the page we are currently paged to
		$pager_current = $pager_page_array[$element] + 1;
		// first is the first page listed by this pager piece (re quantity)
		$pager_first = $pager_current - $pager_middle + 1;
		// last is the last page listed by this pager piece (re quantity)
		$pager_last = $pager_current + $quantity - $pager_middle;
		// max is the maximum page number
		$pager_max = $pager_total[$element];
		// End of marker calculations.

		// Prepare for generation loop.
		$i = $pager_first;
		if ($pager_last > $pager_max) {
			// Adjust "center" if at end of query.
			$i = $i + ($pager_max - $pager_last);
			$pager_last = $pager_max;
		}
		if ($i <= 0) {
			// Adjust "center" if at start of query.
			$pager_last = $pager_last + (1 - $i);
			$i = 1;
		}
		// End of generation loop preparation.

		$li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('« first')), 'element' => $element, 'parameters' => $parameters));
		$li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
		$li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
		$li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('last »')), 'element' => $element, 'parameters' => $parameters));

		$items = array();
		if ($pager_total[$element] > 1) {
			if ($li_first) {
				$items['first'] = array(
					'class' => array('pager-first'),
					'data' => $li_first,
				);
			}
			if ($li_previous) {
				$items['previous'] = array(
					'class' => array('pager-previous'),
					'data' => $li_previous,
					'href' => getPagerLink(array('text' => $i, 'element' => $element, 'interval' => 1, 'parameters' => $parameters)),
				);
			}

			// When there is more than one page, create the pager list.
			if ($i != $pager_max) {
				if ($i > 1) {
					$items['ellipsis.previous'] = array(
						'class' => array('pager-ellipsis'),
						'data' => '…',
					);
				}
				// Now generate the actual pager piece.
				for (; $i <= $pager_last && $i <= $pager_max; $i++) {
					if ($i < $pager_current) {
						$link_data = theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters));
						$items['current'][] = array(
							'class' => array('pager-item'),
							'href' => getPagerLink(array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
							'data' => $i,
						);
					}
					if ($i == $pager_current) {
						$items['current'][] = array(
							'class' => 'pager-current',
							'data' => $i,
						);
					}
					if ($i > $pager_current) {
						$items['current'][] = array(
							'class' => array('pager-item'),
							'href' => getPagerLink(array('next' => TRUE, 'text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
							'data' => $i,
						);
					}
				}
				if ($i < $pager_max) {
					$items['ellipsis.next'] = array(
						'class' => array('pager-ellipsis'),
						'data' => '…',
					);
				}
			}
			// End generation.
			if ($li_next) {
				$items['next'] = array(
					'class' => array('pager-next'),
					'data' => $li_next,
					'href' => getPagerLink(array('next' => TRUE, 'text' => $i, 'element' => $element, 'interval' => 1, 'parameters' => $parameters)),
				);
			}
			if ($li_last) {
				$items['last'] = array(
					'class' => array('pager-last'),
					'data' => $li_last,
				);
			}

			$build = array(
				'#theme_wrappers' => array('alps__container__pager'),
				'#attributes' => array(
					'class' => array(
						'text-center',
					),
				),
				'pager' => array(
					'#theme' => 'item_list',
					'#items' => $items,
					'#attributes' => array(
						'class' => array('pagination'),
					),
				),
			);
			return drupal_render($build);
		}
	}

	/**
	 * Override theme_views_mini_pager
	 * Sends to templates/pager-wrapper.tpl.php
	 */
	function alps_views_mini_pager($variables) {
		global $pager_page_array, $pager_total;

		$tags = $variables['tags'];
		$element = $variables['element'];
		$parameters = $variables['parameters'];

		// current is the page we are currently paged to
		$pager_current = $pager_page_array[$element] + 1;
		// max is the maximum page number
		$pager_max = $pager_total[$element];
		// End of marker calculations.

		if ($pager_total[$element] > 1) {

			$li_previous = theme('pager_previous', array(
				'text' => (isset($tags[1]) ? $tags[1] : t('‹‹')),
				'element' => $element,
				'interval' => 1,
				'parameters' => $parameters,
			));
			if ($li_previous) {
				$items['previous'] = array(
					'class' => array('pager-previous'),
					'data' => $li_previous,
					'href' => getPagerLink(array('text' => 'Previous', 'element' => $element, 'interval' => 1, 'parameters' => $parameters)),
				);
			}

			$li_next = theme('pager_next', array(
				'text' => (isset($tags[3]) ? $tags[3] : t('››')),
				'element' => $element,
				'interval' => 1,
				'parameters' => $parameters,
			));

			if ($li_next) {
				$items['next'] = array(
					'class' => array('pager-next'),
					'data' => $li_next,
					'href' => getPagerLink(array('next' => TRUE, 'text' => $i, 'element' => $element, 'interval' => 1, 'parameters' => $parameters)),
				);
			}

			$items['mini.current'] = array(
				'class' => array('pager-current'),
				'data' => t('@current of @max', array('@current' => $pager_current, '@max' => $pager_max)),
			);

			$build = array(
				'#theme_wrappers' => array('alps__container__pager'),
				'#attributes' => array(
					'class' => array(
						'text-center',
					),
				),
				'pager' => array(
					'#theme' => 'item_list',
					'#items' => $items,
					'#attributes' => array(
						'class' => array('pagination'),
					),
				),
			);
			return drupal_render($build);
		}
	}

	function alps_menu_local_task($variables) {
		$link = $variables['element']['#link'];
		$link_text = $link['title'];

		if (!empty($variables['element']['#active'])) {
			// Add text to indicate active tab for non-visual users.
			$active = '<span class="element-invisible">' . t('(active tab)') . '</span>';

			// If the link does not contain HTML already, check_plain() it now.
			// After we set 'html'=TRUE the link will not be sanitized by l().
			if (empty($link['localized_options']['html'])) {
				$link['title'] = check_plain($link['title']);
			}
			$link['localized_options']['html'] = TRUE;
			$link_text = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));
		}

		if (!isset($link['localized_options'])) {
			$link['localized_options'] = array();
		}
		if (!isset($link['localized_options']['attributes'])) {
			$link['localized_options']['attributes'] = array();
		}
		if (!isset($link['localized_options']['attributes']['class'])) {
			$link['localized_options']['attributes']['class'] = array();
		}
		$link['localized_options']['attributes']['class'][] = 'btn theme--secondary-background-color';

		return '<li' . (!empty($variables['element']['#active']) ? ' class="active"' : '') . '>' . l($link_text, $link['href'], $link['localized_options']) . "</li>\n";
	}

	function alps_breadcrumb($variables) {
		$breadcrumbs = $variables['breadcrumb'];

		if (!empty($breadcrumbs)) {
			// Provide a navigational heading to give context for breadcrumbs links to
			// screen-reader users. Make the heading invisible with .element-invisible.
			$output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
			$output .= '<nav class="breadcrumbs" role="navigation" aria-labelledby="system-breadcrumb">';
			$output .= '<ul class="breadcrumbs__list">';
			foreach ($breadcrumbs as $key => $breadcrumb) {
				$output .= '<li class="breadcrumbs__list-item font--secondary--xs upper dib">' . str_replace("<a href=", "<a class=\"breadcrumbs__link can-be--white\" href=", $breadcrumb) . '</li>';
			}
			$output .= '<li class="breadcrumbs__list-item font--secondary--xs upper dib">' . drupal_get_title() . '</li>';
			$output .= '</ul>';
			$output .= '</nav>';
			return $output;
		}
	}

?>