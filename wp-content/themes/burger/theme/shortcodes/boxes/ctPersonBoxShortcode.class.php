<?php

/**
 * Pricelist shortcode
 */
class ctPersonBoxShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Person box';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'person_box';
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
     */

    public function handle($atts, $content = null)
    {
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));


        $mainContainerAtts = array(
            'class' => array(
                'personBox',
                $class
            )
        );
        $titleHtml = '<span class="ptitle">' . $title . '</span>';
        $subtitleHtml = '<span class="pname">' . $subtitle . '</span>';
        $imageShortcode = '[img src="' . $image . '"][/img]';
        $descriptionShortcode = '[paragraph]' . $description . '[/paragraph]';

        $html = '<div '.$this->buildContainerAttributes($mainContainerAtts, $atts).'>'.do_shortcode($titleHtml . $imageShortcode . $subtitleHtml . $descriptionShortcode . $content ).'</div>';


        return do_shortcode($html);
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'title' => array('label' => __('Title', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'subtitle' => array('label' => __('Subtitle', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'description' => array('label' => __('Description', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'image' => array('label' => __("Image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Custom class name", 'ct_theme')),
            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),


        );

    }
}

new ctPersonBoxShortcode();
