<?php
$sections[] = array(
    'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_280_settings.png',
    'group' => __("General", 'ct_theme'),
    'title' => __('Main', 'ct_theme'),
    'desc' => __('Main settings', 'ct_theme'),
    'fields' => array(

        array(
            'id' => 'navbar_type',
            'title' => __("Navigation bar type", 'ct_theme'),
            'type' => 'select',
            'options' => array('sticky' => "sticky", 'standard' => "standard"),
            'std' => 'standard'
        ),

        array(
            'id' => 'navbar_margin_top',
            'type' => 'text',
            'title' => __('Navbar top margin', 'ct_theme'),
            'desc' => __('Add any top margin (may be negative to pull navbar to the top)', 'ct_theme'),
            'std'=>'140'
        ),



        array(
            'id' => 'general_logo_small',
            'type' => 'upload',
	        'show_dimensions' => false,
            'title' => __('Standard Logo / Logo Small Sticky', 'ct_theme'),
            'desc' => __("Shows up in standard menu or after scroll in sticky menu.", 'ct_theme')
        ),
        array(
            'id' => 'general_logo_small_margin_top',
            'type' => 'text',
            'title' => __('Standard Logo / Logo Small Sticky top margin', 'ct_theme'),
            'desc' => __('Add any top margin (may be negative to pull logo to the top)', 'ct_theme')
        ),

        array(
            'id' => 'general_logo_small_margin_left',
            'type' => 'text',
            'title' => __('Standard Logo / Logo Small Sticky left  margin', 'ct_theme'),
            'desc' => __('Add any left margin (negavtive value will move logo to the left)', 'ct_theme')
        ),
        array(
            'id' => 'general_logo_small_html',
            'type' => 'textarea',
            'title' => __('Standard Logo / Logo Small Sticky html', 'ct_theme'),
            'desc' => __("You can enter any HTML which will be displayed in place of logo small. If image logo is uploaded, it will be displayed instead.", 'ct_theme')
        ),



        array(
            'id' => 'general_logo',
            'type' => 'upload',
	        'show_dimensions' => false,
            'title' => __('Logo Sticky', 'ct_theme'),
            'desc' => __("Shows up after loading the page. Changes to Logo small after scroll.", 'ct_theme')
        ),
        array(
            'id' => 'general_logo_margin_top',
            'type' => 'text',
            'title' => __('Logo Sticky top margin', 'ct_theme'),
            'desc' => __('Add any top margin (may be negative to pull logo to the top)', 'ct_theme')
        ),
        array(
            'id' => 'general_logo_margin_left',
            'type' => 'text',
            'title' => __('Logo Sticky left  margin', 'ct_theme'),
            'desc' => __('Add any left margin (negavtive value will move logo to the left)', 'ct_theme')
        ),

        array(
            'id' => 'general_logo_html',
            'type' => 'textarea',
            'title' => __('Logo Sticky html', 'ct_theme'),
            'desc' => __("You can enter any HTML which will be displayed in place of logo. If image logo is uploaded, it will be displayed instead.", 'ct_theme')
        ),





        array(
            'id' => 'general_logo_mobile',
            'type' => 'upload',
	        'show_dimensions' => false,
            'title' => __('Mobile logo', 'ct_theme'),
            'desc' => __("Shows up on mobile devices.", 'ct_theme')
        ),
        array(
            'id' => 'general_logo_mobile_margin_top',
            'type' => 'text',
            'title' => __('Logo Mobile top margin', 'ct_theme'),
            'desc' => __('Add any top margin (may be negative to pull logo to the top)', 'ct_theme')
        ),
        array(
            'id' => 'general_logo_mobile_margin_left',
            'type' => 'text',
            'title' => __('Logo Mobile left  margin', 'ct_theme'),
            'desc' => __('Add any left margin (negavtive value will move logo to the left)', 'ct_theme')
        ),
        array(
            'id' => 'general_logo_mobile_html',
            'type' => 'textarea',
            'title' => __('Logo Mobile html', 'ct_theme'),
            'desc' => __("You can enter any HTML which will be displayed in place of logo. If image logo is uploaded, it will be displayed instead.", 'ct_theme')
        ),






        array(
            'id' => 'general_mobile_phone',
            'type' => 'text',
            'title' => __('Mobile devices phone number', 'ct_theme'),
            'desc' => __('Telephone number.', 'ct_theme')
        ),
        array(
            'id' => 'general_mobile_map',
            'type' => 'text',
            'title' => __('Mobile devices map link', 'ct_theme'),
            'desc' => __('Map link. If you are using Foodtruck Locator, your address can be automatically updated - use %foodtruck_locator_address% instead of fixed address, %foodtruck_locator_lat% for current latitude, %foodtruck_locator_lng% for current longitude', 'ct_theme')
        ),
        array(
            'id' => 'general_login_logo',
            'type' => 'upload',
            'title' => __('Login logo', 'ct_theme'),
            'desc' => __('Choose icon, which be displayed after loading login window.', 'ct_theme')
        ),
        array(
            'id' => 'general_favicon',
            'type' => 'upload',
            'title' => __('Favicon', 'ct_theme'),
            'desc' => __('Choose icon, which be displayed in the address bar of browser.', 'ct_theme'),
        ),
        array(
            'id' => 'general_apple_touch_icon',
            'type' => 'upload',
            'title' => __('Apple touch icon', 'ct_theme'),
        ),
        array(
            'id' => 'general_header_text',
            'type' => 'text',
            'title' => __('Header text', 'ct_theme'),
            'desc' => __('Above header text', 'ct_theme')
        ),
        array(
            'id' => 'general_footer_text',
            'type' => 'text',
            'title' => __('Footer text', 'ct_theme'),
            'desc' => __("Available data: %year% (current year), %name% (site name)", 'ct_theme'),
            'std' => "&copy; %year% %name%"
        ),
        array(
            'id' => 'general_show_preloader',
            'title' => __("Show preloader", 'ct_theme'),
            'type' => 'select_show',
            'std' => 0
        ),
    )
);

$sections[] = array(
    'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_242_google_maps.png',
    'group' => __("General", 'ct_theme'),
    'title' => __('FoodTruck Locator', 'ct_theme'),
    'desc' => __('Set your current location with one click. Below you will find a link which you can bookmark on your phone. When opened on GPS enabled device, FoodTruck will store your current location and update your map.<br>Please don\'t forget to use <strong>[google_maps foodtruck_locator="yes"]</strong> shortcode to render google maps with your current position.', 'ct_theme'),
    'fields' => array(
        array(
            'id' => 'general_location_secret',
            'type' => 'text',
            'title' => __('Secret token used to secure FoodTruck Locator link', 'ct_theme'),
            'desc' => __('This token is required to secure your request. Just make sure it is not empty ...','ct_theme'),
            'std' => md5(time() . rand(100, 10000)),
        ),
        array(
            'id' => 'general_location_secret_link',
            'type' => 'info',
            'option' => 'general_location_secret',
            'desc' => 'Use this link to quickly set current location (or scan QR code below): <a href="' . CT_THEME_DIR_URI . '/location.php?k=' . '%value%">' . CT_THEME_DIR_URI . '/location.php?k=%value%</a>',
        ),
        array(
            'id' => 'general_location_secret_qrcode',
            'type' => 'qrcode',
            'option' => 'general_location_secret',
            'option_template' => CT_THEME_DIR_URI . '/location.php?k=%option%',
        )
    )
);

$sections[] = array(
    'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_001_leaf.png',
    'group' => __("General", 'ct_theme'),
    'title' => __('Automatic Update', 'ct_theme'),
    'desc' => __('Automatic theme update will check every 12 hours for any new theme updates. A notification in Themes menu will appear (just like any other update info).<br/>In order for automatic updates to work, license key is required. <br/><strong>All your settings will be saved</strong>.<br/><br/><strong>WARNING</strong><br/>If you modified source code, it will be overwritten!', 'ct_theme'),
    'fields' => array(
        array(
            'id' => 'general_envato_license',
            'type' => 'text',
            'title' => __('Envato license', 'ct_theme'),
            'desc' => '<a target="_blank" href="http://outsourcing.createit.pl/envato_license.html">' . __('Click here for instructions how to find license', 'ct_theme') . '</a>'
        ))
);