<?php
require_once CT_THEME_LIB_DIR . '/shortcodes/socials/ctTwitterShortcodeBase.class.php';
/**
 * Twitter shortcode
 */
class ctTwitterShortcode extends ctTwitterShortcodeBase {


	public function enqueueScripts() {
		wp_register_script('ct-customscroll', CT_THEME_ASSETS . '/js/customscroll/jquery.mCustomScrollbar.concat.min.js', array('jquery'),false,true);
		wp_enqueue_script('ct-customscroll');
		wp_enqueue_style( 'custom-scroll', CT_THEME_ASSETS . '/js/customscroll/jquery.mCustomScrollbar.css' );

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

        $mainContainerAtts = array(
            'class' => array(
                'tweets',
                $class
            ),
            'id' => 'tweeter-'.rand(100, 1000)
        );


		$newwindow = $newwindow == 'false' || $newwindow == 'no' ? false : true;
		$html = '';
		$followLink = $this->getFollowLink($user);
		$tweets = $this->getTweets($attributes);

		$counter = 1;
		$class = ' tweet';
		foreach ($tweets as $tweet) {
			$html .= $counter == 1 ? '<ul class="tweet_list ">' : '';
			$class .= $counter == 1 ? ' tweet_first' : '';
			$class .= $counter == 2 ? ' tweet_even' : ' tweet_odd';
			$html .= '<li class="tweetBox ' . $class . '">

						<span class="tweet_text">
						<a'.($newwindow?' target="_blank"':"").' href="'.$followLink.'">'.$tweet->user.'</a>
							' . $tweet->content . '
						</span>
						<span class="tweet_time">

							<a '.($newwindow?' target="_blank"':"").' href="'.$followLink.'">' . $this->ago($tweet->updated) . '</a>
						</span>
	               </li>';

			$html .= $counter == 3 ? '</ul>' : '';
			$counter++;
			$counter = ($counter < 4) ? $counter : 1;

		}
		if($counter != 1){
			$html .= '</ul>';
		}

        if ($widgetmode == "true"){

            $headerShortcode = $header ? '[header style ="" level="4"]'.$header.'[/header]' : '';
        }else{
            $headerShortcode = $header ? '[header style ="" level="3" class="big"]'.$header.'[/header]' : '';
        }

        if ($button){
            if ($newwindow =='true' || $newwindow=='yes'){
                $followButton_shortcode = '[button new_window="true" type="primary" size="sm" icon="fa-twitter" link="'.$followLink.'"]'.$button.'[/button]';
            }else{
                $followButton_shortcode = '[button type="primary" size="sm" icon="fa-twitter" link="'.$followLink.'"]'.$button.'[/button]';
            }
        }else{
            $followButton_shortcode ='';
        }
        $twitter = $headerShortcode;
        $twitter.='<div '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>'
             . $html
            .$followButton_shortcode.'
 </div>
        ';
		return do_shortcode($twitter);
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		$args = array_merge(
			array(
				'widgetmode' => array('default' => 'false', 'type' => false),
                'header' => array('label' => __('header', 'ct_theme'), 'default' => __('Latest Tweets', 'ct_theme'), 'type' => 'input'),
                'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
            ), parent::getAttributes());
		return $args;
	}
}

new ctTwitterShortcode();