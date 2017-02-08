<?php

class AlpsViewHelper {
	
	public function __construct() {

	}

	/**
	 * Renders an array of view fields
	 * @param  array $fields fields
	 * @param  stdClass $row    row object provided by views
	 */
	public static function renderFields($fields, $row) {
		?>
		<?php foreach ($fields as $id => $field): ?>
			<?php $options = self::getOptions($field); ?>
			<?php if (!empty($field->separator)): ?>
				<?php print $field->separator; ?>
			<?php endif; ?>

			<?php print $field->wrapper_prefix; ?>
				<?php print $field->label_html; ?>
				<?php if ($options['type'] === 'image'): ?>
					<?php 
					try {
						self::renderImage($field, $row);
					} catch (Exception $e) { }
					?>
				<?php elseif ($options['field'] === 'view_node'): ?>
					<a class="btn theme--secondary-background-color" href="<?php print url('node/'.$field->raw); ?>"><?php print $options['text']; ?></a>
				<?php elseif ($options['field'] === 'body'): ?>
					<div class="font--primary--xs"><?php print $field->content; ?></div>
				<?php else: ?>
					<?php print $field->content; ?>
				<?php endif ?>
			<?php print $field->wrapper_suffix; ?>
		<?php endforeach; ?>
		<?php
	}

	public static function getRowField($row, $field_name) {
		$field_name = "field_{$field_name}";
		$raw_field = $row->{$field_name};
		if (!is_array($raw_field) || empty($raw_field)) {
			return NULL;
		}
		return $raw_field;
	}

	/**
	 * Render an ALPS image for a view field
	 * @param  stdClass $field 
	 * @param  stdClass $row                
	 * @param  string $fallback_image_style Image Style string to use if view setting is `original`
	 */
	public static function renderImage($field, $row, $img_attributes = array(), $fallback_image_style = NULL, $link_attributes = array()) {
		$options = self::getOptions($field);
		if ($options['type'] != 'image') {
			throw new Exception("Not an image field");
		}
		$raw_field = self::getRowField($row, $options['field']);
		if (!$raw_field[0]['raw']['uri']) {
			return;
		}
		$settings = self::getSettings($field);
		$link_type = NULL;
		if (isset($settings['image_link'])) {
			$link_type = $settings['image_link'];
			if ($link_type === 'file' && !array_key_exists('target', $link_attributes)) {
				$link_attributes['target'] = '_blank';
			}
		}
		?>
		<?php foreach ($raw_field as $key => $raw_field_array): ?>
			<?php
			$image_style = self::getImageStyle($field) ?: $fallback_image_style;
			$url = null;
			if ($image_style) {
				$url = image_style_url($image_style, $raw_field_array['raw']['uri']);
			} else {
				file_create_url($raw_field_array['raw']['uri']);
			}
			?>
			<?php if ($link_type): ?>
				<a class="media-block__image-wrap block__image-wrap db" href="<?php print self::getLinkUrlFromType($link_type, $row->nid, $raw_field_array['raw']['uri']); ?>" <?php print drupal_attributes($link_attributes); ?>>
					<div class="dib">
			<?php endif ?>
			<img src="<?php print $url; ?>" alt="<?php print $raw_field_array['raw']['alt']; ?>" <?php print drupal_attributes($img_attributes); ?>>
			<?php if ($link_type): ?>
					</div>
                </a>
			<?php endif ?>
		<?php endforeach ?>
		<?php
	}

	public static function getLinkUrlFromType($type, $nid, $uri) {
		switch ($type) {
			case 'file':
				return file_create_url($uri);
				break;
			
			default:
				return url('node/'.$nid);
				break;
		}
	}

	/**
	 * Get field handler options
	 * @param  stdClass $field 
	 * @return [mixed] array of field options
	 */
	public static function getOptions($field) {
		return $field->handler->options;
	}

	/**
	 * Get field handler settings
	 * @param  [views_handler_field_field] $field
	 * @return [mixed]        [array of field settings]
	 */
	public static function getSettings($field) {
		return $field->handler->options['settings'];
	}

	public static function getImageStyle($field) {
		$settings = self::getSettings($field);
		return $settings['image_style'] ?: NULL;
	}

}