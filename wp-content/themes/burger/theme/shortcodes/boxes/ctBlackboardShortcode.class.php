<?php
/**
 * Flex Slider shortcode
 */
class ctBlackboardShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Blackboard';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'blackboard';
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
        $this->addInlineJS($this->getInlineJS($attributes),true);

		$mainContainerAtts = array(
			'class'=>array('blackboard','custom-scrollbar',$class)
		);

        $html = '<div '.$this->buildContainerAttributes($mainContainerAtts, $atts).'>'.do_shortcode($content).'</div>';
        return $html;

	}


    /**
     * returns JS
     * @param $id
     * @return string
     */
    protected function getInlineJS($attributes) {
        return'
        // init custom scrollbar
        jQuery(".custom-scrollbar").mCustomScrollbar({
		horizontalScroll: false, /*scroll horizontally: boolean*/
		scrollInertia: 500, /*scrolling inertia: integer (milliseconds)*/
		mouseWheel: true, /*mousewheel support: boolean*/
		autoDraggerLength: false, /*auto-adjust scrollbar dragger length: boolean*/
		autoHideScrollbar: false, /*auto-hide scrollbar when idle*/
		scrollButtons: { /*scroll buttons*/
            enable: false, /*scroll buttons support: boolean*/
			scrollType: "continuous", /*scroll buttons scrolling type: "continuous", "pixels"*/
			scrollSpeed: "auto", /*scroll buttons continuous scrolling speed: integer, "auto"*/
			scrollAmount: 40 /*scroll buttons pixels scroll amount: integer (pixels)*/
		},
		advanced: {
            updateOnBrowserResize: true,
			updateOnContentResize: true,
			autoExpandHorizontalScroll: true,
			autoScrollOnFocus: true,
			normalizeMouseWheelDelta: false
		},
		contentTouchScroll: true,
		theme: "dark-thick"
	});';


    }


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
	}

}

new ctBlackboardShortcode();





















