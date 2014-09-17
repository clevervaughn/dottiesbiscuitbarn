<?php

/**
 * Easy Box shortcode
 */
class ctEasyBoxShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Easy Box';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'easy_box';
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

		$mainContainerAtts = array(
				'class' => array(
						'easyBox',
						($style == 'flat') ? $style : '',
						($style == 'full') ? $style : '',
						($style == 'none' || $style == '' || $style == 'false') ? '' : '',
					$class

				),

		);

		$html = '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>' . $content . '</div>';

		return do_shortcode($html);

	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
				'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
				'style' => array('label' => __('style', 'ct_theme'), 'default' => '', 'type' => 'select',
						'choices' => array("flat" => "flat", "full" => "full", "" => ""), 'help' => __("Easy Box style", 'ct_theme')),
				'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
		);
	}


}

new ctEasyBoxShortcode();