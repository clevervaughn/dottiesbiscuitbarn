<?php
/**
 * Contact shortcode
 */
class ctContactShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Contact';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'contact';
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));



		$arrayOpeninghours = array();
		$arrayEmail = array();
		$arrayPhone = array();
		$arrayOpeninghours = explode(";", $opening_hours);
		$arrayEmail = explode(",", $email);
		$arrayPhone = explode(",", $phone);

        if ($email != '') {
            $i = 0;
            $shortcodeEmail = '';
            foreach ($arrayEmail as $value) {
                $shortcodeEmail.=' <a href="mailto:' . $value . '">' . $value . '</a><br>';
            }
        }

        if ($phone != '') {
            $i = 0;
            $shortcodePhone = '';
            foreach ($arrayPhone as $value) {
                $shortcodePhone.= $value;
                $shortcodePhone.='<br>';
            }

        }

		if ($opening_hours) {
			$shortcodeOpening = '[header level="4"]'.$hours_header.'[/header][paragraph]';
			foreach ($arrayOpeninghours as $key) {
                $line = explode(",", $key);
                foreach ($line as $key2) {
                    $shortcodeOpening.= $key2.'<br>';
                }
                $shortcodeOpening.= '<br>';
			}
            $shortcodeOpening.= '[/paragraph]';
		}



		if($header !=''){
			$shortcodeHeader = '[header level="4"]'.$header.'[/header]';
		}

        $shortcodeContact = '
            '.$shortcodeHeader.'
            [paragraph]
            '.$address.'
            <br>
            <br>
            '.$shortcodePhone.'
            <br>
            '.$shortcodeEmail.'
            [/paragraph]
            [line style="none"]
            '.$shortcodeOpening;

        return do_shortcode($shortcodeContact);
	}



	/**
	 * Returns config
	 *
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'widgetmode' => array('default' => 'false', 'type' => false),
			'header'=> array('label' => __('header', 'ct_theme'), 'default' => __('Contact', 'ct_theme'), 'type' => 'input'),
            'hours_header'=> array('label' => __('Opening hours header', 'ct_theme'), 'default' => '', 'type' => 'input'),
			'phone' => array('label' => __('phone', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("separating items with a comma", 'ct_theme')),
			'email' => array('label' => __('email', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("separating items with a comma", 'ct_theme')),
			'address' => array('label' => __('address', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('type "<br>" to enter the next line', 'ct_theme')),
			'opening_hours' => array('label' => __('opening hours', 'ct_theme'), 'default' => '', 'type' => "input",  'help' => __("separating items with a comma and semicolon. e.g. Monday - Friday,11:00 am - 11:00 pm;Saturday & Sunday,10:45 am - 5:00 pm;", 'ct_theme')),
		);
	}
}

new ctContactShortcode();