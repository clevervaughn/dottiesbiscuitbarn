<?php

/**
 * Pricelist shortcode
 */
class ctMenuBoxShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Menu Box';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'menu_box';
	}

	/**
	 * Returns shortcode type
	 * @return mixed|string
	 */

	public function getShortcodeType() {
		return self::TYPE_SHORTCODE_ENCLOSING;
	}


	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));


		$style = ($style == '1') ? '' : 'type' . $style;
		$image = $image ? '[img src="'.$image.'" alt=" "][/img]' : '';

        $descHtml = $description? '<div class="cat_desc" style="padding-bottom:20px" >'.$description.'</div>':'';

        $mainContainerAtts = array(
            'class' => array(
                'menuBox',
                $class,
                $style
            )
        );


		$html = '
		<div '.$this->buildContainerAttributes($mainContainerAtts, $atts).'">
	        <div class="top">
		        '.$image.'
		        <span class="menu_title_container"><span class="menu_title_bg"><span>'.$title.'</span></span></span>
			</div>
			<div class="inner">
				'.$descHtml.$content.'
	        </div>
        </div>
		';
		return do_shortcode($html);
	}

	/**
	 * Child shortcode info
	 * @return array
	 */

	public function getChildShortcodeInfo() {
		return array('name' => 'menu_box_item', 'min' => 1, 'max' => 50, 'default_qty' => 3);
	}
	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
				'title' => array('label' => __('title', 'ct_theme'), 'default' => '', 'type' => 'input'),
				'image' => array('label' => __("image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),
				'style' => array('label' => __('Select style', 'ct_theme'), 'default' => '1', 'type' => 'select', 'options' => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
				)),
				'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
            'description_title' => array('label' => __("Category description title", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding category description title', 'ct_theme')),

            'description' => array('label' => __("Category description", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding category description', 'ct_theme')),

        );

	}
}

new ctMenuBoxShortcode();
