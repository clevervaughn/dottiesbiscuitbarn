<?php

/**
 * Pricelist shortcode
 */
class ctProductBoxShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Product Box';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'product_box';
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
                'prodBox',
                ($style == '1') ? '' : 'type' . $style,
                ($align == 'right') ? 'pull-right' : '',
                ($align == 'left') ? 'pull-left' : '',
                $class
            ),
        );

        if ($rounded == 'yes' || $rounded == 'true'){
            $imageCode='[rounded_img  size="174" src ="'.$image.'"][/rounded_img]';
        }else{
            $imageCode = '<img src="' . $image . '" alt=" ">';
        }

        $buttonHtml = $button_label && $button_link ? ('<a href="' . $button_link . '" class="btn btn-primary btn-sm">' . $button_label . '</a>') : '';
        $postscript = $postscript ? '<span class="info">' . $postscript . '</span>' : '';
        $subprice = $subprice ? '<span>' . $subprice . '</span>' : '';
        $priceArea = ($price !='')?'<span class="price"><small>' . $above_price_text . '</small>
        '.((ct_get_option('products_currency_position','before_price')=='before_price' || ct_get_option('products_currency_position','before_price')=='')?'<em>' . $currency . '</em>' : $price . $subprice).
        ((ct_get_option('products_currency_position','before_price')=='before_price' || ct_get_option('products_currency_position','before_price')=='')? $price . $subprice  : '<em>' . $currency . '</em>').'
        </span>':'';





        $html = '
		<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
            <div class="frameImg">'.$imageCode.'</div>
            <div class="inner">
              <h4>' . $title . '</h4>
              <p>' . $content . '</p>';
              $html.=$priceArea.'
              ' . $postscript . '
              ' . $buttonHtml . '
            </div>
          </div>
		';
        return do_shortcode($html);
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'title' => array('label' => __('title', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
            'style' => array('label' => __('Select style', 'ct_theme'), 'default' => '1', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
            )),
            'rounded' => array('label' => __('Rounded ?', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array(
                'yes' => 'yes',
                'no' => 'no',
            )),
            'postscript' => array('label' => __('postcript', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("e.g. *promotion only on weekdays", 'ct_theme')),
            'image' => array('label' => __("image", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),
            'price' => array('label' => __('price', 'ct_theme'), 'default' => '', 'type' => 'input', 'example' => '456,50'),
            'subprice' => array('label' => __('subprice', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'above_price_text' => array('label' => __("Above price text", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Word above the price", 'ct_theme')),
            'currency' => array('label' => __('currency', 'ct_theme'), 'default' => ct_get_option('products_index_currency', '$'), 'type' => 'input'),
            'button_label' => array('default' => '', 'type' => 'input', 'label' => __("button text", 'ct_theme')),
            'button_link' => array('default' => '#', 'type' => 'input', 'label' => __("button link", 'ct_theme')),
            'align' => array('label' => __('Align', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array(
                '' => __('default', 'ct_theme'),
                'left' => __('left', 'ct_theme'),
                'right' => __('right', 'ct_theme')
            )),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),

        );

    }
}

new ctProductBoxShortcode();
