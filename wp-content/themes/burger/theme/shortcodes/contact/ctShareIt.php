<?php

/**
 * Price tag shortcode
 */
class ctShareIt extends ctShortcode {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Share It';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'share_it';
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
                'text-center',
                $class
            ),
        );


        $shareHtml = array(
            'open' => '<div '.$this->buildContainerAttributes($mainContainerAtts,$atts).'><a href="'.$link.'" target="blank" class="shareit '.$class.'"><i></i>'.$text,
            'close' => '</a></div>');
        $html = $shareHtml['open'].$shareHtml['close'];

        return do_shortcode($html);


	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
            'text' => array('label' => __("Link text", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Link URL", 'ct_theme')),
            'link' => array('label' => __("Link", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Link URL", 'ct_theme')),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
	}

}

new ctShareIt();