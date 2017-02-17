<?php
class AlpsMenuHelper {
	private $items;
	private $class_preface;
	private $ul_class;
	private $li_class;
	private $current_language;
	private $urls_lang_map;
	private $languages;

	public function __construct(
		array $items, 
		$class_preface = 'secondary-nav', 
		$link_class = 'theme--secondary-text-color', 
		$ul_class = NULL, 
		$li_class = NULL, 
		$current_language = NULL, 
		$urls_lang_map = array(), 
		$languages = array() 
	) {
		$this->items = $items;
		$this->class_preface = $class_preface;
		$this->link_class = $link_class;
		if (!$ul_class) {
			$ul_class = "{$class_preface}__list";
		}
		$this->ul_class = $ul_class;
		$this->li_class = $li_class;
		$this->current_language = $current_language;
		$this->urls_lang_map = $urls_lang_map;
		$this->languages = $languages;
	}

	/**
	 * Creates a class that can render a ul/li list of navigation items
	 *
	 * The only required field is `$items` which is an array of links.
	 * Each item in the list needs to have two properties: href & title
	 *
	 * Generally you will use a function to create the list.
	 * Use `menu_tree_page_data` if you'd like to use multiple levels of navigation.
	 * Use `menu_load_links` if you know your menu is only one level, or you'd like
	 * to flatten all of your items into one level.
	 */
	public static function create($items, $class_preface = 'secondary-nav', $link_class = 'theme--secondary-text-color', $ul_class = NULL, $li_class = NULL, $current_language = NULL, $urls_lang_map = array(), $languages = array()) {
		return new self($items, $class_preface, $link_class, $ul_class, $li_class, $current_language, $urls_lang_map, $languages);
	}

	/**
	 * Actually outputs the html markup for the items.
	 * $max_level is the maximum number of levels deep you can go.
	 * Currently 2 is the max that ALPS supports.
	 */
	public function render($max_level = 2) {
		$this->_outputLevel($this->items, 0, $max_level);
	}

	private function _outputLevel($items, $menu_level, $max_level) {
		if (!$items) {
			return;
		}
		if ($menu_level >= $max_level) {
			return;
		}
		if ($menu_level == 0) {
			?>
			<ul class="<?php print $this->ul_class; ?>">
				<?php if (is_array($this->languages) && count($this->languages) > 1): ?>
				<li class="secondary-nav__list-item rel">
					<a class="secondary-nav__link theme--secondary-text-color  js-toggle-parent " href="">
						<span class="secondary-nav__before-link"><span class="icon icon--xs"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 49.5 49.5"><title>World</title><path d="M25,0.25A24.75,24.75,0,1,0,49.75,25,24.78,24.78,0,0,0,25,.25ZM46.11,25a21,21,0,0,1-4.37,12.84,3.37,3.37,0,0,1-.82-3.93c0.78-1.7,1-5.64.81-7.17s-1-5.22-3.13-5.26-3.64-.75-4.93-3.31c-2.66-5.33,5-6.35,2.34-9.31-0.75-.83-4.6,3.41-5.16-2.24A3,3,0,0,1,31.7,5,21.14,21.14,0,0,1,46.11,25ZM22.1,4.1c-0.51,1-1.84,1.38-2.65,2.12C17.69,7.82,16.93,7.6,16,9.13s-4,3.74-4,4.85,1.56,2.41,2.34,2.16a8.33,8.33,0,0,1,4,.18c1.21,0.43,10.09.85,7.26,8.36-0.9,2.39-4.83,2-5.88,5.94A32.31,32.31,0,0,0,19,34.48c-0.06,1.25.89,6-.32,6s-4.48-4.22-4.48-5-0.85-3.45-.85-5.75S9.41,27.46,9.41,24.4c0-2.76,2.12-4.13,1.64-5.45s-4.2-1.36-5.75-1.52A21.16,21.16,0,0,1,22.1,4.1ZM18.36,45c1.27-.67,1.4-1.53,2.55-1.58a23.35,23.35,0,0,0,3.87-.84c1.32-.29,3.67-1.62,5.74-1.79,1.75-.14,5.19.09,6.12,1.78A21,21,0,0,1,18.36,45Z" transform="translate(-0.25 -0.25)" class="theme--secondary-fill-color"></path></svg></span></span>
						<strong><?php print $this->current_language->name; ?></strong> <span class="subnav__arrow dib arrow--down va--middle"></span>
					</a>
					<ul class="secondary-nav__subnav__list theme--secondary-background-color">
						<?php _debug($this->languages); ?>
						<?php foreach ($this->languages as $key => $language): ?>
						<?php print $this->_outputLanguageListItem($item->name, $item->id, $this->current_language, $this->urls_lang_map); ?>
						<?php endforeach ?>
					</ul> <!-- /.subnav -->
				</li>
				<?php endif ?>
			<?php
		} else {
			?>
			<ul class="<?php print "{$this->class_preface}__subnav"; ?>">
			<?php
		}
		foreach ($items as $key => $item) {
			$classes = array(
				self::isActive($item) ? 'menu-item--active-trail' : '',
				self::hasSubMenu($item, $menu_level, $max_level) ? "{$this->class_preface}--with-subnav" : '',
				$menu_level == 0 ? "{$this->class_preface}__list-item" : "{$this->class_preface}__subnav__list-item",
				$this->li_class,
			);
			?>
			<li <?php print drupal_attributes(array('class' => $classes)); ?><?php if ($menu_level == 0): ?> data-prefix="hover"<?php endif ?>>
				<?php 
				$classes = array(
					$this->link_class,
					$menu_level == 0 ? "{$this->class_preface}__link" : "{$this->class_preface}__subnav__link"
				);
				?>
				<?php print self::outputLink($item, array('class' => $classes)); ?>
				<?php if (self::hasSubMenu($item, $menu_level, $max_level)): ?>
					<div class="<?php print "{$this->class_preface}__subnav__arrow"; ?> va--middle js-toggle-parent"><span class="arrow--down"></span></div>
					<?php $this->_outputLevel($item['below'], $menu_level + 1, $max_level); ?>
				<?php endif ?>
			</li>
			<?php
		}
		?>
		</ul>
		<?php
	}

	public static function outputLink($item, array $attributes = array()) {
		if (isset($item['link']) && isset($item['below'])) {
			$item = $item['link']; // this type of structure is setn via menu_tree_page_data
		}
		$href = NULL;
		if (isset($item['href'])) {
			$href = $item['href'];
		} else if (isset($item['link_path'])) {
			$href = $item['link_path'];
		}
		$title = NULL;
		if (isset($item['title'])) {
			$title = $item['title'];
		} else if (isset($item['link_title'])) {
			$title = $item['link_title'];
		}
		?>
		<a href="<?php print url($href); ?>" <?php print drupal_attributes($attributes); ?>><?php print $title; ?></a>
		<?php
	}

	public static function isActive($item) {
		// TODO
	}

	public static function hasSubMenu($item, $menu_level, $max_level) {
		if (($menu_level+1) >= $max_level) { // $menu_level is zero indexed
			return false;
		}
		return isset($item['below']) && count($item['below']) > 0;
	}

	private function _outputLanguageListItem() {
		// TODO
	}
}
?>