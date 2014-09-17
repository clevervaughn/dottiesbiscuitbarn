<?php

/**
 * Price tag shortcode
 */
class ctLink extends ctShortcode {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Link';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'link';
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

        $mailto = ($email =='yes' || $email == 'true') ? 'mailto:' : '';
        $linkHtml = array(
            'open' => '<a href="'.$mailto.$link.'" target="'.$target.'" class="'.$class.'">',
            'close' => '</a>');


        $html = $linkHtml['open'].$content.$linkHtml['close'];




        return do_shortcode($html);


	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(

            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => "textarea"),
            'link' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Link URL", 'ct_theme')),
            'target' => array('label' => __("Target", 'ct_theme'), 'default' => '_self', 'type' => 'input', 'help' => __("target", 'ct_theme')),
            'email' => array('label' => __('Email link?', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no'), 'help' => __("Select yes for email link", 'ct_theme')),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Custom class name", 'ct_theme')),
        );
	}

}

new ctLink();