<?php
require_once get_template_directory() . '/framework/createit/ctThemeLoader.php';

$c = new ctThemeLoader();
$c->setPrepackedChildThemes(array('badassbbq', 'bigsmokebbq', 'coffeecream', 'cupcake', 'pizza', 'ribsndogs', 'seabreeze', 'tacos', 'waffle'));
$c->init('foodtruck');

function roots_setup() {


	// Make theme available for translation
	load_theme_textdomain('ct_theme', get_template_directory() . '/lang');

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support('automatic-feed-links');

	// Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
	add_theme_support('post-thumbnails');

	add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));

	add_theme_support('custom-header');

	add_theme_support('custom-background');

	//add size for post items
	add_image_size('thumb_square', 240, 210, true);

	//add size for featured image
	add_image_size('featured_image', 541, 256, true);

	//menu box
	add_image_size('product_thumb', 54, 54, true);

	//product box
	add_image_size('product_box', 260, 132, true);

	//product box seabreeze
	add_image_size('product_box_2', 174, 174, true);


	//gallery
	add_image_size('gallery_thumb_2', 570, 350, true);
	add_image_size('gallery_thumb_3', 370, 227, true);
	add_image_size('gallery_thumb_4', 270, 166, true);
	add_image_size('gallery_thumb_6', 170, 104, true);

    //add size for featured image - blog - related posts
    add_image_size('featured_image_related_posts', 213, 126, true);

    require_once CT_THEME_SETTINGS_MAIN_DIR . '/options/ctCustomizeManagerHandler.class.php';
    new ctCustomizeManagerHandler();

}



add_action('after_setup_theme', 'roots_setup');

/**
 * Fixes 1 Click demo import when invalid data was imported
 */

function ct_fix_invalid_menus() {
	$key = 'theme_mods_' . get_stylesheet();
	if (!is_array(get_option($key))) {
		update_option($key, array());
	}
}

add_action('after_switch_theme', 'ct_fix_invalid_menus', 10);


require_once 'theme/theme_functions.php';







