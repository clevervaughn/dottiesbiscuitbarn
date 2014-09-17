<?php
/**
 * Image shortcode
 */
class ctRoundedImageShortcode extends ctShortcode {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Rounded image';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'rounded_img';
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));
        $this->addInlineJS($this->getInlineJS(),true);

        $mainContainerAtts = array(
            'class' => array(
                'roundedImg',
                ($align == 'right')? 'pull-right' : '',
                ($align == 'left')? 'pull-left' : '',
                $class
            ),
            'data-size' => $size
        );


        $img = '<img class="media" alt="' . $alt . '" src="' . $src . '">';

        if ($link) {
            $img = '<a href="' . $link . '">' . $img . '</a>';
        }

        $html = '<div '.$this->buildContainerAttributes($mainContainerAtts,$atts).' >'.$img.'</div>';


		return do_shortcode($html);
	}

    /**
     * returns inline js
     * @param $attributes
     * @return string
     */
    protected function getInlineJS() {
        //extract($attributes);

        return'
                // init rounded image
                    jQuery(".roundedImg").each(function () {
                        var $this = jQuery(this);
                        var imgpath = $this.find("img").attr("src");
                        $this.css("background-image", "url(" + imgpath + ")");

                        var $sizeImg = $this.data("size");
                        if (validateDataAttr($sizeImg)) {
                            var size = $sizeImg;

                            $this.css({
                                width: size,
                                height: size
                            });
                        }
                    })
        ';
    }

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'src' => array('label' => __("image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),
			'alt' => array('label' => __('alt', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Alternate text", 'ct_theme')),
			'size' => array('label' => __('Size', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Size in px", 'ct_theme')),
            'link' => array('label' => __('link', 'ct_theme'), 'help' => __("ex. http://www.google.com", 'ct_theme')),
            'align' => array('label' => __('Align', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array(
                '' => __('default', 'ct_theme'),
                'left' => __('left', 'ct_theme'),
                'right' => __('right', 'ct_theme')
            )),
			'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
		);
	}

	/**
	 * returns default image source
	 * @param $width
	 * @param $height
	 * @return string
	 */

}

new ctRoundedImageShortcode();