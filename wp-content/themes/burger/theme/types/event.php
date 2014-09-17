<?php
require_once CT_THEME_LIB_DIR . '/types/ctTypeBase.class.php';


/**
 * Custom type - event
 */
class ctEventType extends ctTypeBase
{


    /**
     * Slug option name
     */

    const OPTION_SLUG = 'event_index_slug';

    /**
     * Initializes events
     * @return mixed|void
     */

    public function init() {
        add_action('template_redirect', array($this, 'eventContextFixer'));

        $this->registerType();
        $this->registerTaxonomies();

        add_action("admin_init", array($this, "addMetaBox"));

        /** @var $NHP_Options NHP_Options */
        global $NHP_Options;
        //add options listener for license
        add_action('nhp-opts-options-validate-' . $NHP_Options->args['opt_name'], array($this, 'handleSlugOptionSaved'));
    }

    /**
     * Adds meta box
     */

    public function addMetaBox() {
        add_meta_box("event-meta", __("Event settings", 'ct_theme'), array($this, "eventMeta"), "event", "normal", "high");
        add_action('save_post', array($this, 'saveDetails'));
    }

    /**
     * Fixes proper menu state
     */

    public function eventContextFixer() {
        if (get_query_var('post_type') == 'event') {
            global $wp_query;
            $wp_query->is_home = false;
        }
        if (get_query_var('taxonomy') == 'event_category') {
            global $wp_query;
            $wp_query->is_404 = true;
            $wp_query->is_tax = false;
            $wp_query->is_archive = false;
        }
    }

    /**
     * Register type
     */

    protected function registerType() {
        $typeData = $this->callFilter('pre_register_type', array(
            'labels' => array(
                'name' => _x('Event items', 'post type general name', 'ct_theme'),
                'singular_name' => _x('Event items Item', 'post type singular name', 'ct_theme'),
                'add_new' => _x('Add New', 'event items', 'ct_theme'),
                'add_new_item' => __('Add New Event Item', 'ct_theme'),
                'edit_item' => __('Edit Event Item', 'ct_theme'),
                'new_item' => __('New Event Item', 'ct_theme'),
                'view_item' => __('View Event Item', 'ct_theme'),
                'search_items' => __('Search Event Items', 'ct_theme'),
                'not_found' => __('No Event item found', 'ct_theme'),
                'not_found_in_trash' => __('No Event items found in Trash', 'ct_theme'),
                'parent_item_colon' => '',
                'menu_name' => __('Event items', 'ct_theme'),
            ),
            'singular_label' => __('event', 'ct_theme'),
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            //'menu_position' => 20,
	        'menu_icon'=>'dashicons-calendar',
            'capability_type' => 'post',
            'hierarchical' => false,
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'page-attributes'),
            'has_archive' => false,
            'rewrite' => array('slug' => $this->getPermalinkSlug(), 'with_front' => true, 'pages' => true, 'feeds' => false),
            'query_var' => false,
            'can_export' => true,
            'show_in_nav_menus' => true,
            'taxonomies' => array('post_tag')
        ));

        register_post_type('event', $typeData);
        $this->callHook('post_register_type');
    }

    /**
     * Returns permalink slug
     * @return string
     */

    protected function getPermalinkSlug() {
        // Rewriting Permalink Slug
        $permalink_slug = ct_get_option('event', 'event');
        if (empty($permalink_slug)) {
            $permalink_slug = 'event';
        }

        return $permalink_slug;
    }

    /**
     * Gets hook name
     * @return string
     */
    protected function getHookBaseName() {
        return 'ct_event';
    }

    /**
     * Creates taxonomies
     */

    protected function registerTaxonomies() {
        $data = $this->callFilter('pre_register_taxonomies', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x('Event Categories', 'taxonomy general name', 'ct_theme'),
                'singular_name' => _x('Event Category', 'taxonomy singular name', 'ct_theme'),
                'search_items' => __('Search Categories', 'ct_theme'),
                'popular_items' => __('Popular Categories', 'ct_theme'),
                'all_items' => __('All Categories', 'ct_theme'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __('Edit Event Category', 'ct_theme'),
                'update_item' => __('Update Event Category', 'ct_theme'),
                'add_new_item' => __('Add New Event Category', 'ct_theme'),
                'new_item_name' => __('New Event Category Name', 'ct_theme'),
                'separate_items_with_commas' => __('Separate Event category with commas', 'ct_theme'),
                'add_or_remove_items' => __('Add or remove event category', 'ct_theme'),
                'choose_from_most_used' => __('Choose from the most used event category', 'ct_theme'),
                'menu_name' => __('Categories', 'ct_theme'),
            ),
            'public' => false,
            'show_in_nav_menus' => false,
            'show_ui' => true,
            'show_tagcloud' => false,
            'query_var' => 'event_category',
            'rewrite' => false,

        ));
        register_taxonomy('event_category', 'event', $data);
        $this->callHook('post_register_taxonomies');
    }


    /**
     * Gets display method for event
     * @param array $meta - post meta
     * @return null|string
     */
    public static function getMethodFromMeta($meta) {
        $method = isset($meta['display_method']) ? $meta['display_method'][0] : null;
        if (!$method) {
            $method = isset($meta['video'][0]) && trim($meta['video'][0]) ? 'video' : 'image';
        }
        return $method;
    }

    /**
     * Handles rebuild
     */

    public function handleSlugOptionSaved($newValues) {
        $currentSlug = $this->getPermalinkSlug();
        //rebuild rewrite if new slug
        if (isset($newValues[self::OPTION_SLUG]) && ($currentSlug != $newValues[self::OPTION_SLUG])) {
            $this->callHook('pre_slug_option_saved', array('current_slug' => $currentSlug, 'new_slug' => $newValues[self::OPTION_SLUG]));

            //clean rewrite to refresh it
            delete_option('rewrite_rules');
        }
    }



    /**
     * Draw s event meta
     */

    public function eventMeta()
    {
        global $post;
        $currentDate = getDate();
        $custom = get_post_custom($post->ID);

        $subtitle = isset($custom["subtitle"][0]) ? $custom["subtitle"][0] : "";
        $date = isset($custom["date"][0]) ? $custom["date"][0] : "";
        $amap = isset($custom["amap"][0]) ? $custom["amap"][0] : "";

        /*is amap iframe?*
        preg_match('/src="([^"]+)"/', $amap, $match);
        if ($match == null){
            $amap.= '&output=embed?iframe=true&width=640&height=480';
        }else{
            $amap = $match[1].'?iframe=true&width=640&height=480';
        }
        */


        if ($supportsRevolutionSlider = function_exists('rev_slider_shortcode')) {
            global $wpdb;
            $slides = $wpdb->get_results("SELECT * FROM wp_revslider_sliders");
        }
        ?>
        <p>
            <label for="subtitle"><?php _e('Subtitle', 'ct_theme') ?>: </label>
            <input id="subtitle" class="regular-text" name="subtitle" value="<?php echo $subtitle; ?>"/>
        <p class="howto"><?php _e("Event subtitle", 'ct_theme') ?></p>


        <p>
            <label for="date"><?php _e('Date', 'ct_theme') ?>: </label>
            <input type="date" id="date" class="regular-text" name="date" value="<?php echo $date; ?>"/>
        <p class="howto"><?php _e("Enter date", 'ct_theme') ?></p>

        <p>
            <label for="amap"><?php _e('Google maps link', 'ct_theme') ?>: </label>
            <input type="input" id="amap" class="regular-text" name="amap" value="<?php echo htmlspecialchars($amap); ?>"/>
        <p class="howto"><?php echo htmlspecialchars(__("Please insert a emdebed Google Map code e.g. (<iframe>...</iframe>)", 'ct_theme'), ENT_QUOTES) ?></p>


    <?php
    }

    /**
     * event template settings
     */

    public function eventTemplateMeta()
    {
        global $post;
        $custom = get_post_custom($post->ID);

    }


    public function saveDetails()
    {
        global $post;

        $fields = array('subtitle', 'date', 'amap');




        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post->ID, $field, $_POST[$field]);
            }
        }
    }
}

new ctEventType();