<?php
/**
 * Accordion shortcode
 */
class ctAccordionShortcode extends ctShortcode {

    static $id;
    public static function getParentId() {
        return ctAccordionShortcode::$id;
    }
	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Accordion';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'accordion';
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
                'panel-group',
	            $class
            ),
            'id' => 'accordion'.rand(100, 1000)
        );
        ctAccordionShortcode::$id = $mainContainerAtts['id'];

        $headerShortcode = $header ? '[header level="5" style="none"]'.$header.'[/header]' : '';
        $descriptionShortcode = $description ? '[paragraph]'.$description.'[/paragraph]' : '';
		$accordion = $headerShortcode . $descriptionShortcode . '<div '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>' . $content . '</div>';

        return do_shortcode($accordion);

    }


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
            'header' => array('label' => __('Header', 'ct_theme'),'default' => '', 'type' => 'input'),
            'description' => array('label' => __('Description', 'ct_theme'),'default' => '', 'type' => 'input'),
            'class' => array('label' => __('Custom class', 'ct_theme'),'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
		);
	}

	/**
	 * Child shortcode info
	 * @return array
	 */

	public function getChildShortcodeInfo() {
		return array('name' => 'accordion_item', 'min' => 1, 'max' => 20, 'default_qty' => 2);
	}
}

new ctAccordionShortcode();