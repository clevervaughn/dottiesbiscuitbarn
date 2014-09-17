<?php
/**
 * Flex Slider shortcode
 */
class ctAboutUsShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'About Us';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'about_us';
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

        $headerShortcode = $header ? '[header style="7" level="4"]'.$header.'[/header]' : '';
        $imageShortcode = $imgsrc ?  '[rounded_img class="pull-right"  size="'.$image_size.'" src ="'.$imgsrc.'"][/rounded_img]' : '';
        $contentShortcode = $content ? '[paragraph class="bigger'.($class?' '.$class:'').'"]'.$content.'[/paragraph]' : '';
        $html = do_shortcode($headerShortcode.$imageShortcode.$contentShortcode);

        return $html;

	}



	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
            'header' => array('label' => __('header', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'imgsrc' => array('label' => __("source", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image", 'ct_theme')),
            'image_size' => array('label' => __('Image Size', 'ct_theme'), 'default' => '160', 'type' => 'input', 'help' => __("Size in px", 'ct_theme')),
            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
	}



}

new ctAboutUsShortcode();