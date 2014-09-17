<?php

/**
 * Socials shortcode
 */
class ctSocialsShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Socials';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'socials';
    }

    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */
    public function handle($atts, $content = null)
    {
        $rssUrl = '';
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

        if (isset($atts['rss']) && ($atts['rss'] == 'no' || $atts['rss'] == 'false')){
            $atts['rss'] = null;
        }else{
            $rssUrl = get_bloginfo('rss2_url');
        }



        $socials = array(
            'bitbucket' => array(
                'link' => 'http://bitbucket.org/',
                'class' => 'fa fa-bitbucket'
            ),
            'dribbble' => array(
                'link' => 'http://dribbble.com/',
                'class' => 'fa fa-dribbble'
            ),
            'dropbox' => array(
                'link' => 'https://www.dropbox.com/',
                'class' => 'fa fa-dropbox'
            ),
            'facebook' => array(
                'link' => 'http://www.facebook.com/',
                'class' => 'fa fa-facebook'
            ),
            'flickr' => array(
                'link' => 'http://www.flickr.com/photos/',
                'class' => 'fa fa-flickr'
            ),
            'foursquare' => array(
                'link' => 'http://foursquare.com/user/',
                'class' => 'fa fa-foursquare'
            ),
            'github' => array(
                'link' => 'http://github.com/',
                'class' => 'fa fa-github'
            ),
            'gittip' => array(
                'link' => 'http://www.gittip.com/',
                'class' => 'fa fa-gittip'
            ),
            'google' => array(
                'link' => 'http://plus.google.com/',
                'class' => 'fa fa-google-plus'
            ),
            'instagram' => array(
                'link' => 'http://instagram.com/',
                'class' => 'fa fa-instagram'
            ),
            'linkedin' => array(
                'link' => 'http://www.linkedin.com/',
                'class' => 'fa fa-linkedin'
            ),
            'pinterest' => array(
                'link' => 'http://www.pinterest.com/',
                'class' => 'fa fa-pinterest'
            ),
            'renren' => array(
                'link' => 'http://www.renren.com/profile.do?id=',
                'class' => 'fa fa-renren'
            ),
            'rss' => array(
                'link' => $rssUrl,
                'class' => 'fa fa-rss'
            ),
            'skype' => array(
                'link' => array('skype:' . $skype . '?call'),
                'class' => 'fa fa-skype'
            ),
            'stack_exchange' => array(
                'link' => 'http://gamedev.stackexchange.com/users/',
                'class' => 'fa fa-stack-exchange'
            ),
            'stack_overflow' => array(
                'link' => 'http://stackoverflow.com/users/',
                'class' => 'fa fa-stack-overflow'
            ),
            'tumblr' => array(
                'link' => 'http://' . $tumblr . '.tumblr.com',
                'class' => 'fa fa-tumblr'
            ),
            'twitter' => array(
                'link' => 'http://www.twitter.com/',
                'class' => 'fa fa-twitter'

            ),
            'vimeo' => array(
                'link' => 'http://vimeo.com/',
                'class' => 'fa fa-vimeo-square'

            ),
            'vkontakte' => array(
                'link' => 'http://vk.com/',
                'class' => 'fa fa-vk'

            ),
            'weibo' => array(
                'link' => 'http://weibo.com/',
                'class' => 'fa fa-weibo'

            ),
            'xing' => array(
                'link' => 'http://www.xing.com/profile/',
                'class' => 'fa fa-xing'

            ),
            'yelp' => array(
                'link' => 'http://www.yelp.com/biz/',
                'class' => 'fa icon-yelp'

            ),
            'youtube' => array(
                'link' => 'http://www.youtube.com/',
                'class' => 'fa fa-youtube-play'

            )

        );
        $tooltip_placement = ($tooltip_placement && $tooltip_placement !='none') ?  ' data-toggle="tooltip" data-placement="'.$tooltip_placement.'" ' : '';
        $headerShortcode = $header? '[header level="5" style="none"]'.$header.'[/header][spacer]' : '';
        $style =  'soc_list soc-'.$size;



        $mainContainerAtts = array(
            'class' => array(
                'list-unstyled',
                'smallSocials',
                'clearfix',
                $style,
                $class
            ),
        );


        $html = $headerShortcode.'<ul '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>';
        foreach ($socials as $key => $value) {
            if ($atts){
                if (array_key_exists($key, $atts)) {
                    if ($atts[$key] !=''){
                        if ($key == 'rss'){
                            $atts[$key] = '';
                        }
                        $html .= '<li><a href="' . $value['link'] . $atts[$key] . '" target="_blank"'.$tooltip_placement.'title="'.$key.'"><i class="' . $value['class'] . '"></i></a></li>';
                    }
                }
            }
        }



	    
        $html .= '</ul>';

        return do_shortcode($html);

    }



    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'size' => array('label' => __('Size', 'ct_theme'), 'default' => 'small', 'type' => 'select', 'options' => array(
                'small' => 'small',
                'medium' => 'medium',
                'big' => 'big',
            )),
            'widgetmode' => array('default' => 'false', 'type' => false),
            'header' => array('label' => __("header text", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'tooltip_placement' => array('label' => __('Tooltip placement', 'ct_theme'), 'default' => 'top', 'type' => 'select', 'options' => array('top' => __('top', 'ct_theme'), 'right' => __('right', 'ct_theme'), 'bottom' => __('bottom', 'ct_theme')), 'left' => __('left', 'ct_theme'), 'none' => __('none', 'ct_theme'), 'help' => __("Select tooltip position", 'ct_theme')),
            'bitbucket' => array('label' => __("Bitbucket", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'dribbble' => array('label' => __("Dribbble username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'dropbox' => array('label' => __("Dropbox username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'facebook' => array('label' => __("Facebook username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'flickr' => array('label' => __("Flickr username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'foursquare' => array('label' => __("Foursquare user ID", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'github' => array('label' => __("Github username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'gittip' => array('label' => __("Gittip username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'google' => array('label' => __("Google+ username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'instagram' => array('label' => __("Instagram username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'linkedin' => array('label' => __("LinkedIn username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'pinterest' => array('label' => __("Pinterest username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'Renren' => array('label' => __("Renren ID", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'rss' => array('label' => __('Rss', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array('no' => __('no', 'ct_theme'), 'yes' => __('yes', 'ct_theme')), 'help' => __("Show rss feed link?", 'ct_theme')),
            'skype' => array('label' => __("Skype user", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'stack_exchange' => array('label' => __("Stack Exchange user ID", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'stack_overflow' => array('label' => __("Stack Overflow", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'tumblr' => array('label' => __("Tumblr user", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'twitter' => array('label' => __("Twitter username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'vimeo' => array('label' => __("Vimeo url - with http://", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'vkontakte' => array('label' => __("VKontakte", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'Weibo' => array('label' => __("Weibo username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'xing' => array('label' => __("xing username", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'yelp' => array('label' => __("Yelp Restaurant name", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("creates url e.g.: http://www.yelp.com/biz/your_restaurant_name", 'ct_theme')),
            'youtube' => array('label' => __("Youtube movie", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),

        );
    }
}

new ctSocialsShortcode();