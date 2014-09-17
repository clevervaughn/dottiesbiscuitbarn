<?php
$sections[] = array(
	'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_151_edit.png',
	'title' => __('Single', 'ct_theme'),
	'group' => __("Event", 'ct_theme'),
	'desc' => __("Setup single post settings", 'ct_theme'),
	'fields' => array(
        array(
            'id' => 'event_single_page_title',
            'title' => __("Single event page title", 'ct_theme'),
            'type' => 'text',
        ),
        array(
            'id' => 'event_single_show_title',
            'title' => __("Title", 'ct_theme'),
            'type' => 'select_show',
            'std' => 0
        ),
        array(
            'id' => 'event_single_show_breadcrumbs',
            'title' => __("Show breadcrumbs", 'ct_theme'),
            'type' => 'select_show',
            'std' => 1
        ),
        array(
            'id' => 'event_show_featured_image',
            'title' => __("Show featured image", 'ct_theme'),
            'type' => 'select_show',
            'std' => 0
        ),





	)
);
