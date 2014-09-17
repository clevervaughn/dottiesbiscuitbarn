<?php


$sections[] = array(
	'icon' => NHP_OPTIONS_URL . 'img/glyphicons/glyphicons_100_font.png',
	'title' => __('Font', 'ct_theme'),
	'group' => __("Style", 'ct_theme'),
	'fields' => array(
		array(
			'id' => 'style_font_style',
			'title' => __("Font style", 'ct_theme'),
			'type' => 'google_webfonts',
			'options' => array("Arial" => "Arial")
		),

		array(
			'id' => 'style_font_size',
			'type' => 'text',
			'std' => '14',
			'title' => __('Default font size (px)', 'ct_theme'),
		),
		array(
			'id' => 'style_font_size_h1',
			'type' => 'text',
			'std'=>'45',
			'title' => __('H1 font size (px)', 'ct_theme'),
		),
		array(
			'id' => 'style_font_size_h2',
			'type' => 'text',
			'std'=>'40',
			'title' => __('H2 font size (px)', 'ct_theme'),
		), array(
			'id' => 'style_font_size_h3',
			'type' => 'text',
			'std'=>'35',
			'title' => __('H3 font size (px)', 'ct_theme'),
		),
		array(
			'id' => 'style_font_size_h4',
			'type' => 'text',
			'std'=>'25',
			'title' => __('H4 font size (px)', 'ct_theme'),
		),
		array(
			'id' => 'style_font_size_h5',
			'type' => 'text',
			'std'=>'25',
			'title' => __('H5 font size (px)', 'ct_theme'),
		),
		array(
			'id' => 'style_font_size_h6',
			'type' => 'text',
			'std'=>'20',
			'title' => __('H6 font size (px)', 'ct_theme'),
		)
	)
);