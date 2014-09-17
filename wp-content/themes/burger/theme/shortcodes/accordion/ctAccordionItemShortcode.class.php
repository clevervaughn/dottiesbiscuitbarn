<?php
/**
 * Accordion item shortcode
 */
class ctAccordionItemShortcode extends ctShortcode {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Accordion item';
	}


	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'accordion_item';
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));
		$isActive = $active=='yes';
        $parent_id  = call_user_func('ctAccordionShortcode::getParentId');
        $id = rand(100,1000);


        $mainContainerAtts = array(
            'class' => array(
                'panel',
                'panel-default',
                ($isActive?'accordion':''),
                $class
            ),

        );


        return '<div '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>
                <div class="panel-heading">
                    <h4 class="panel-title">

                        <a data-toggle="collapse" data-parent="#'.$parent_id.'" href="#collapse' . $id . '" '.($isActive?'':'class="collapsed" ').'>
                            <span class="btn btn-primary onlyfaq"></span>'.$title.'
        </a>
                    </h4>
                </div>
                <div id="collapse' . $id . '" class="panel-collapse collapse '.($isActive?'in ':'').'">
                    <div class="panel-body">
        ' . do_shortcode($content) . '
                    </div>
                </div>
            </div>';

	}
	/**
	 * Shortcode type
	 * @return string
	 */
	public function getShortcodeType() {
		return self::TYPE_SHORTCODE_ENCLOSING;
	}

	/**
	 * Parent shortcode name
	 * @return null
	 */

	public function getParentShortcodeName() {
		return 'accordion';
	}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'title' => array('label' => __('title', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Every accordion item should be wrapped in accordion element.', 'ct_theme')),
			'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
			'active' => array('label' => __('is active', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'choices' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme')),),
            'class' => array('label' => __('Custom class', 'ct_theme'),'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
	}
}

new ctAccordionItemShortcode();