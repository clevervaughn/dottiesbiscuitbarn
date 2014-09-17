<?php

/**
 * Contact form shortcode
 */
class ctContactFormShortcode extends ctShortcode {

    /**
     * Returns name
     * @return string|void
     */
    public function getName() {
        return 'Contact form';
    }


    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName() {
        return 'contact_form';
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

        $mainContainerAtts = array(
            'class' => array(
                'contactForm',
                $class
            ),
            'id' => 'contactForm_' . $id
        );

        $placeholders = $placeholders == 'yes' ? true : false;
        $this->addInlineJS($this->getInlineJS($attributes, $id));
        $headerShortcode = $header ? '[header class="special" style="2" level="4"]' . $header . '[/header]' : '';
        $easyBoxShortcode = ($easy_box == 'true' || $easy_box == 'yes') ? array('open' => '[easy_box style="none"]', 'close' => '[/easy_box]')
            : array('open' => '', 'close' => '');

        $contact = $easyBoxShortcode['open'];
        $contact .= $headerShortcode;
        $contact .= do_shortcode($this->embedShortcode('alert_box', array('class' => "hidden", 'type' => 'success', 'id' => 'contactFormInfo_' . $id), $success) . $this->embedShortcode('alert_box', array('id' => 'contactFormError_' . $id, 'type' => 'danger', 'class' => "hidden"), $fail));
        $contact .= '
		  <div class="successMsg" id="successMsg_'.$id.'"  style="display:none;">
               '.$success.'
            </div>
              <div class="errorMsg" id="errorMsg_'.$id.'" style="display:none;">
              '.$fail.'
            </div>
            <form ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
              <fieldset>
                <div class="form-group">
                  <label>' . $label_name . '</label>
                  <input  id="contactFormName_' . $id . '" type="text" required class="form-control" ' . $this->getPlaceHolder($placeholders, $placeholder_name) . '>
                </div>
                <div class="form-group">
                  <label>' . $label_email . '</label>
                  <input  id="contactFormEmail_' . $id . '" type="email" required class="form-control" name="email" ' . $this->getPlaceHolder($placeholders, $placeholder_email) . '>
                </div>
                <div class="form-group">
                  <label>' . $label_message . '</label>
                  <textarea  id="contactFormText_' . $id . '" class="form-control" rows="5"  ' . $this->getPlaceHolder($placeholders, $placeholder_message) . '></textarea>
                </div>
                <input type="hidden" name="msg_subject" value="'.esc_attr($subject).'">
                <input type="hidden" name="field_[]" value=" ">
                <input id="contactFormSubmit_' . $id . '" class="btn btn-default" type="submit" value="'.esc_attr($buttontext).'">
              </fieldset>

            </form>
			';

        $contact .= $easyBoxShortcode['close'];
        return do_shortcode($contact);
    }

    /**
     * returns inline js
     * @param $attributes
     * @param $id
     * @return string
     */
    protected function getInlineJS($attributes, $id) {
        extract($attributes);
        return '
			jQuery(document).ready(function () {
				jQuery("#contactFormSubmit_' . $id . '").click(function(){

						var $name = jQuery("#contactFormName_' . $id . '").val();
						var $email = jQuery("#contactFormEmail_' . $id . '").val();
						var $text = jQuery("#contactFormText_' . $id . '").val();

						jQuery.ajax({
							type: "POST",
							url: "' . get_site_url() . '/wp-admin/admin-ajax.php",
							data: {
								action: "ContactFormAjax",
								name: $name,
								email: $email,
								text: $text,
								mailto: "' . $mailto . '",
								subject: "' . $subject . '"
							},
							success: function (data, textStatus, XMLHttpRequest){

							jQuery("#errorMsg_'.$id.'").addClass("hidden");
							jQuery("#contactFormInfo_' . $id . '").addClass("hidden");

							jQuery("#contactFormName_' . $id . '").removeClass("error");
							jQuery("#contactFormEmail_' . $id . '").removeClass("error");
							jQuery("#contactFormText_' . $id . '").removeClass("error");


							result = jQuery.parseJSON(data);
							jQuery.each(result, function(index, value) {


								if(index=="global" && value==true){
								    jQuery("#successMsg_'.$id.'").show();
								    jQuery("#contactForm_' . $id.'").find("input:not(.btn), textarea").attr("value", "");
								}
								if(index=="global" && value==false){

									jQuery("#errorMsg_'.$id.'").show();
								}
								if(index=="email" && value==false){
									jQuery("#contactFormEmail_' . $id . '").addClass("error");
								}
								if(index=="text" && value==false){
									jQuery("#contactFormText_' . $id . '").addClass("error");
								}
								if(index=="name" && value==false){
									jQuery("#contactFormName_' . $id . '").addClass("error");
								}
							});


						},
						error: function (MLHttpRequest, textStatus, errorThrown){

							jQuery("#contactFormName_' . $id . '").removeClass("error");
							jQuery("#contactFormEmail_' . $id . '").removeClass("error");
							jQuery("#contactFormText_' . $id . '").removeClass("error");
							jQuery("#successMsg_'.$id.'").hide();
							jQuery("#errorMsg_'.$id.'").show();
						}




					})
					return false;
				});
			});';
    }

    /**
     * Returns optionally placeholder
     * @param bool $show
     * @param string $name
     * @return string
     */
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

            'header' => array('label' => __("header text", 'ct_theme'), 'default' => __('Email us', 'ct_theme'), 'type' => 'input'),
            'label_name' => array('label' => __("label name", 'ct_theme'), 'default' => __('Your name', 'ct_theme'), 'type' => 'input'),
            'label_email' => array('label' => __("label email", 'ct_theme'), 'default' => __('E-mail address', 'ct_theme'), 'type' => 'input'),
            'label_message' => array('label' => __("label message", 'ct_theme'), 'default' => __('Your message', 'ct_theme'), 'type' => 'input'),
            'placeholder_name' => array('label' => __('name', 'ct_theme'), 'default' => __('enter your name', 'ct_theme'), 'type' => 'input', 'help' => __("Name field placeholder", 'ct_theme')),
            'placeholder_email' => array('label' => __('email', 'ct_theme'), 'default' => __('enter your e-mail address', 'ct_theme'), 'type' => 'input', 'help' => __("Email field placeholder", 'ct_theme')),
            'placeholder_message' => array('label' => __('message', 'ct_theme'), 'default' => __('type your message', 'ct_theme'), 'type' => 'input', 'help' => __("Message field placeholder", 'ct_theme')),
            'placeholders' => array('default' => 'yes', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no'), 'label' => __('Show placeholders?', 'ct_theme'), 'help' => __("Placeholders are labels inside inputs which disappear when content is entered", 'ct_theme')),
            'buttontext' => array('label' => __("Button text", 'ct_theme'), 'default' => __('Send Message', 'ct_theme'), 'type' => 'input'),
            'success' => array('default' => __('Thank You!', 'ct_theme'), 'type' => 'input', 'help' => __("Success message", 'ct_theme')),
            'fail' => array('label' => __('error', 'ct_theme'), 'default' => __('An error occured. Please try again.', 'ct_theme'), 'type' => 'input', 'help' => "Error message"),
            'mailto' => array('label' => __('mail to', 'ct_theme'), 'default' => get_bloginfo('admin_email'), 'type' => 'input', 'help' => __("Email address", 'ct_theme')),
            'subject' => array('label' => __('subject', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Subject of the admin mail", 'ct_theme')),
            'easy_box' => array('default' => 'yes', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no'), 'label' => __('Show easybox?', 'ct_theme'), 'help' => __("Show easybox", 'ct_theme')),
            'class' => array('label' => __("Form Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),

        );
    }
}

new ctContactFormShortcode();

function ContactFormAjax() {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $text = $_POST['text'];
    $mailto = $_POST['mailto'];
    $subject = $_POST['subject'];
    //$phone = $_POST['phone'];

    //validation
    $errs = array();
    if (!is_email($email)) {
        $errs['global'] = false;
        $errs['email'] = false;
    }
    if (!$text) {
        $errs['global'] = false;
        $errs['text'] = false;
    }
    if (!$name) {
        $errs['global'] = false;
        $errs['name'] = false;
    }
    if ($errs) {
        die(json_encode($errs));
    }

    //message
    $message = __("Email", 'ct_theme') . ": " . $email . "<br/>";
    $message .= $name ? (__("Name", 'ct_theme') . ": " . $name . "<br/>") : '';
    //$message .= $phone ? (__("Phone", 'ct_theme') . ": " . $phone . "<br/>") : '';
    $message .= (__("Content", 'ct_theme') . ": " . $text . "<br/>");

    $headers_mail = "From: Contact form <" . esc_attr($email) . "> \r\n";

    if (is_email($mailto)) {
        add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));

        if (wp_mail($mailto, $subject, $message, $headers_mail)) {
            $errs['global'] = true;
        }
    } else {
        $errs['global'] = false;

    }
    die(json_encode($errs));

}

add_action('wp_ajax_nopriv_ContactFormAjax', 'ContactFormAjax');
add_action('wp_ajax_ContactFormAjax', 'ContactFormAjax');