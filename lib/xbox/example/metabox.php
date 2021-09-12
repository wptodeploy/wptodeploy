<?php

add_action( 'xbox_init', 'my_simple_metabox');
function my_simple_metabox(){
	$options = array(
		'id' => 'my-simple-metabox',
		'title' => 'Simple Metaboxs',
		'post_types' => array('post', 'page'),
		'layout' => 'wide',//boxed
		'fields_prefix' => 'pre_',
		'header' => array()
	);

	$xbox = xbox_new_metabox( $options );

	$xbox->add_field(array(
		'name' => 'Header slogan',
		'id' => 'header-slogan',
		'type' => 'text',
		'grid' => '3-of-6',
		'desc' => '"grid" => "3-of-6"',
	));
	$xbox->add_field( array(
		'name' => 'Header info',
		'id' => 'header-info',
		'type' => 'checkbox',
		'default' => array('phone', 'address' ),
		'items' => array(
			'phone' => 'Phone number',
			'email' => 'Email',
			'address' => 'Address'
		),
		'options' => array(
			'width' => '200px',
		),
	));
	$xbox->add_field(array(
		'name' => 'Phone number',
		'id' => 'phone-number',
		'type' => 'text',
		'grid' => '2-of-8',
		'desc' => '"grid" => "2-of-8"',
	));
	$xbox->add_field(array(
		'name' => 'Email',
		'id' => 'header-email',
		'type' => 'text',
		'grid' => '3-of-8',
		'desc' => '"grid" => "3-of-8"',
	));
	$xbox->add_field(array(
		'name' => 'Address',
		'id' => 'header-addres',
		'type' => 'text',
		'grid' => '4-of-8',
		'desc' => '"grid" => "4-of-8"',
		'options' => array(
			'desc_tooltip' => true
		)
	));
}



add_action( 'xbox_init', 'my_advanced_metabox');
function my_advanced_metabox(){
	$options = array(
		'id' => 'my-advanced-metabox',
		'title' => 'Metabox',
		'post_types' => array('post', 'page'),
		'skin' => 'blue',// Skins: blue, lightblue, green, teal, pink, purple, bluepurple, yellow, orange'
		'layout' => 'boxed',//wide
		'fields_prefix' => 'xf_',
		'header' => array(
			'icon' => '<img src="'.XBOX_URL.'img/xbox-light.png"/>',
			'desc' => 'Custom description for metabox',
		),
	);

	$xbox = xbox_new_metabox( $options );

	$xbox->add_main_tab( array(
		'name' => 'Main tab',
		'id' => 'main-tab',
		'items' => array(
			'logo' => '<i class="xbox-icon xbox-icon-image"></i>Logo',
			'header' => '<i class="xbox-icon xbox-icon-arrow-up"></i>Header',
			'footer' => '<i class="xbox-icon xbox-icon-arrow-down"></i>Footer',
			'sidebar' => '<i class="xbox-icon xbox-icon-list-alt"></i>Sidebar',
			'number' => '<i class="xbox-icon xbox-icon-dollar"></i>Number',
			'textarea' => '<i class="xbox-icon xbox-icon-font"></i>Textarea',
			'wp-editor' => '<i class="xbox-icon xbox-icon-pencil"></i>Wp Editor',
			'switcher' => '<i class="xbox-icon xbox-icon-toggle-on"></i>Switcher',
			'checkbox' => '<i class="xbox-icon xbox-icon-check-square"></i>Checkbox - Radio',
			'image-selector' => '<i class="xbox-icon xbox-icon-photo"></i>Image Selector',
			'select' => '<i class="xbox-icon xbox-icon-mouse-pointer"></i>Select',
			'colorpicker' => '<i class="xbox-icon xbox-icon-eyedropper"></i>Colorpicker',
			'file' => '<i class="xbox-icon xbox-icon-upload"></i>File Upload',
			'oembed' => '<i class="xbox-icon xbox-icon-refresh"></i>Oembed',
		),
	));

		$xbox->open_tab_item('logo');
			$xbox->add_tab( array(
				'name' => 'Logo tabs',
				'id' => 'logo-tabs',
				'items' => array(
					'main-logo' => 'Main Logo & Favicon',
					'footer-logo' => 'Footer Logo',
					'mobile-logo' => 'Mobile Logo',
				),
			));
			$xbox->open_tab_item('main-logo');
				$xbox->add_field(array(
					'id' => 'default-logo',
					'name' => 'Default logo',
					'type' => 'file',
					'options' => array(
						'preview_size' => array( 'width' => '37px', 'height' => 'auto' ),
					)
				));
				$xbox->open_mixed_field(array('name' => 'Logo settings'));
					$xbox->add_field(array(
						'name' => 'Max width',
						'id' => 'logo-max-width',
						'type' => 'number',
						'default' => 160,
						'grid' => '2-of-8',
						'desc' => '"grid" => "2-of-8"',
					));
					$xbox->add_field(array(
						'name' => 'Max height',
						'id' => 'logo-max-height',
						'type' => 'number',
						'default' => 80,
						'grid' => '2-of-8',
						'desc' => '"grid" => "2-of-8"',
					));
					$xbox->add_field(array(
						'name' => 'Margin top',
						'id' => 'logo-margin-top',
						'type' => 'number',
						'default' => 40,
						'grid' => '2-of-8',
						'desc' => '"grid" => "2-of-8"',
					));
					$xbox->add_field(array(
						'name' => 'Margin left',
						'id' => 'logo-margin-left',
						'type' => 'number',
						'default' => 40,
						'grid' => '2-of-8 last',
						'desc' => '"grid" => "2-of-8 last"',
					));
				$xbox->close_mixed_field();
				$xbox->add_field(array(
					'id' => 'text-logo',
					'name' => 'Text logo',
					'type' => 'text',
					'grid' => '3-of-6',
					'desc' => '"grid" => "3-of-6"',
				));
				$xbox->add_field(array(
					'name' => 'Use text logo',
					'id' => 'use-text-logo',
					'type' => 'switcher',
					'default' => 'on',
				));
				$xbox->open_mixed_field(array('name' => 'Text logo settings'));
					$xbox->add_field( array(
						'id' => 'logo-font-family',
						'name' => __( 'Font family', 'textdomain' ),
						'type' => 'select',
						'default' => 'Open Sans',
						'items' => array(
							'Google Fonts' => XboxItems::google_fonts(),
							'Web Safe Fonts' => XboxItems::web_safe_fonts()
						),
						'options' => array(
							'sort' => 'asc',
							'search' => true,
						),
						'grid' => '2-of-8'
					));
					$xbox->add_field(array(
						'id' => 'logo-font-size',
						'name' => 'Font size',
						'type' => 'number',
						'default' => 15,
						'grid' => '2-of-8',
						'options' => array(
							'unit' => 'em'
						),
					));
					$xbox->add_field(array(
						'id' => 'logo-font-color',
						'name' => 'Font color',
						'type' => 'colorpicker',
						'default' => '#A55CFD',
						'grid' => '2-of-8'
					));
					$xbox->add_field( array(
						'id' => 'logo-text-align',
						'name' => __( 'Text align', 'textdomain' ),
						'type' => 'select',
						'default' => 'left',
						'items' => XboxItems::text_align(),
						'grid' => '2-of-8'
					));
				$xbox->close_mixed_field();
				$xbox->add_field( array(
					'id' => 'logo-position',
					'name' => 'Logo position',
					'type' => 'image_selector',
					'default' => 'left',
					'items' => array(
						'left' => XBOX_URL.'example/img/logo-position-left.png',
						'right' => XBOX_URL.'example/img/logo-position-right.png',
						'center' => XBOX_URL.'example/img/logo-position-center.png'
					),
					'options' => array(
						'width' => '155px',
					),
				));
			$xbox->close_tab_item('main-logo');

			$xbox->open_tab_item('footer-logo');
				$xbox->add_field(array(
					'id' => 'footer-logo',
					'name' => 'Footer logo',
					'type' => 'file',
					'options' => array(
						'preview_size' => array( 'width' => '37px', 'height' => 'auto' ),
					)
				));
			$xbox->close_tab_item('footer-logo');

			$xbox->open_tab_item('mobile-logo');
				$xbox->add_field(array(
					'id' => 'mobile-logo',
					'name' => 'Mobile logo',
					'type' => 'file',
					'options' => array(
						'preview_size' => array( 'width' => '37px', 'height' => 'auto' ),
					)
				));
			$xbox->close_tab_item('mobile-logo');

		$xbox->close_tab('logo-tabs');

		$xbox->close_tab_item('logo');

		$xbox->open_tab_item('header');
			$section_header_1 = $xbox->add_section( array(
				'name' => 'General Header',
				'id' => 'section-general-header',
				'options' => array(
					'toggle' => true,
				)
			));
				$section_header_1->add_field( array(
					'name' => 'Header Style',
					'id' => 'header-style',
					'type' => 'image_selector',
					'default' => 'header1',
					'items' => array(
						'header1' => XBOX_URL.'example/img/header1.png',
						'header2' => XBOX_URL.'example/img/header2.png',
						'header3' => XBOX_URL.'example/img/header3.png'
					),
					'options' => array(
						'width' => '200px',
					),
				));
				$section_header_1->add_field(array(
					'name' => 'Header slogan',
					'id' => 'header-slogan',
					'type' => 'text',
					'grid' => '3-of-6',
					'desc' => '"grid" => "3-of-6"',
					'options' => array(
						'desc_tooltip' => true
					)
				));
				$section_header_1->add_field( array(
					'name' => 'Header info',
					'id' => 'header-info',
					'type' => 'checkbox',
					'default' => array('phone', 'address' ),
					'items' => array(
						'phone' => 'Phone number',
						'email' => 'Email',
						'address' => 'Address'
					),
					'options' => array(
						'width' => '200px',
					),
				));
				$section_header_1->add_field(array(
					'name' => 'Phone number',
					'id' => 'phone-number',
					'type' => 'text',
					'grid' => '2-of-8',
					'desc' => '"grid" => "2-of-8"',
				));
				$section_header_1->add_field(array(
					'name' => 'Email',
					'id' => 'header-email',
					'type' => 'text',
					'grid' => '3-of-8',
					'desc' => '"grid" => "3-of-8"',
				));
				$section_header_1->add_field(array(
					'name' => 'Address',
					'id' => 'header-addres',
					'type' => 'text',
					'grid' => '4-of-8',
					'desc' => '"grid" => "4-of-8"',
				));
			$section_header_2 = $xbox->add_section( array(
				'name' => 'Additional Header Settings',
				'id' => 'section-general-additional',
				'options' => array(
					'toggle' => true,
				)
			));
				$section_header_2->add_field(array(
					'name' => 'Header height',
					'id' => 'header-height',
					'type' => 'number',
					'default' => 120,
					'options' => array(
						'show_spinner' => true
					)
				));
				$section_header_2->add_field(array(
					'name' => 'Sticky Header',
					'id' => 'sticky-header',
					'type' => 'switcher',
					'default' => 'on',
				));
				$section_header_2->add_field(array(
					'name' => 'Sticky Header Behavior',
					'id' => 'sticky-header-behavior',
					'type' => 'select',
					'default' => 'fixed',
					'items' => array(
						'fixed' => 'Fixed Sticky',
						'slide' => 'Slide Down',
						'lazy' => 'Lazy',
					)
				));
				$section_header_2->add_field(array(
					'name' => 'Show header top',
					'id' => 'show-header-top',
					'type' => 'radio',
					'default' => 'disable',
					'items' => array(
						'enable' => 'Enable',
						'disable' => 'Disable',
					)
				));

		$xbox->close_tab_item('header');

		$xbox->open_tab_item('footer');
			$xbox->add_field(array(
				'name' => 'Footer background image',
				'id' => 'footer-background-image',
				'type' => 'file',
			));
			$xbox->add_field(array(
				'name' => 'Footer widgets',
				'id' => 'footer-widgets',
				'type' => 'switcher',
				'default' => 'on',
				'desc' => 'Turn on to display footer widgets.',
				'options' => array(
					'desc_tooltip' => true
				)
			));
			$xbox->add_field(array(
				'name' => 'Footer Columns',
				'id' => 'footer-columns',
				'type' => 'number',
				'default' => 4,
				'desc' => 'Controls the number of columns in the footer.',
				'options' => array(
					'show_spinner' => true
				)
			));
			$xbox->add_field(array(
				'name' => 'Footer navigation',
				'id' => 'footer-navigation',
				'type' => 'switcher',
				'default' => 'off',
				'desc' => 'This option allows you to enable a custom navigation on the left section of custom footer.',
				'options' => array(
					'desc_tooltip' => true
				)
			));

			$xbox->open_mixed_field(array('name' => 'Padding footer'));
				$xbox->add_field(array(
					'name' => 'Padding top',
					'id' => 'footer-padding-top',
					'type' => 'number',
					'default' => 40,
				));
				$xbox->add_field(array(
					'name' => 'Padding right',
					'id' => 'footer-padding-right',
					'type' => 'number',
					'default' => 0,
				));
				$xbox->add_field(array(
					'name' => 'Padding bottom',
					'id' => 'footer-padding-bottom',
					'type' => 'number',
					'default' => 40,
				));
				$xbox->add_field(array(
					'name' => 'Padding left',
					'id' => 'footer-padding-left',
					'type' => 'number',
					'default' => 0,
				));
			$xbox->close_mixed_field();

			$xbox->add_field(array(
				'name' => 'Copyright bar',
				'id' => 'copyright-bar',
				'type' => 'switcher',
				'default' => 'on',
				'desc' => 'Turn on to display the copyright bar.',
				'options' => array(
					'desc_tooltip' => true
				)
			));
			$xbox->add_field(array(
				'name' => 'Copyright text',
				'id' => 'copyright-text',
				'type' => 'textarea',
				'desc' => 'Enter the text that displays in the copyright bar. HTML markup can be used.',
				'options' => array(
					'desc_tooltip' => true
				)
			));
		$xbox->close_tab_item('footer');

		$xbox->open_tab_item('sidebar');
			$sidebar = $xbox->add_group( array(
				'name' => 'Create new Sidebar',
				'id' => 'create-sidebar',
				'type' => 'group',
				'controls' => array(
					'name' => 'Name sidebar #',
					'readonly_name' => false
				)
			));
			$sidebar->add_field(array(
				'name' => 'Sidebar id',
				'id' => 'sidebar-name',
				'type' => 'text',
				'desc' => 'Sidebar id - Must be all in lowercase, with no spaces',
				'options' => array(
					'desc_tooltip' => true
				)
			));
			$sidebar->add_field(array(
				'name' => 'Sidebar description',
				'id' => 'sidebar-description',
				'type' => 'text',
				'desc' => 'Sidebar description (default is localized Sidebar and numeric ID)',
			));
			$sidebar->add_field(array(
				'name' => 'Sidebar class',
				'id' => 'sidebar-class',
				'type' => 'text',
			));
		$xbox->close_tab_item('sidebar');

		$xbox->open_tab_item('number');
			$xbox->add_field( array(
				'id' => 'number',
				'name' => 'Number',
				'type' => 'number',
				'default' => 20,
				'desc' => '"attributes" => ["min" => 0, "max" => 50]',
				'attributes' => array(
					'min' => 0,
					'max' => 50
				),
			));
			$xbox->add_field( array(
				'id' => 'number-2',
				'name' => 'Number',
				'type' => 'number',
				'default' => 8,
				'desc' => '"options" => ["unit" => "%"], "attributes" => ["min" => 0, "max" => 100]',
				'options' => array(
					'unit' => '%'
				),
				'attributes' => array(
					'min' => 0,
					'max' => 100
				),
			));
			$xbox->add_field( array(
				'id' => 'currency',
				'name' => 'Currency',
				'type' => 'number',
				'default' => 59.99,
				'desc' => '"options" => ["unit" => "$"], "attributes" => ["min" => 0, "max" => 1000, "step" => 0.01, "precision" => 2]',
				'options' => array(
					'unit' => '$'
				),
				'attributes' => array(
					'min' => 0,
					'max' => 1000,
					'step' => 0.01,
					'precision' => 2
				),
			));
			$xbox->add_field( array(
				'id' => 'currency-2',
				'name' => 'Currency',
				'type' => 'number',
				'default' => 70.45,
				'desc' => '"options" => ["unit" => "€"], "attributes" => ["min" => 0, "max" => 5000, "step" => 0.5, "precision" => 1]',
				'options' => array(
					'unit' => '€'
				),
				'attributes' => array(
					'min' => 0,
					'max' => 5000,
					'step' => 0.5,
					'precision' => 1
				),
			));
		$xbox->close_tab_item('number');

		$xbox->open_tab_item('textarea');
			$xbox->add_field( array(
				'id' => 'textarea',
				'name' => 'Textarea',
				'type' => 'textarea',
			));
			$xbox->add_field( array(
				'id' => 'textarea-grid',
				'name' => 'Textarea with grid',
				'type' => 'textarea',
				'grid' => '3-of-6',
				'desc' => '"grid" => "3-of-6", "attributes => ["rows" => 5"]',
				'attributes' => array(
					'rows' => 5
				)
			));
		$xbox->close_tab_item('textarea');

		$xbox->open_tab_item('wp-editor');
			$section_wp_editor = $xbox->add_section( array(
				'name' => 'Custom css, html, javascript',
				'desc' => 'Documentation: <a href="http://xboxframework.com/documentation/field-types/wp-editor/" target="_blank">Wp editor</a>, <a href="http://xboxframework.com/documentation/field-types/code-editor/" target="_blank">Code editor</a>',
				'options' => array(
					'toggle' => true,
				)
			));
				$section_wp_editor->add_field( array(
					'id' => 'wp-editor',
					'name' => 'WP Editor',
					'type' => 'wp_editor',
					'options' => array(
						'editor_height' => 100,
					),
				));
				$section_wp_editor->add_field( array(
					'id' => 'code-editor-css',
					'name' => 'Custom CSS',
					'type' => 'code_editor',
					'options' => array(
						'language' => 'css',
						'theme' => 'tomorrow_night',
						'height' => '120px',
					),
					'desc' => '"options" => [ "language" => "css", "theme" => "tomorrow_night", "height" => "120px"]',
					'default' => '
body {
	color: #555555;
	background: #FFFFFF;
	font-size: 14px;
}',

				));

				$section_wp_editor->add_field(array(
					'id' => 'code-editor-html',
					'name' => 'Custom html',
					'type' => 'code_editor',
					'options' => array(
						'language' => 'html',
						'theme' => 'solarized_light',
						'height' => '120px',
					),
					'desc' => '"options" => [ "language" => "html", "theme" => "solarized_light", "height" => "120px"]',
					'default' => '
<section>
  <h1 style="color:blue">Xbox Framework</h1>
</section>
',
				));

				$section_wp_editor->add_field( array(
					'id' => 'code-editor-js',
					'name' => 'Custom javascript',
					'type' => 'code_editor',
					'desc' => 'Only accepts javascript code.',
					'options' => array(
						'language' => 'javascript',
						'theme' => 'cobalt',
						'height' => '120px',
					),
					'desc' => '"options" => [ "language" => "javascript", "theme" => "cobalt", "height" => "120px"]',
					'default' => '
jQuery(document).ready(function($) {
	alert("Hello world");
});
',
				));
		$xbox->close_tab_item('wp-editor');

		$xbox->open_tab_item('switcher');
			$xbox->add_field( array(
				'id' => 'switcher-on',
				'name' => 'Switcher On',
				'type' => 'switcher',
				'default' => 'on',
			));
			$xbox->add_field( array(
				'id' => 'switcher-off',
				'name' => 'Switcher Off',
				'type' => 'switcher',
				'default' => 'off',
			));
		$xbox->close_tab_item('switcher');

		$xbox->open_tab_item('checkbox');
			$xbox->add_field( array(
				'id' => 'input-checkbox',
				'name' => 'Checkbox',
				'type' => 'checkbox',
				'default' => array('active'),
				'items' => array(
					'normal' => 'Normal',
					'active' => 'Active',
					'disabled' => 'Disabled',
				),
				'attributes' => array(
					'disabled' => array( 'disabled' )
				),
				'options' => array(
					'in_line' => false
				),
				'desc' => '"options" => ["in_line" => false]',
			));

			$xbox->add_field( array(
				'id' => 'xbox-categories',
				'name' => 'Categories',
				'type' => 'checkbox',
				'default' => '$all$',
				'items' => XboxItems::terms( 'category' ),
				'desc' => '"items" => "XboxItems::terms( \'category\' )"',
			));
			$xbox->add_field( array(
				'id' => 'input-radio',
				'name' => 'Radio button',
				'type' => 'radio',
				'default' => 'active',
				'items' => array(
					'normal' => 'Normal',
					'active' => 'Active',
					'disabled' => 'Disabled',
				),
				'attributes' => array(
					'disabled' => 'disabled'
				),
			));
		$xbox->close_tab_item('checkbox');

		$xbox->open_tab_item('image-selector');
			$xbox->add_field( array(
				'id' => 'image-selector-demo',
				'name' => 'Select demo',
				'type' => 'image_selector',
				'default' => 'demo1',
				'items' => array(
					'demo1' => XBOX_URL.'example/img/demo1.png',
					'demo2' => XBOX_URL.'example/img/demo2.png',
					'demo3' => XBOX_URL.'example/img/demo3.png',
				),
				'items_desc' => array(
					'demo1' => 'Demo 1',
					'demo2' => 'Demo 2',
					'demo3' => 'Demo 3',
				),
				'options' => array(
					'width' => '160px',
					'in_line' => true
				),
				'desc' => '"options" => ["in_line" => true, "width" => "160px"]',
			));
			$xbox->add_field( array(
				'id' => 'image-selector',
				'name' => 'Image selector',
				'type' => 'image_selector',
				'default' => 'right',
				'items' => array(
					'left' => XBOX_URL.'example/img/logo-position-left.png',
					'right' => XBOX_URL.'example/img/logo-position-right.png',
					'center' => XBOX_URL.'example/img/logo-position-center.png'
				),
				'options' => array(
					'width' => '100px',
					'in_line' => false
				),
				'desc' => '"options" => ["in_line" => false, "width" => "100px"]',
			));
		$xbox->close_tab_item('image-selector');

		$xbox->open_tab_item('select');
			$xbox->add_field( array(
				'id' => 'select',
				'name' => 'Select',
				'type' => 'select',
				'default' => 'male',
				'items' => array(
					'male' => 'Male',
					'female' => 'Female',
				),
			));
			$xbox->add_field( array(
				'id' => 'select-images',
				'name' => 'Select with images',
				'type' => 'select',
				'items' => array(
					'jenny' => '<img class="ui mini avatar image" src="'.XBOX_URL.'example/img/avatar/jenny.jpg">Jenny Hess',
					'elliot' => '<img class="ui mini avatar image" src="'.XBOX_URL.'example/img/avatar/elliot.jpg">Elliot Fu',
					'stevie' => '<img class="ui mini avatar image" src="'.XBOX_URL.'example/img/avatar/stevie.jpg">Stevie',
					'christian' => '<img class="ui mini avatar image" src="'.XBOX_URL.'example/img/avatar/christian.jpg">Christian',
				),
				'options' => array(
					'sort' => 'desc'
				),
				'default' => 'elliot',
				'grid' => '2-of-8',
			));
			$xbox->add_field( array(
				'id' => 'select-option-group',
				'name' => 'Select with option group',
				'type' => 'select',
				'items' => array(
					'' => 'None',
					'Google Fonts' => XboxItems::google_fonts(),
					'Web Safe Fonts' => XboxItems::web_safe_fonts()
				),
				'options' => array(
					'sort' => 'asc',
					'search' => true,
				),
				'grid' => '3-of-8'
			));
            $xbox->add_field( array(
                'name' => 'Two ways to add icons',
                'type' => 'title',
            ));
            $xbox->add_field( array(
                'name' => 'Icon selector',
                'id' => 'icon-selector',
                'type' => 'icon_selector',
                'default' => 'fab fa-apple',
                'items' => array_merge(
                    array(
                        XBOX_URL .'img/svg/cake.svg' => "<img src='".XBOX_URL ."img/svg/cake.svg'>",
                        XBOX_URL .'img/svg/cart.svg' => "<img src='".XBOX_URL ."img/svg/cart.svg'>",
                        XBOX_URL .'img/svg/cash.svg' => "<img src='".XBOX_URL ."img/svg/cash.svg'>",
                    ),
                    XboxItems::icon_fonts()
                ),
                'options' => array(
                    'wrap_height'    => '220px',
                    'size'           => '36px',
                    'hide_search'    => false,
                    'hide_buttons'   => false,
                ),
            ));
            $xbox->add_field( array(
                'name' => 'Select with icons',
                'id' => 'select-icons',
                'type' => 'select',
                'items' => XboxItems::icons(),
                'options' => array(
                    'search' => true,
                ),
                'default' => 'fab fa-apple',
                'grid' => '3-of-8',
            ));
		$xbox->close_tab_item('select');

		$xbox->open_tab_item('colorpicker');
			$xbox->add_field( array(
				'id' => 'colorpicker',
				'name' => 'Colorpicker',
				'type' => 'colorpicker',
				'default' => '#9343F5',
				'options' => array(
					'format' => 'hex'
				),
				'desc' => '"options" => ["format" => "hex"]',
			));
			$xbox->add_field( array(
				'id' => 'colorpicker-alpha',
				'name' => 'Colorpicker with alpha',
				'type' => 'colorpicker',
				'default' => '#9343F5',
				'options' => array(
					'format' => 'rgba',
					'opacity' => 0.6,
				),
				'grid' => '3-of-8',
				'desc' => '"options" => ["format" => "rgba", "opacity" => 0.6]',
			));
		$xbox->close_tab_item('colorpicker');

		$xbox->open_tab_item('file');
			$xbox->add_field( array(
				'id' => 'file-upload',
				'name' => 'File upload (mp3, pdf)',
				'type' => 'file',
				'options' => array(
					'multiple' => true,
					'mime_types' => array( 'mp3', 'pdf' ),
				),
				'desc' => '"options" => ["mime_types" => ["mp3", "pdf"], "multiple" => true]',
			));
			$xbox->add_field( array(
				'id' => 'image-upload',
				'name' => 'Image upload',
				'type' => 'file',
				'options' => array(
					'mime_types' => array( 'jpg', 'jpeg', 'png', 'gif', 'ico' ),
					'preview_size' => array( 'width' => '60px','height' => '60px' ),
					'multiple' => false,
				),
				'desc' => '"options" => ["mime_types" => ["jpg", "jpeg", "png", "gif", "ico"], "multiple" => false]',
			));
			$xbox->add_field( array(
				'id' => 'image-upload-multiple',
				'name' => 'Multiple image upload',
				'type' => 'file',
				'options' => array(
					'mime_types' => array( 'jpg', 'jpeg', 'png', 'gif', 'ico' ),
					'preview_size' => array( 'width' => '60px','height' => '60px' ),
					'multiple' => true,
				),
				'desc' => '"options" => ["mime_types" => ["jpg", "jpeg", "png", "gif", "ico"], "multiple" => true]',
			));
			$xbox->add_field( array(
				'id' => 'image-upload-repeatable',
				'name' => 'Image upload repeatable',
				'type' => 'file',
				'options' => array(
					'mime_types' => array( 'jpg', 'jpeg', 'png', 'gif', 'ico' ),
					'preview_size' => array( 'width' => '60px','height' => '60px' ),
				),
				'repeatable' => true,
				'desc' => '"repeatable" => true, "options" => ["mime_types" => ["jpg", "jpeg", "png", "gif", "ico"] ]',
			));
		$xbox->close_tab_item('file');

		$xbox->open_tab_item('oembed');
			$xbox->add_field( array(
				'id' => 'oembed-youtube',
				'name' => 'Youtube',
				'type' => 'oembed',
				'default' => 'https://www.youtube.com/watch?v=Tf4sa0BVJVw',
				'options' => array(
					'preview_onload' => true,
				),
				'desc' => '"options" => ["preview_onload" => true ]',
			));
			$xbox->add_field( array(
				'id' => 'oembed-vimeo',
				'name' => 'Vimeo',
				'type' => 'oembed',
				'default' => 'https://vimeo.com/100973320',
				'options' => array(
					'preview_onload' => false,
				),
				'desc' => '"options" => ["preview_onload" => false ]',
			));
			$xbox->add_field( array(
				'id' => 'oembed-soundcloud',
				'name' => 'Soundcloud',
				'type' => 'oembed',
				'default' => 'https://soundcloud.com/onepingonly/pop-charts-mix-2016-best-remixes-of-popular-songs-2015-new-dance-hits-top-100-edm-party-music',
				'options' => array(
					'preview_onload' => false,
					'preview_size' => array('height' => '150px')
				),
				'desc' => '"options" => ["preview_onload" => false, "preview_size" => ["height" => "150px"] ]',
			));
		$xbox->close_tab_item('oembed');

	$xbox->close_tab('main-tab');
}




