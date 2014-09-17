<?php

/**
 * Flex Slider Item shortcode
 */
class ctSimpleSliderItemShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Simple Slider Item';
	}

	/**
	 * Parent shortcode name
	 * @return null
	 */
	public function getParentShortcodeName() {
		return 'simple_slider';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'simple_slider_item';
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */
	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

		$preLink = $link ? ('<a href="' . $link . '">') : '';
		$postLink = $link ? '</a>' : '';
        $imageShortcode = '[img src ="'.$imgsrc.'"][/img]';

        $mainContainerAtts = array(
            'class' => array($class)
        );

        $item = '
                    <li '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>
                        ' . $preLink.$imageShortcode.$postLink.'
                    </li>
                ';
		return do_shortcode($item);
	}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(

				'imgsrc' => array('label' => __("source", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image", 'ct_theme')),
				'link' => array('label' => __('link', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Link from image", 'ct_theme')),
                'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
		);
	}

}

new ctSimpleSliderItemShortcode();