<?php
/**
 * 5/12 column shortcode
 */
class ctSevenTwelfthsColumnShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return '7/12 column';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'seven_twelfths_column';
	}

	/**
	 * Action
	 * @return string
	 */

	public function getGeneratorAction() {
		return self::GENERATOR_ACTION_INSERT;
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
                'col-md-7',
                $xs? 'col-xs-'.$xs : '',
                $sm? 'col-sm-'.$sm : '',
                $lg? 'col-lg-'.$lg : '',
                $class,
                (is_numeric($offset))? 'col-md-offset-'.$offset : ''
            )
        );


        return '<div '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>'.do_shortcode($content).'</div>';
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'class' => array('type' => false),
            'offset' => array('label' => __('Column offset', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'xs' => array('label' => __('Column for extra small devices', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '' => '')),
            'sm' => array('label' => __('Column for small devices', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '' => '')),
            'lg' => array('label' => __('Column for large devices ', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '' => '')),
		);
	}
}

new ctSevenTwelfthsColumnShortcode();