<?php
/**
 * Paragraph shortcode
 */
class ctParagraphShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Paragraph';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'paragraph';
	}

	/**
	 * Returns shortcode type
	 * @return mixed|string
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
                ($bigger == 'yes' || $bigger == 'true') ? 'bigger' : '',
                ($highlighted == 'yes' || $highlighted == 'true') ? 'highlighted' : '',
                $class
            ),
        );

        return do_shortcode('<p '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>' . $content . '</p>');
    }


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'class' => array('label' => __('CSS class', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'bigger' => array('label' => __('Bigger', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no')),
            'highlighted' => array('label' => __('Highlighted', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no')),
            'content' => array('label' => __('Content', 'ct_theme'), 'default' => '', 'type' => "textarea"),
		);
	}
}

new ctParagraphShortcode();