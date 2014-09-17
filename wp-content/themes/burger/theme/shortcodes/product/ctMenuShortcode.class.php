<?php

/**
 * Draws works
 */
class ctMenuShortcode extends ctShortcodeQueryable {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Menu';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'menu';
	}


	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		$attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);
		extract($attributes);

		$products = $this->getCollection($attributes, array('post_type' => 'product'));
		$counter = 0;

		$categories = get_term_by('slug', $cat_name, 'product_category');
        if(!$categories){
            return __('Product category slug not found: ','ct_theme').$cat_name;
        }
		$categoryName = $categories->name;
        $category_description=$categories->description;

		$icons = $this->getDefaultIcons();
		if(isset($icons[$category_image])){
			$category_image = $icons[$category_image];
		}

		$menuBoxHtml = '[menu_box style="' . $style . '" title="' . $categoryName . '" image="' . $category_image . '" description="'.$category_description.'"]';

		foreach ($products as $p) {
			$custom = get_post_custom($p->ID);
			$counter++;

			$imageSrc = ($images == "yes" ? ct_get_feature_image_src($p->ID, 'full') : '');
			$thumb = ($images == 'yes' ? ct_product_featured_image2_src($p->ID, 'product_thumb') : '');


			$price = str_replace('.', ',', $custom['price'][0]);
			$productPrice = explode(",", $price);

			$menuBoxHtml .= $this->embedShortcode('menu_box_item', array(
					'thumb' => $thumb,
					'image' => $imageSrc,
					'separator' => $counter == count($products) ? 'no' : 'yes',
					'title' => $p->post_title,
					'price' => $productPrice[0],
					'subprice' => (isset($productPrice[1]) ? $productPrice[1] : ''),
			), $p->post_content)."\n";
		}

        $menuBoxHtml .= '[/menu_box]';

		return do_shortcode($menuBoxHtml);
	}


	/**
	 * creates class name for the category
	 * @param $cat
	 * @return string
	 */
	protected function getCatFilterClass($cat) {
		return strtolower(str_replace(' ', '-', $cat->slug));
	}


	/**
	 * Shortcode type
	 * @return string
	 */
	public function getShortcodeType() {
		return self::TYPE_SHORTCODE_SELF_CLOSING;
	}

	/**
	 * Returns default icons
	 * @return array
	 */
	protected function getDefaultIcons() {
		$base = CT_THEME_ASSETS . '/images/icons/';
		return array(
				'biscuit' => $base . 'biscuit.png',
				'burger' => $base . 'burger.png',
				'cupcake' => $base . 'cupcake.png',
				'drink' => $base . 'drink.png',
				'fish' => $base . 'fish.png',
				'pie' => $base . 'pie.png',
				'sandwich' => $base . 'sandwich.png',
				'taco' => $base . 'taco.png'
		);
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		$atts = $this->getAttributesWithQuery(array(
				'cat_name' => array('query_map' => 'category_name', 'default' => '', 'type' => 'input', 'label' => __("Category name", 'ct_theme'), 'help' => __("Name of category to filter", 'ct_theme')),
				'category_image' => array('label' => __("Category image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Category image. You can also use default icons by writing their name: " . implode(', ', array_keys($this->getDefaultIcons())), 'ct_theme')),
				'images' => array('label' => __('images', 'ct_theme'), 'default' => 'yes', 'type' => 'select', 'choices' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme')), 'help' => __("Show images?", 'ct_theme')),
				'limit' => array('label' => __('limit', 'ct_theme'), 'default' => '100', 'type' => 'input', 'help' => __("Number of elements", 'ct_theme')),
				'style' => array('label' => __('Select style', 'ct_theme'), 'default' => '1', 'type' => 'select', 'options' => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
				)),

		));

		if (isset($atts['cat'])) {
			unset($atts['cat']);
		}
		return $atts;
	}
}

new ctMenuShortcode();