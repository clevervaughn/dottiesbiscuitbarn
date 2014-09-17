<?php
require_once 'ctTypeBase.class.php';
/**
 * Person type handler
 * @author alex
 */

class ctPersonTypeBase extends ctTypeBase {

    /**
     * Slug option name
     */

    const OPTION_SLUG = 'person_index_slug';

    /**
     * Initializes events
     * @return mixed|void
     */

    public function init() {
        add_action('template_redirect', array($this, 'personContextFixer'));

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
        add_meta_box("person-meta", __("Person settings", 'ct_theme'), array($this, "personMeta"), "person", "normal", "high");
        add_action('save_post', array($this, 'saveDetails'));
    }

    /**
     * Fixes proper menu state
     */

    public function personContextFixer() {
        if (get_query_var('post_type') == 'person') {
            global $wp_query;
            $wp_query->is_home = false;
        }
        if (get_query_var('taxonomy') == 'person_category') {
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
                'name' => _x('Persons', 'post type general name', 'ct_theme'),
                'singular_name' => _x('Person', 'post type singular name', 'ct_theme'),
                'add_new' => _x('Add New', 'person', 'ct_theme'),
                'add_new_item' => __('Add New Person', 'ct_theme'),
                'edit_item' => __('Edit Person', 'ct_theme'),
                'new_item' => __('New Person', 'ct_theme'),
                'view_item' => __('View Person', 'ct_theme'),
                'search_items' => __('Search Person', 'ct_theme'),
                'not_found' => __('No person found', 'ct_theme'),
                'not_found_in_trash' => __('No person found in Trash', 'ct_theme'),
                'parent_item_colon' => '',
                'menu_name' => __('Person', 'ct_theme'),
            ),
            'singular_label' => __('person', 'ct_theme'),
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            //'menu_position' => 20,
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

        register_post_type('person', $typeData);
        $this->callHook('post_register_type');
    }

    /**
     * Returns permalink slug
     * @return string
     */

    protected function getPermalinkSlug() {
        // Rewriting Permalink Slug
        $permalink_slug = ct_get_option('person_index_slug', 'person');
        if (empty($permalink_slug)) {
            $permalink_slug = 'person';
        }

        return $permalink_slug;
    }

    /**
     * Gets hook name
     * @return string
     */
    protected function getHookBaseName() {
        return 'ct_person';
    }

    /**
     * Creates taxonomies
     */

    protected function registerTaxonomies() {
        $data = $this->callFilter('pre_register_taxonomies', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => _x('Person Categories', 'taxonomy general name', 'ct_theme'),
                'singular_name' => _x('Person Category', 'taxonomy singular name', 'ct_theme'),
                'search_items' => __('Search Categories', 'ct_theme'),
                'popular_items' => __('Popular Categories', 'ct_theme'),
                'all_items' => __('All Categories', 'ct_theme'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __('Edit Person Category', 'ct_theme'),
                'update_item' => __('Update Person Category', 'ct_theme'),
                'add_new_item' => __('Add New Person Category', 'ct_theme'),
                'new_item_name' => __('New Person Category Name', 'ct_theme'),
                'separate_items_with_commas' => __('Separate Person category with commas', 'ct_theme'),
                'add_or_remove_items' => __('Add or remove person category', 'ct_theme'),
                'choose_from_most_used' => __('Choose from the most used person category', 'ct_theme'),
                'menu_name' => __('Categories', 'ct_theme'),
            ),
            'public' => false,
            'show_in_nav_menus' => false,
            'show_ui' => true,
            'show_tagcloud' => false,
            'query_var' => 'person_category',
            'rewrite' => false,

        ));
        register_taxonomy('person_category', 'person', $data);
        $this->callHook('post_register_taxonomies');
    }


    /**
     * Draw s person meta
     */

    public function personMeta() {
        global $post;
        $custom = get_post_custom($post->ID);
        $name = isset($custom["name"][0]) ? $custom["name"][0] : "";
        $surname = isset($custom["surname"][0]) ? $custom["surname"][0] : "";


        ?>
        <p>
            <label for="name"><?php _e('Name', 'ct_theme')?>: </label>
            <input id="name" class="regular-text" name="name" value="<?php echo $name; ?>"/>
        </p>

        <p>
            <label for="surname"><?php _e('surname', 'ct_theme')?>: </label>
            <input id="surname" class="regular-text" name="surname" value="<?php echo $surname; ?>"/>
        </p>
    <?php
    }

    public function saveDetails() {
        global $post;

        $fields = array('name', 'surname');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post->ID, $field, $_POST[$field]);
            }
        }
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
}
