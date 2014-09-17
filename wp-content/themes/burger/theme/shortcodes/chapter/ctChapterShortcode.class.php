<?php

/**
 * ctChapter shortcode
 */
class ctChapterShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Chapter';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'chapter';
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
        $id = $id ? $id : 'ID' . rand(100, 999);

        if ($curved_header == 'yes' || $curved_header == 'true') {
            $curvedHeader = 'curved="yes" radius="' . $radius . '" direction="' . $direction . '"';
        } else {
            $curvedHeader = '';
        }


        $ToplineShortcode = ($line == 'top' || $line == 'both') ? ('[line style="' . $top_line_style . '"]') : '';
        $BottomlineShortcode = ($line == 'bottom' || $line == 'both') ? ('[spacer][line style="' . $bottom_line_style . '"]') : '';
        $header = $header ? $header = ('[header ' . $curvedHeader . ' level="' . $header_level . '" style="' . $header_style = ($header_style == '') ? '"]' . $header . '[/header]' : $header_style . '"]' . $header . '[/header]') : '';

        if ($bg_image_src && $bg_image_src != 'false' && $bg_image_src != 'none') {
            if (is_numeric($bg_image_src)) {
                $bg_image_src = 'data-image="' . get_stylesheet_directory_uri() . '/assets/images/content/background-' . $bg_image_src . '.jpg"';

            } else {
                $bg_image_src = 'data-image="' . $bg_image_src . '"';
            }
        }

        $background_image_repeat = ($background_image_repeat == 'yes') ? 'repeated' : '';
        $chapter_pattern_style = ($chapter_pattern_style && $chapter_pattern_style != 'none' && $chapter_pattern_style != 'false') ? 'bg-' . $chapter_pattern_style : '';
        $ornament = ($ornament != 'no') ? 'topOrnament' : '';
        $bg_image_attachment = ($bg_image_attachment == 'scroll') ? 'data-scroll="scroll"' : 'data-scroll="fixed"';
        $fullWidthShortcode = ($full_width == 'yes' || $full_width == 'true') ?
            array(
                'open' => '[full_width]',
                'close' => '[/full_width]') : '';
        $top_margin = ($top_margin == 'true' || $top_margin == 'yes') ? '20' : $top_margin;
        $bottom_margin = ($bottom_margin == 'true' || $bottom_margin == 'yes') ? '20' : $bottom_margin;
        $inner_top_margin = ($top_margin) ? 'data-topspace="' . $top_margin . '"' : '';
        $inner_bottom_margin = ($bottom_margin) ? 'data-bottomspace="' . $bottom_margin . '"' : '';

        $innerHtml = ($bg_image_src && $bg_image_src != 'false' && $bg_image_src != 'none') ?
            array(
                'open' => '<div class="inner ' . $background_image_repeat . ' ' . $bg_image_custom_class . '" ' . $bg_image_src . ' ' . $inner_top_margin . ' ' . $inner_bottom_margin . ' ' . $bg_image_attachment . '>',
                'close' => '</div>'
            ) : '';

        $sectionTopSpacerShortcode = (!$innerHtml && $top_margin != 'none' && $top_margin != 'false') ? '[spacer height="' . $top_margin . '"]' : '';
        $sectionBottomSpacerShortcode = (!$innerHtml && $bottom_margin != 'none' && $bottom_margin != 'false') ? '[spacer height="' . $bottom_margin . '"]' : '';

        $mainContainerAtts = array(
            'class' => array(
                'section',
                $chapter_pattern_style,
                $ornament,
                $chapter_custom_class,
                $class
            ),
        );
        $html = $ToplineShortcode;
        $html .= $fullWidthShortcode['open'];
        $html .= '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . ' id="' . $id . '" >';
        $html .= $sectionTopSpacerShortcode . (isset($innerHtml['open']) ? $innerHtml['open'] : '');
        $html .= $fullWidthShortcode['close'];
        $html .= $header . $content;
        $html .= $BottomlineShortcode;
        $html .= '</div>' . (isset($innerHtml['close']) ? $innerHtml['close'] : '') . $sectionBottomSpacerShortcode;

        return do_shortcode($html);
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'id' => array('label' => __('ID', 'ct_theme'), 'default' => 'chapter', 'type' => 'input'),
            'header' => array('label' => __('Header', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'header_level' => array('label' => __('Level of header', 'ct_theme'), 'default' => '3', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ), 'help' => __('Defines size of headers. 1 is maximum, 6 is minimum.', 'ct_theme')),
            'header_style' => array('label' => __('Select header style', 'ct_theme'), 'default' => '4', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '' => ''), 'help' => __('Check styles appearance here:', 'ct_theme'), 'link' => '/help/header.png'),

            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
            'bg_image_src' => array('label' => __("Background image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),
            'background_image_repeat' => array('label' => __('Background image repeat', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no'), 'help' => __("Background repeat", 'ct_theme')),
            'chapter_pattern_style' => array('label' => __('Chapter pattern style', 'ct_theme'), 'default' => '1', 'type' => 'select', 'options' => array('1' => '1', '2' => '2', 'none' => 'none'), 'help' => __("Select pattern style", 'ct_theme')),
            'ornament' => array('label' => __('Top chapter ornament', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no'), 'help' => __("Show top pattern ornament", 'ct_theme')),
            'bg_image_attachment' => array('label' => __('Backgroung image attachment', 'ct_theme'), 'default' => 'fixed', 'type' => 'select', 'options' => array('fixed' => 'fixed', 'scroll' => 'scroll'), 'help' => __("Select pattern attachment", 'ct_theme')),
            'chapter_custom_class' => array('Custom chapter class' => __('Title', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
            'bg_image_custom_class' => array('Custom background image class' => __('Title', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
            'top_margin' => array('label' => __('Chapter top spacer', 'ct_theme'), 'default' => 'none', 'type' => 'input', 'help' => __('Defines top margin of the chapter. Default value is 0. To set the top margin to chapter, enter value in pixels.', 'ct_theme')),
            'bottom_margin' => array('label' => __('Chapter bottom spacer', 'ct_theme'), 'default' => 'none', 'type' => 'input', 'help' => __('Defines bottom margin of the chapter. Default value is 0. To set the bottom margin to chapter, enter value in pixels.', 'ct_theme')),
            'line' => array('label' => __('Line', 'ct_theme'), 'default' => 'none', 'type' => 'select', 'options' => array(
                'none' => 'none',
                'top' => 'top',
                'bottom' => 'bottom',
                'both' => 'both',

            )),
            'top_line_style' => array('label' => __('Top line style', 'ct_theme'), 'default' => 'separator', 'type' => 'select', 'options' => array(
                '1' => '1',
                'separator' => 'separator',
                '' => ''
            ), 'help' => __('Choose a style. In the "line", select the "top" or "both"', 'ct_theme')),
            'bottom_line_style' => array('label' => __('Bottom line style', 'ct_theme'), 'default' => 'separator', 'type' => 'select', 'options' => array(
                '1' => '1',
                'separator' => 'separator',
                '' => ''
            ), 'help' => __('Choose a style. In the "line", select the "bottom" or "both"', 'ct_theme')),
            'curved_header' => array('Curved header' => __('Curved header', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no')),
            'radius' => array('label' => __('Curvature radius header', 'ct_theme'), 'default' => '800', 'type' => "input"),
            'direction' => array('label' => __('Curvature direction header', 'ct_theme'), 'default' => '1', 'type' => "input"),
            'full_width' => array('label' => __('full width chapter', 'ct_theme'), 'default' => 'yes', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no'), 'help' => __("Show top pattern ornament", 'ct_theme')),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
    }
}

new ctChapterShortcode();