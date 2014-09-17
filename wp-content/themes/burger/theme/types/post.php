<?php
require_once CT_THEME_LIB_DIR . '/types/ctPostTypeBase.class.php';

/**
 * post type
 */

class ctPostType extends ctPostTypeBase {

	/**
	 * Adds meta box
	 */

	public function addMetaBox() {
		parent::addMetaBox();
		add_meta_box("post-template-meta", __("Template settings", 'ct_theme'), array($this, "postTemplateMeta"), "post", "normal", "high");
	}

	/**
	 * post template settings
	 */

	public function postTemplateMeta() {
		global $post;
		$custom = get_post_custom($post->ID);
		$title = isset($custom["show_title"][0]) ? $custom["show_title"][0] : "";
		$bread = isset($custom["show_breadcrumbs"][0]) ? $custom["show_breadcrumbs"][0] : "";

		$imageSize = isset($custom["image_size"][0]) ? $custom["image_size"][0] : "";
		?>
	<p>
        <label for="show_title"><?php _e('Show title', 'ct_theme')?>: </label>
        <select id="show_title" name="show_title">
	        <option value="global" <?php echo selected('global', $title)?>><?php _e("use global settings", 'ct_theme')?></option>
            <option value="yes" <?php echo selected('yes', $title)?>><?php _e("show title", 'ct_theme')?></option>
            <option value="no" <?php echo selected('no', $title)?>><?php _e("hide title", 'ct_theme')?></option>
        </select>
    </p>
    <p class="howto"><?php _e("Show page title?", 'ct_theme')?></p>

	<p>
        <label for="show_breadcrumbs"><?php _e('Show breadcrumbs', 'ct_theme')?>: </label>
        <select id="show_breadcrumbs" name="show_breadcrumbs">
	        <option value="global" <?php echo selected('global', $bread)?>><?php _e("use global settings", 'ct_theme')?></option>
            <option value="yes" <?php echo selected('yes', $bread)?>><?php _e("show breadcrumbs", 'ct_theme')?></option>
            <option value="no" <?php echo selected('no', $bread)?>><?php _e("hide breadcrumbs", 'ct_theme')?></option>
        </select>
    </p>
    <p class="howto"><?php _e("Show breadcrumbs?", 'ct_theme')?></p>

	<?php
	}


	public function saveDetails() {
		parent::saveDetails();
		global $post;

		$fields = array('show_title', 'show_breadcrumbs');
		foreach ($fields as $field) {
			if (isset($_POST[$field])) {
				update_post_meta($post->ID, $field, $_POST[$field]);
			}
		}
	}
}

new ctPostType();