<?php
/**
 *
 * @author alex
 */

class ctCustomizeManagerHandler {

	/**
	 *
	 */
	public function __construct() {
		add_action('customize_register', array($this, 'customizeRegister'), 20);
		add_theme_support('custom-background', array('wp-head-callback' => array($this, 'wpHeadCallback')));
	}

	/**
	 * Customize theme preview
	 * @param WP_Customize_Manager $wp_manager
	 * @return \WP_Customize_Manager
	 */

	public function customizeRegister($wp_manager) {

        $wp_manager->add_section( 'backgrounds_section' , array(
            'title'       => __( 'Backgrounds', 'themeslug' ),
            'priority'    => 30,
            'description' => 'Upload a custom background',
        ) );
        $wp_manager->add_setting( 'top_bg1', array('type' => 'theme_mod'));
        $wp_manager->add_control( new WP_Customize_Image_Control( $wp_manager, 'top_bg1', array(
            'label'    => __( 'Top background 1', 'themeslug' ),
            'section'  => 'backgrounds_section',
            'settings' => 'top_bg1',

        ) ) );

        $wp_manager->add_setting( 'top_bg2', array('type' => 'theme_mod') );
        $wp_manager->add_control( new WP_Customize_Image_Control( $wp_manager, 'top_bg2', array(
            'label'    => __( 'Top background 2', 'themeslug' ),
            'section'  => 'backgrounds_section',
            'settings' => 'top_bg2',

        ) ) );

        $wp_manager->add_setting( 'top_bg3', array('type' => 'theme_mod') );
        $wp_manager->add_control( new WP_Customize_Image_Control( $wp_manager, 'top_bg3', array(
            'label'    => __( 'Top background 3', 'themeslug' ),
            'section'  => 'backgrounds_section',
            'settings' => 'top_bg3',

        ) ) );

        $wp_manager->add_setting( 'top_bg4', array('type' => 'theme_mod') );
        $wp_manager->add_control( new WP_Customize_Image_Control( $wp_manager, 'top_bg4', array(
            'label'    => __( 'Top background 4', 'themeslug' ),
            'section'  => 'backgrounds_section',
            'settings' => 'top_bg4',

        ) ) );

        $wp_manager->add_setting( 'footer_bg1', array('type' => 'theme_mod') );
        $wp_manager->add_control( new WP_Customize_Image_Control( $wp_manager, 'footer_bg1', array(
            'label'    => __( 'Footer background 1', 'themeslug' ),
            'section'  => 'backgrounds_section',
            'settings' => 'footer_bg1',

        ) ) );

        $wp_manager->add_setting( 'footer_bg2', array('type' => 'theme_mod') );
        $wp_manager->add_control( new WP_Customize_Image_Control( $wp_manager, 'footer_bg2', array(
            'label'    => __( 'Footer background 2', 'themeslug' ),
            'section'  => 'backgrounds_section',
            'settings' => 'footer_bg2',

        ) ) );

		return $wp_manager;
	}

	public function wpHeadCallback() {
		require_once CT_THEME_SETTINGS_MAIN_DIR . '/custom_style.php';

	}

}?>
