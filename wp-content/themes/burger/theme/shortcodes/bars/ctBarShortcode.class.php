<?php
/**
 * Bar shortcode
 */
class ctBarShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Bar';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'bar';
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
                'progress',
                $class
            ),

        );

		return '
			'. $title . '
			 <div' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
                <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%">
                    <span class="sr-only"> '.$percent.'</span>
                </div>
             </div>
           ';
	}

	/**
	 * Parent shortcode name
	 * @return null
	 */

	public function getParentShortcodeName() {
		return 'bars';
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'title' => array('label' => __('title', 'ct_theme'), 'default' => '', 'type' => 'input'),
			'percent' => array('label' => __('percent', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'class' => array('label' => __('Custom class', 'ct_theme'), 'type' => "input", 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),

        );
	}
}

new ctBarShortcode();