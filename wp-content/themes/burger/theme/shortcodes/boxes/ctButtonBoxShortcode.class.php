<?php
/**
 * Button Box shortcode
 */
class ctButtonBoxShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Button box';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'button_box';
	}

	/**
	 * Shortcode type
	 * @return string
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


        $mainContainerAtts = array(
            'class' => array(
                'buttonBox',
                'hdr1',
	            $class
            )
        );

        $linkShortcode = $link ? '[link class="btn btn-default btn-sm pull-right" link="'.$link.'"]'.$button_text.'[/link]' : '';
        $contentShortcode = $content ? '[paragraph class="pull-left"]'.$content.'[/paragraph]' : '';
        $html = '<div '.$this->buildContainerAttributes($mainContainerAtts, $atts).'>'.$contentShortcode.$linkShortcode.'</div><div class="clearfix"></div>';
        return do_shortcode($html);

	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'button_text' => array('label' => __('button text', 'ct_theme'), 'default' =>__('Click Here', 'ct_theme'), 'type' => 'input', 'help' => __("Button text", 'ct_theme')),
			'link' => array('label' => __('link', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Button link", 'ct_theme')),
			'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => "input"),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
		);
	}
}

new ctButtonBoxShortcode();