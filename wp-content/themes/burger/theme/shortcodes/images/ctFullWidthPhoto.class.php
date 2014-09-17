<?php
/**
 * Image shortcode
 */
class ctFullWidthPhoto extends ctShortcode {



	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Full Width Photo';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'full_width_photo';
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

		$class = $class ? $class : '';

        $mainContainerAtts = array(
            'class' => array(
                $class,
                'full-width-photo'
            ),
            'data-image' => $src
        );


        $html = '<div '.$this->buildContainerAttributes($mainContainerAtts,$atts).'></div>';


		return do_shortcode($html);

	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'src' => array('label' => __("image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),
			'alt' => array('label' => __('alt', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Alternate text", 'ct_theme')),
			'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
		);
	}
}

new ctFullWidthPhoto();