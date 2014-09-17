<?php
/**
 * Testimonial shortcode
 */
class ctTestimonialShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Testimonial';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'testimonial';
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
                'testimonial',
                ($type == 'dark')? 'dark_ver' : ''
                )
        );


        $html='<div '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>';
            $html.='<div class="inner">';
                $html.='<p>'.$content.'</p>';
            $html.='</div>';
            $html.='<div class="media">';
                $html.='<a class="pull-left" href="'.$link.'">
                        <img class="media-object" src="'.$image.'">
                      </a>';
                $html.='<div class="media-body">'.$author.'</div>';
            $html.='</div>';
        $html.='</div>';

        return do_shortcode($html);

	}

	/**
	 * Parent shortcode name
	 * @return null
	 */

	public function getParentShortcodeName() {
		return 'testimonials';
	}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'author' => array('label' => __('author', 'ct_theme'), 'default' => '', 'type' => 'textarea', 'help' => __("Author", 'ct_theme')),
			'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => "textarea"),
            'image' => array('label' => __("Image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),
            'link' => array('label' => __('Link', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Link", 'ct_theme')),
            'type' => array('label' => __('Type', 'ct_theme'), 'default' => 'light', 'type' => 'select', 'options' => array(
                'light' => 'light',
                'dark' => 'dark',
            )),
		);
	}
}

new ctTestimonialShortcode();