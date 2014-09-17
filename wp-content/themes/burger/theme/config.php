<?php
register_nav_menus(array(
	'breadcrumbs' => __('Breadcrumbs Navigation', 'ct_theme'),
));

register_nav_menus(array(
    'nav_sticky_left' => __('Sticky left', 'ct_theme'),
));

register_nav_menus(array(
    'nav_sticky_right' => __('Sticky right', 'ct_theme'),
));

register_nav_menus(array(
    'nav_standard' => __('Standard navigation', 'ct_theme'),
));


// Register widgetized areas
register_sidebar(array(
	'name' => __('Primary Sidebar', 'ct_theme'),
	'id' => 'sidebar-primary',
	'description'=>__('Widgets placed in this area will appear on your Blog sidebar','ct_theme'),
	'before_widget' => '<section id="%1$s" class="widget-inner %2$s"><div class="widget">',
	'after_widget' => '</div></section>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
));

register_sidebar(array(
	'name' => __('Footer column 1', 'ct_theme'),
	'id' => 'sidebar-footer1',
	'description'=>__('Widgets placed in this area will appear at the bootm of the page (footer) on the left hand side.','ct_theme'),
	'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
	'after_widget' => '</div></section>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
));

register_sidebar(array(
	'name' => __('Footer column 2', 'ct_theme'),
	'id' => 'sidebar-footer2',
	'description'=>__('Widgets placed in this area will appear at the bootm of the page (footer) in the center.','ct_theme'),
	'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
	'after_widget' => '</div></section>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
));

register_sidebar(array(
	'name' => __('Footer column 3', 'ct_theme'),
	'id' => 'sidebar-footer3',
	'description'=>__('Widgets placed in this area will appear at the bootm of the page (footer) on the right hand side.','ct_theme'),
	'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-inner">',
	'after_widget' => '</div></section>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
));