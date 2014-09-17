<?php
/**
 * Tabs shortcode
 */
class ctTabsShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Tabs';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'tabs';
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
                'nav nav-tabs',
	              ($style == 'light') ? 'type2' : '',
                ($style == 'dark') ? 'type2 dark_ver' : '',
                ($style == 'justified') ? 'nav-justified' : ''
            )
        );
		//parse shortcode before filters
		$itemsHtml = do_shortcode($content);

		$tabs = '<ul '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>';
		$tabs .= $this->callPreFilter(''); //reference
		$tabs .= '</ul>';

		//clean current tab cache
		$this->cleanData('tab');

        $headerShortcode = $header ? '[header level="5" style="none"]'.$header.'[/header]' : '';
        $descriptionShortcode = $description ? '[paragraph]'.$description.'[/paragraph]' : '';
		$tabs =  $headerShortcode . $descriptionShortcode . $tabs . '<div class="tab-content">' . $itemsHtml . '</div>';

        return do_shortcode($tabs);
	}



	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
        return array(
			'header' => array('label' => __('Header', 'ct_theme'),'default' => '', 'type' => 'input'),
            'description' => array('label' => __('Description', 'ct_theme'),'default' => '', 'type' => 'input'),
            'style' => array('label' => __('Tabs style', 'ct_theme'), 'default' => 'justified', 'type' => 'select', 'options' => array(
	              'justified' => 'justified',
	              'light' => 'light',
                'dark' => 'dark',
            )),
            'class' => array('label' => __('Custom class', 'ct_theme'),'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
		);

	}

	/**
	 * Child shortcode info
	 * @return array
	 */

	public function getChildShortcodeInfo() {
		return array('name' => 'tab', 'min' => 1, 'max' => 20, 'default_qty' => 1);
	}
}

new ctTabsShortcode();