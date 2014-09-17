<?php
/**
 * Newsletter shortcode
 */
class ctNewsletterShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Newsletter';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'newsletter';
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
		$id = rand(100, 1000);
		$this->addInlineJS($this->getInlineJS($attributes, $id));
        $headerShortcode = $header ? '[header class="special" style="2" level="4"]'.$header.'[/header]' : '';

        $mainContainerAtts = array(
            'class' => array(
                'newsletterForm',
                'simpleForm',
                $class
            ),
            'method' => 'post'
        );


        return do_shortcode($headerShortcode . '
            <p>
              '.$content.'
            </p>
			<div class="successMsg hidden" id="newsletterInfo_'.$id.'">
               '.$success.'
            </div>
              <div class="errorMsg hidden" id="newsletterError_'.$id.'">
              '.$fail.'
            </div>
            <form ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
              <fieldset>
                <div class="form-group">
                  <input id="newsletterEmail_'.$id.'" class="form-control" type="email" name="email" required '.$this->getPlaceHolder($placeholders, $placeholder_email).'>
                </div>
                <input type="hidden" name="msg_subject" value="New Newsletter subscription">
                <input type="hidden" name="field_[]" value=" ">
                <input id="newsletterSubmit_'.$id.'" class="btn btn-default" type="submit" value="'.$buttontext.'">
              </fieldset>
            </form>
            <div id="contactFormInfo_' . $id . '" class="successMsg" style="display:none;">'.$success.'
            </div>
            <div id="contactFormError_' . $id . '" class="errorMsg" style="display:none;">
              '.$fail.'
            </div>
		');
	}

    /**
     * returns inline js
     * @param $attributes
     * @param $id
     * @return string
     */
    protected function getInlineJS($attributes, $id) {
        extract($attributes);
        return'

			jQuery(document).ready(function () {
				jQuery("#newsletterSubmit_'.$id.'").click(function(){
					var $email = jQuery("#newsletterEmail_'.$id.'").val();
					jQuery.ajax({
						type: "POST",
						url: "'.get_site_url().'/wp-admin/admin-ajax.php",
						data: {
							action: "NewsletterAjax",
							email: $email,
							mailto: "'.$mailto.'",
							subject: "'.$subject.'"
						},
						success: function (data, textStatus, XMLHttpRequest){
							if(data=="true"){
								jQuery("#newsletterInfo_'.$id.'").removeClass("hidden");
								jQuery("#newsletterEmail_'.$id.'").attr("value", "").hide();
								jQuery("#newsletterSubmit_'.$id.'").hide();
							}else{
								jQuery("#newsletterError_'.$id.'").removeClass("hidden");
								jQuery("#newsletterEmail_'.$id.'").addClass("error");
							}
						},
						error: function (MLHttpRequest, textStatus, errorThrown){
							jQuery("#newsletterInfo_'.$id.'").html("");
							jQuery("#newsletterSubmit_'.$id.'").hide();
							jQuery("#newsletterError_'.$id.'").removeClass("hidden");
						}
					})
					return false;
				});
			})
			//newsletter
			jQuery(document).ready(function () {
                jQuery(".newsletterBox form").submit(function () {
                    //ajax call
                    /*
                        var $f = $(this);
                        $f.fadeOut("fast", function () {
                            $f.closest(".dashedBox").append("<h3 class="doCenter huge">Thank you!</p>");
                        });
                    return false;
                    */
                });
			});
		';
    }


    protected function getPlaceHolder($show, $name) {
        if ($show) {
            return ' placeholder="' . $name . '"';
        }
        return '';
    }

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'widgetmode' => array('default' => 'false', 'type' => false),
			'header' => array('label' => __("header text", 'ct_theme'), 'default' => 'Newsletter', 'type' => 'input'),
            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
			'placeholder_email' => array('label' => __('placeholder', 'ct_theme'), 'default' => __('enter your email adress', 'ct_theme'), 'type' => 'input', 'help' => __("Placeholder text for input", 'ct_theme')),
            'placeholders' => array('default' => 'yes', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no'), 'label' => __('Show placeholders?', 'ct_theme'), 'help' => __("Placeholders are labels inside inputs which disappear when content is entered", 'ct_theme')),
			'buttontext' => array('label' => __("button text", 'ct_theme'), 'default' => __('Submit', 'ct_theme'), 'type' => 'input'),
			'success' => array('label' => __('success message', 'ct_theme'), 'default' => __('Thanks!', 'ct_theme'), 'type' => 'input', 'help' => __("Success message", 'ct_theme')),
			'fail' => array('label' => __('fail message', 'ct_theme'), 'default' => __('An error occured. Please try again.', 'ct_theme'), 'type' => 'input', 'help' => __("Fail message", 'ct_theme')),
            'mailto' => array('default' => get_bloginfo('admin_email'), 'type' => 'input', 'help' => __("Subscription receiver mail", 'ct_theme'), 'label' => __('Mail to', 'ct_theme')),
            'subject' => array('label' => __('subject', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Subject of the admin mail", 'ct_theme')),
            'class' => array('label' => __("Form Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),

        );
	}
}

new ctNewsletterShortcode();



function NewsletterAjax() {
    $email = $_POST['email'];
    $mailto = $_POST['mailto'];
    $subject = $_POST['subject'];

    $message = __("Newsletter subscription", 'ct_theme') . ": " . $email;
    $headers_mail = "From: Newsletter subscription <" . esc_attr($email) . "> \r\n";

    if (is_email($mailto) && is_email($email)) {
        add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
        if (wp_mail($mailto, $subject, $message, $headers_mail)) {
            die('true');
        }
    } else {
        die('false');
    }
}

add_action('wp_ajax_nopriv_NewsletterAjax', 'NewsletterAjax');
add_action('wp_ajax_NewsletterAjax', 'NewsletterAjax');