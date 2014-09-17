<?php
/**
 * List shortcode
 */
class ctListShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'List';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'list';
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
                'list-unstyled',
                'list-icons',
                $class
            ),
        );

        $icon = $icon? $icon : 'fa-circle';
        $items = do_shortcode($content);
        $items = str_replace('<li>', '<li><i class="fa '.$icon.'"></i>', $items);
        $html = '<ul '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>'. $items.'</ul>';
		return do_shortcode($html);
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'icon' => array('icon' => __('Icon', 'ct_theme'), 'type' => "icon", 'default' => '','link'=>CT_THEME_ASSETS.'/shortcode/awesome/index.html'),
			'class' =>array('label'=>__('Custom class','ct_theme'),'type'=>'input','default'=>'', 'help' => "Set custom class to element"),
            'content' => array('label' => __('Content', 'ct_theme'), 'default' => '', 'type' => "textarea"),
        );
	}
}

new ctListShortcode();