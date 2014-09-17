<?php
/**
 * Full width row shortcode
 * @author hc
 */

class ctFullwidthRowShortcode extends ctShortcode {

	/**
	 * Returns shortcode label
	 * @return mixed
	 */
	public function getName() {
		return "Full width row";
	}

	/**
	 * Returns shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'full_width';
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return mixed
	 */
	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));
		//do not allow shortcode nesting
		return do_shortcode('</div>' . str_replace(array('[full_width]', '[/full_width]'), '', $content)  . '<div class="container">');
	}

	/**
	 * Returns config
	 * @return array
	 */
	public function getAttributes() {
		return array(
			'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => "textarea")
		);
	}
}

new ctFullwidthRowShortcode();