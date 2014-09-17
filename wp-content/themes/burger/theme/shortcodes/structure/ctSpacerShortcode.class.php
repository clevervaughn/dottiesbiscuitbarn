<?php
/**
 *
 * @author alex
 */

class ctSpacerShortcode extends ctShortcode {

	/**
	 * Returns shortcode label
	 * @return mixed
	 */
	public function getName() {
		return "Spacer";
	}

	/**
	 * Returns shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'spacer';
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return mixed
	 */
	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));
		if (strpos($height, '%' ) === false && $height) {
			$height .= 'px';
		}

        $html = $height ? '<div class="spacer" style="height:' .$height. '"></div>'
            : '<div class="spacer" style="height:20px"></div>';


        return $html;
	}

	/**
	 * Returns config
	 * @return array
	 */
	public function getAttributes() {
		return array(
			'height' => array('label' => __('height', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Add space between elements. Default value in pixels (% is also supported)", 'ct_theme')),
		);
	}
}
new ctSpacerShortcode();