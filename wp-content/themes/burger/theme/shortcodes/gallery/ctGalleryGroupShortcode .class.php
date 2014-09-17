<?php

/**
 * Native WP Gallery shortcode
 */
class ctGalleryGroupShortcode extends ctShortcode {

	static $prettyPhotoId = '';

	/**
	 * @return string
	 */
	public static function getPrettyPhotoId() {
		return ctGalleryGroupShortcode::$prettyPhotoId;
	}


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Gallery group';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'gallery_group';
	}

	/**
	 * Shortcode type
	 * @return string
	 */
	public function getShortcodeType() {
		return self::TYPE_SHORTCODE_ENCLOSING;
	}


	public function enqueueHeadScripts() {
		wp_register_style('ct-prettyPoto-css', CT_THEME_ASSETS . '/js/prettyPhoto/css/prettyPhoto.css');
		wp_enqueue_style('ct-prettyPoto-css');
	}

	public function enqueueScripts() {

		wp_register_script('ct-modernizr', CT_THEME_ASSETS . '/js/modernizr.custom.81779.js', array('jquery'),false,true);
		wp_enqueue_script('ct-modernizr');

		wp_register_script('ct-hoverdir', CT_THEME_ASSETS . '/js/jquery.hoverdir.js', array('jquery'),false,true);
		wp_enqueue_script('ct-hoverdir');

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
		$this->addInlineJS($this->getInlineJS($attributes, $id = null), true);

		$mainContainerAtts = array(
			'class' => array(
				'galleryContainer',
				'row',
                $class
			),
		);


		ctGalleryGroupItemShortcode::setCounterReset();
		$null = do_shortcode($content);
		$itemsCount = call_user_func('ctGalleryGroupItemShortcode::getCounter');
		$firstImageSrc = call_user_func('ctGalleryGroupItemShortcode::getFirstImageSrc');

		ctGalleryGroupItemShortcode::setCounterReset();
		ctGalleryGroupShortcode::$prettyPhotoId = 'prettyPhoto[gallery' . rand(0, 999) . '])';


		$cover_image = $cover_image ? $cover_image : $firstImageSrc;
		$html = '
         <ul ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
        <li class="col-md-3 col-sm-6">
        <div class="galleryBox">
            <div class="top">
              <span class="gallery_title_container"><span class="gallery_title_bg"><span>' . $title . '</span></span></span>
            </div>
            <div class="inner">
              <a href="' . $firstImageSrc . '" data-rel="' . ctGalleryGroupShortcode::$prettyPhotoId . '">
                <img src="' . $cover_image . '" alt=" ">

                <div><span>' . $itemsCount . ' images</span></div>
              </a>
            </div>
            <div class="hiddenGallery">
              ' . do_shortcode($content) . '
            </div>
          </div>
          </li></ul>

          ';


		return $html;
	}


	/**
	 * returns inline js
	 * @param $attributes
	 * @return string
	 */
	protected function getInlineJS($attributes, $id) {
		//extract($attributes);

		return '
                // Direction-aware hover effect
                jQuery(".galleryContainer > li .inner ").each(function () {
                    jQuery(this).hoverdir({
                            speed: 300,
                            easing: "ease",
                            hoverDelay: 25,
                            inverse: false
                        });
                    });
        ';
	}

	/**
	 * Child shortcode info
	 * @return array
	 */

	public function getChildShortcodeInfo() {
		return array('name' => 'gallery_group_item', 'min' => 1, 'max' => 100, 'default_qty' => 3);
	}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'title' => array('label' => __('Title', 'ct_theme'), 'default' => '', 'type' => "input"),
			'cover_image' => array('label' => __("Cover image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image", 'ct_theme')),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),

        );
	}
}

new ctGalleryGroupShortcode();



