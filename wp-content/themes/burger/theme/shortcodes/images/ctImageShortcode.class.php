<?php
/**
 * Image shortcode
 */
class ctImageShortcode extends ctShortcode {

	/**
	 * default image link base
	 */
	const DEFAULT_IMG_SRC = "http://dummyimage.com/";

	/**
	 * default image width
	 */
	const DEFAULT_IMG_WIDTH = 90;

	/**
	 * default image heightd
	 */
	const DEFAULT_IMG_HEIGHT = 90;

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Image';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'img';
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

		$src = $src ? $src : $this->getDefaultImgSrc($width, $height);
		switch ($align) {
			case 'center':
				$inlineCss = 'display:block; margin:0 auto;';
				$divContainerStyle = "text-align:center";
				break;
			case 'left':
                $inlineCss = 'float: left';
				$divContainerStyle = "text-align:left";
				break;
			case 'right':
                $inlineCss = 'float: right';
				$divContainerStyle = "text-align:right";
				break;
			default:
                $inlineCss = '';
				$divContainerStyle = "";

		}

		if ($width) {
			$width = $width ? 'width="' . (int)$width.'"' : '';
		}
		if ($height) {
			$height = $height ? 'height="' . (int)$height.'"' : '';
		}

        $mainContainerAtts = array(
            'class' => array(
                $class,
                ($align == 'right')? 'pull-right' : '',
                ($align == 'left')? 'pull-left' : '',
            ),
            'width' => $width ? 'width="' . (int)$width.'"' : '',
            'height'=> $height ? 'height="' . (int)$height.'"' : '',
            'alt' => $alt,
            'src' => $src,
            'style' => $inlineCss
        );

		$img = '<img '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>';

		//link
		if ($link) {
			$img = '<a href="' . $link . '">' . $img . '</a>';
		}
		return do_shortcode($img);
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'src' => array('label' => __("image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),
			'alt' => array('label' => __('alt', 'ct_theme'), 'default' => ' ', 'type' => 'input', 'help' => __("Alternate text", 'ct_theme')),
			'width' => array('label' => __('width', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Image width", 'ct_theme')),
			'height' => array('label' => __('height', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Image height", 'ct_theme')),
			'align' => array('label' => __('align', 'ct_theme'), 'default' => 'auto', 'type' => 'select', 'options' => array('default' => __('Default', 'ct_theme'), 'left' => __('Left', 'ct_theme'), 'center' => __('Center', 'ct_theme'), 'right' => __('Right', 'ct_theme')), 'help' => __("Image align", 'ct_theme')),
            'link' => array('label' => __('link', 'ct_theme'), 'help' => __("ex. http://www.google.com", 'ct_theme')),
			'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
		);
	}

	/**
	 * returns default image source
	 * @param $width
	 * @param $height
	 * @return string
	 */
	protected function getDefaultImgSrc($width, $height) {
		if($width && $height){
			return self::DEFAULT_IMG_SRC . $width . "x" . $height;
		}
		return '';
	}
}

new ctImageShortcode();