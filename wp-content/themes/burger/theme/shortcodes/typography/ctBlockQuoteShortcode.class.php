<?php

/**
 * BlockQuote shortcode
 */
class ctBlockQuoteShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Block quote';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'blockquote';
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
                ($type == '1') ? 'box_text' : 'type2',
                $class,
            ),
        );
        $contentShortcode = '[paragraph]' . $content . '[/paragraph]';
        $authorHtml = '<span class="author">' . $author . '</span>';


        $html = '<blockquote ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>';
        if ($type == '1') {
            $html .= '<span class="ribbon_icon"><i class="fa fa-quote-left"></i></span><div class="inner">';
            $html .= $contentShortcode . $authorHtml;
            $html .= '</div>';
        } else if ($type == '2') {
            $html .= $contentShortcode . $authorHtml;
        }
        $html .= '</blockquote>';

        return do_shortcode($html);
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'author' => array('label' => __('author', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Author", 'ct_theme')),
            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => "textarea"),
            'type' => array('label' => __('Type', 'ct_theme'), 'default' => '1', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
            )),
            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input',)
        );
    }
}

new ctBlockQuoteShortcode();