<?php

/**
 * ctChapter shortcode
 *
 */
class ctGalleryGroupItemShortcode extends ctShortcode
{


    /**
     * @var int
     */
    static $counter = 0;

    /**
     * @var string
     */
    static $firstImageSrc = '';

    /**
     * @return int
     */
    public static function getCounter()
    {
        return ctGalleryGroupItemShortcode::$counter;
    }

    /**
     * @return string
     */
    public static function getFirstImageSrc()
    {
        return ctGalleryGroupItemShortcode::$firstImageSrc;
    }


    /**
     * @return bool
     */
    public static function setCounterReset()
    {
        ctGalleryGroupItemShortcode::$counter = 0;
        return true;
    }


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Gallery group item';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'gallery_group_item';
    }

    /**
     * Returns shortcode type
     * @return mixed|string
     */

    public function getShortcodeType()
    {
        return self::TYPE_SHORTCODE_ENCLOSING;
    }


    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     *
     */

    public function handle($atts, $content = null)
    {
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

        $mainContainerAtts = array(
            'class' => array(
                'galleryContainer',
                'row',
                $class
            ),
            'href' => $image,
            'data-rel' => ctGalleryGroupShortcode::getPrettyPhotoId()
        );

        $firstItem = false;
        if (ctGalleryGroupItemShortcode::$counter == 0) {
            /** @var $image string */
            ctGalleryGroupItemShortcode::$firstImageSrc = $image;
            $firstItem = true;
        }


        if ($firstItem == false) {
            $html = '
                <a  ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
                ' . do_shortcode('[img src="' . $image . '" alt=" "][/img]') . '
                </a>
            ';
        } else {
            $html = '';
            $firstItem = false;
        }

        ctGalleryGroupItemShortcode::$counter++;
        return $html;

    }


    /**
     * Parent shortcode name
     * @return null
     */

    public function getParentShortcodeName()
    {
        return 'gallery_group';
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'image' => array('label' => __("Image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image", 'ct_theme'), 'help' => __('Every Gallery Item should be wrapped in gallery group element.', 'ct_theme')),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
    }
}

new ctGalleryGroupItemShortcode();



