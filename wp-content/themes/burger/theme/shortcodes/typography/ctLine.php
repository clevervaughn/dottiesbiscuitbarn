<?php

/**
 * Price tag shortcode
 */
class ctLine extends ctShortcode {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Separator';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'line';
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

        $mainContainerAtts = array(
            'class' => array(
                ($style == '1') ? 'line1' : '',
                ($style == 'separator') ? 'line-separator' : '',
                ($style == 'dashed') ? 'dashed-separator' : '',
                $class
            )
        );

		$html = '<hr '.$this->buildContainerAttributes($mainContainerAtts, $atts).'>';

		return do_shortcode($html);
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'style' => array('label' => __('Select style', 'ct_theme'), 'default' => 'separator', 'type' => 'select', 'options' => array(
				'1' => '1',
                'separator' => 'separator',
                'dashed' => 'dashed separator',
				'' => '')),
			'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Custom class name", 'ct_theme')),
		);
	}

}

new ctLine();