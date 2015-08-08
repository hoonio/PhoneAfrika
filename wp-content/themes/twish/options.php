<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

function optionsframework_option_name()
{

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_option('stylesheet');
	$themename = preg_replace("/\W/", "_", strtolower($themename));

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);

	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options()
{

	// Test data
	$test_array = array(
		'one' => __('One', 'options_check'),
		'two' => __('Two', 'options_check'),
		'three' => __('Three', 'options_check'),
		'four' => __('Four', 'options_check'),
		'five' => __('Five', 'options_check')
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'options_check'),
		'two' => __('Pancake', 'options_check'),
		'three' => __('Omelette', 'options_check'),
		'four' => __('Crepe', 'options_check'),
		'five' => __('Waffle', 'options_check')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment' => 'scroll');

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55');

	// Typography Options
	$typography_options = array(
		'sizes' => array('6', '12', '14', '16', '20'),
		'faces' => array('Helvetica Neue' => 'Helvetica Neue', 'Arial' => 'Arial'),
		'styles' => array('normal' => 'Normal', 'bold' => 'Bold'),
		'color' => false
	);

	// Responsive Options
	$responsive_options = array(
		'responsive_1170' => __('Responsive Layout Large (Max Width: 1170px)', 'options_check'),
		'responsive_960' => __('Responsive Layout Medium (Max Width: 960px)', 'options_check'),
		'fixed_960' => __('Fixed Width (Constant Width: 960px)', 'options_check')
	);

	// Blog Layout Options
	$blog_layout_options = array(
		'medium_size' => __('Medium Size Preview Images', 'options_check'),
		'large_size' => __('Large Size Preview Images', 'options_check'),
		'full_width' => __('Full Width Preview Images', 'options_check'),
		'full_width_centered' => __('Full Width Preview Images with Centered Content', 'options_check')
	);

	// Body layout Options
	$layout_options = array(
		'stretched' => __('Stretched Layout', 'options_check'),
		'boxed' => __('Boxed Layout', 'options_check'),
	);

	// Header Options
	$header_layout_options = array(
		'standard' => __('Standard header with a conventional horizontal menu', 'options_check'),
		'compact' => __('Compact header with mobile style menu', 'options_check'),
	);

	// Social Icons
	$social_icon_choices = array(
		'none' => __('None', 'options_check'),
		'facebook' => __('Facebook', 'options_check'),
		'twitter' => __('Twitter', 'options_check'),
		'linkedin' => __('LinkedIn', 'options_check'),
		'pinterest' => __('Pinterest', 'options_check'),
		'google' => __('Google+', 'options_check'),
		'skype' => __('Skype', 'options_check'),
		'tumblr' => __('Tumblr', 'options_check'),
		'dribbble' => __('Dribbble', 'options_check'),
		'github' => __('Github', 'options_check'),
		'paypal' => __('Paypal', 'options_check'),
		'soundcloud' => __('Soundcloud', 'options_check'),
		'behance' => __('Behance', 'options_check'),
		'flickr' => __('Flickr', 'options_check'),
		'vimeo' => __('Vimeo', 'options_check'),
		'youtube' => __('Youtube', 'options_check'),
		'phone' => __('Phone', 'options_check'),
		'email' => __('Email', 'options_check'),
	);

	$subfooter_social_icon_choices = array(
		'none' => __('None', 'options_check'),
		'facebook' => __('Facebook', 'options_check'),
		'twitter' => __('Twitter', 'options_check'),
		'linkedin' => __('LinkedIn', 'options_check'),
		'pinterest' => __('Pinterest', 'options_check'),
		'gplus' => __('Google+', 'options_check'),
		'skype' => __('Skype', 'options_check'),
		'dribbble' => __('Dribbble', 'options_check'),
		'github' => __('Github', 'options_check'),
		'tumblr' => __('Tumblr', 'options_check'),
		'vimeo' => __('Vimeo', 'options_check')
	);

	$sidebar_options = array(
		'left_sidebar' => __('Left Sidebar', 'options_check'),
		'right_sidebar' => __('Right Sidebar', 'options_check'),
		'no_sidebar' => __('None', 'options_check'),
	);

	// Fonts
	$typography_mixed_fonts = array_merge(adap_options_typography_get_os_fonts(), adap_options_typography_get_google_fonts());
	asort($typography_mixed_fonts);


	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ($options_tags_obj as $tag) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath = get_template_directory_uri() . '/images/';

	$options = array();


	// Peach Options

	// HEADER TAB

	$options[] = array(
		'name' => __('Header', 'options_check'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Sticky Header?', 'options_check'),
		'desc' => __('Check this box if you want the header to always be visible no matter what the current scroll position is.', 'options_check'),
		'id' => 'enable_sticky_header',
		'std' => '0',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Make Sticky Header Translucent?', 'options_check'),
		'desc' => __('Check this box if you want the sticky header to be semi-transparent.', 'options_check'),
		'id' => 'enable_translucent_sticky_header',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Logo Image</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');


	$options[] = array(
		'name' => __('Logo', 'options_check'),
		'desc' => __('Choose the image to use as the site logo.', 'options_check'),
		'id' => 'site_logo',
		'type' => 'upload');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Fullsize Logo Dimensions</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');


	$options[] = array(
		'name' => __('Logo Width (px)', 'options_check'),
		'desc' => __('The width of the logo image (in pixels).', 'options_check'),
		'id' => 'site_logo_width',
		'std' => '63',
		'type' => 'text');

	$options[] = array(
		'name' => __('Logo Height (px)', 'options_check'),
		'desc' => __('The height of the logo image (in pixels).', 'options_check'),
		'id' => 'site_logo_height',
		'std' => '35',
		'type' => 'text');

	$options[] = array(
		'name' => __('Logo Vertical Offset (px)', 'options_check'),
		'desc' => __('The distance between the top of the page and the top of the logo image (in pixels).', 'options_check'),
		'id' => 'site_logo_voffset',
		'std' => '39',
		'type' => 'text');


	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Mobile Logo Dimensions</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');


	$options[] = array(
		'name' => __('Logo Width (px)', 'options_check'),
		'desc' => __('The width of the logo image (in pixels).', 'options_check'),
		'id' => 'site_mobile_logo_width',
		'std' => '63',
		'type' => 'text');

	$options[] = array(
		'name' => __('Logo Height (px)', 'options_check'),
		'desc' => __('The height of the logo image (in pixels).', 'options_check'),
		'id' => 'site_mobile_logo_height',
		'std' => '35',
		'type' => 'text');

	$options[] = array(
		'name' => __('Logo Vertical Offset (px)', 'options_check'),
		'desc' => __('The distance between the top of the page and the top of the logo image (in pixels).', 'options_check'),
		'id' => 'site_mobile_logo_voffset',
		'std' => '8',
		'type' => 'text');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Social Icon #1</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Icon', 'options_check'),
		'desc' => __('Choose a social icon to display', 'options_check'),
		'id' => 'social_icon_1',
		'std' => 'phone',
		'type' => 'select',
		'options' => $social_icon_choices);

	$options[] = array(
		'name' => __('URL', 'options_check'),
		'desc' => __('The URL of the page to open when the icon is clicked.', 'options_check'),
		'id' => 'social_icon_url_1',
		'std' => 'http://',
		'type' => 'text');

	$options[] = array(
		'name' => __('Phone Number', 'options_check'),
		'desc' => __('The phone number to dial when a user taps the icon on a smartphone.', 'options_check'),
		'id' => 'social_icon_phonenumber_1',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Email Address', 'options_check'),
		'desc' => __('The email address to address emails to when users click the icon.', 'options_check'),
		'id' => 'social_icon_emailaddress_1',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Social Icon #2</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Icon', 'options_check'),
		'desc' => __('Choose a social icon to display', 'options_check'),
		'id' => 'social_icon_2',
		'std' => 'email',
		'type' => 'select',
		'options' => $social_icon_choices);

	$options[] = array(
		'name' => __('URL', 'options_check'),
		'desc' => __('The URL of the page to open when the icon is clicked.', 'options_check'),
		'id' => 'social_icon_url_2',
		'std' => 'http://',
		'type' => 'text');

	$options[] = array(
		'name' => __('Phone Number', 'options_check'),
		'desc' => __('The phone number to dial when a user taps the icon on a smartphone.', 'options_check'),
		'id' => 'social_icon_phonenumber_2',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Email Address', 'options_check'),
		'desc' => __('The email address to address emails to when users click the icon.', 'options_check'),
		'id' => 'social_icon_emailaddress_2',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Social Icon #3</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Icon', 'options_check'),
		'desc' => __('Choose a social icon to display', 'options_check'),
		'id' => 'social_icon_3',
		'std' => 'twitter',
		'type' => 'select',
		'options' => $social_icon_choices);

	$options[] = array(
		'name' => __('URL', 'options_check'),
		'desc' => __('The URL of the page to open when the icon is clicked.', 'options_check'),
		'id' => 'social_icon_url_3',
		'std' => 'http://',
		'type' => 'text');

	$options[] = array(
		'name' => __('Phone Number', 'options_check'),
		'desc' => __('The phone number to dial when a user taps the icon on a smartphone.', 'options_check'),
		'id' => 'social_icon_phonenumber_3',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Email Address', 'options_check'),
		'desc' => __('The email address to address emails to when users click the icon.', 'options_check'),
		'id' => 'social_icon_emailaddress_3',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Social Icon #4</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Icon', 'options_check'),
		'desc' => __('Choose a social icon to display', 'options_check'),
		'id' => 'social_icon_4',
		'std' => 'facebook',
		'type' => 'select',
		'options' => $social_icon_choices);

	$options[] = array(
		'name' => __('URL', 'options_check'),
		'desc' => __('The URL to open when the icon is clicked.', 'options_check'),
		'id' => 'social_icon_url_4',
		'std' => 'http://',
		'type' => 'text');

	$options[] = array(
		'name' => __('Phone Number', 'options_check'),
		'desc' => __('The phone number to dial when a user taps the icon on a smartphone.', 'options_check'),
		'id' => 'social_icon_phonenumber_4',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Email Address', 'options_check'),
		'desc' => __('The email address to address emails to when users click the icon.', 'options_check'),
		'id' => 'social_icon_emailaddress_4',
		'std' => '',
		'type' => 'text');


	$options[] = array(
		'name' => __('Sidebar', 'options_check'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Sidebar on Archive Pages', 'options_check'),
		'desc' => __('Choose where the sidebar should appear on all archive pages.', 'options_check'),
		'id' => 'sidebar_archive_pages',
		'std' => 'right_sidebar',
		'type' => 'select',
		'class' => 'mini',
		'options' => $sidebar_options);

	$options[] = array(
		'name' => __('Sidebar Position on Blog Page', 'options_check'),
		'desc' => __('Choose where the sidebar should appear on the default blog page.', 'options_check'),
		'id' => 'sidebar_blog',
		'std' => 'right_sidebar',
		'type' => 'select',
		'class' => 'mini',
		'options' => $sidebar_options);

	$options[] = array(
		'name' => __('Sidebar Position on Posts', 'options_check'),
		'desc' => __('Choose where the sidebar should appear on all blog posts.', 'options_check'),
		'id' => 'sidebar_posts',
		'std' => 'right_sidebar',
		'type' => 'select',
		'class' => 'mini',
		'options' => $sidebar_options);

	$options[] = array(
		'name' => __('Sidebar Position on Pages', 'options_check'),
		'desc' => __('Choose where the sidebar should appear on all pages (by default).', 'options_check'),
		'id' => 'sidebar_pages',
		'std' => 'no_sidebar',
		'type' => 'select',
		'class' => 'mini',
		'options' => $sidebar_options);


	$options[] = array(
		'name' => __('Footer', 'options_check'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Display Footer?', 'options_check'),
		'desc' => __('Show the footer widget area.', 'options_check'),
		'id' => 'enable_footer',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Footer Layout', 'options_check'),
		'desc' => __('Choose the layout of widgets in the footer.', 'options_check'),
		'id' => 'footer_layout',
		'std' => '4',
		'type' => 'select',
		'class' => 'mini',
		'options' => array('default' => 'default', '1-even' => '1 large column',
			'2-even' => '2 even columns', '3-even' => '3 even columns',
			'4-even' => '4 even columns', '1-wide-2-narrow' => '1 wide, two narrow',
			'2-narrow-1-wide' => '2 narrow, 1 wide'));

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Subfooter</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Display Subfooter?', 'options_check'),
		'desc' => __('Show the subfooter.', 'options_check'),
		'id' => 'enable_subfooter',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Copyright Text', 'options_check'),
		'desc' => __('The text to display inside the subfooter .', 'options_check'),
		'id' => 'copyright_text',
		'std' => '&copy; Copyright 2013',
		'type' => 'text');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Subfooter Social Icon #1</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Icon', 'options_check'),
		'desc' => __('Choose a social icon to display', 'options_check'),
		'id' => 'subfooter_social_icon_1',
		'std' => 'phone',
		'type' => 'select',
		'options' => $subfooter_social_icon_choices);

	$options[] = array(
		'name' => __('URL', 'options_check'),
		'desc' => __('The URL of the page to open when the icon is clicked.', 'options_check'),
		'id' => 'subfooter_social_icon_url_1',
		'std' => 'http://',
		'type' => 'text');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Subfooter Social Icon #2</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Icon', 'options_check'),
		'desc' => __('Choose a social icon to display', 'options_check'),
		'id' => 'subfooter_social_icon_2',
		'std' => 'phone',
		'type' => 'select',
		'options' => $subfooter_social_icon_choices);

	$options[] = array(
		'name' => __('URL', 'options_check'),
		'desc' => __('The URL of the page to open when the icon is clicked.', 'options_check'),
		'id' => 'subfooter_social_icon_url_2',
		'std' => 'http://',
		'type' => 'text');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Subfooter Social Icon #3</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Icon', 'options_check'),
		'desc' => __('Choose a social icon to display', 'options_check'),
		'id' => 'subfooter_social_icon_3',
		'std' => 'phone',
		'type' => 'select',
		'options' => $subfooter_social_icon_choices);

	$options[] = array(
		'name' => __('URL', 'options_check'),
		'desc' => __('The URL of the page to open when the icon is clicked.', 'options_check'),
		'id' => 'subfooter_social_icon_url_3',
		'std' => 'http://',
		'type' => 'text');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Subfooter Social Icon #4</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Icon', 'options_check'),
		'desc' => __('Choose a social icon to display', 'options_check'),
		'id' => 'subfooter_social_icon_4',
		'std' => 'phone',
		'type' => 'select',
		'options' => $subfooter_social_icon_choices);

	$options[] = array(
		'name' => __('URL', 'options_check'),
		'desc' => __('The URL of the page to open when the icon is clicked.', 'options_check'),
		'id' => 'subfooter_social_icon_url_4',
		'std' => 'http://',
		'type' => 'text');


	// STYLING TAB

	$options[] = array(
		'name' => __('Styling', 'options_check'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Stretched or Boxed Layout', 'options_check'),
		'desc' => __('Whether pages should span the browser window or be contained in a box.', 'options_check'),
		'id' => 'stretched_or_boxed',
		'std' => 'stretched',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $layout_options);

	$options[] = array(
		'name' => __('Display Page Shadow?', 'options_check'),
		'desc' => __('Show a shadow on boxed pages.', 'options_check'),
		'id' => 'enable_page_shadow',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Site Background', 'options_check'),
		'desc' => __('Choose a color and image for the site background.', 'options_check'),
		'id' => 'site_background',
		'class' => 'hidden',
		'std' => $background_defaults,
		'type' => 'background');

	$options[] = array(
		'name' => __('Cover Background?', 'options_check'),
		'desc' => __('Automatically resize the background image so it fills the browser window.', 'options_check'),
		'id' => 'enable_cover_background',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Color Scheme</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Base Color Scheme', 'options_check'),
		'desc' => __('Choose a base color scheme for the site. You\'ll see all the colors below change to match the chosen skin.
		You can then change any given color to customize the colors to get exactly the design you want.', 'options_check'),
		'id' => 'base_color_scheme',
		'std' => 'maroon',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => adap_options_styling_get_skin_select_options());


	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Header Colors</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Social Icon Color', 'options_check'),
		'desc' => __('The color of the social icons in the header.', 'options_check'),
		'id' => 'header_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Social Icon Hover Color', 'options_check'),
		'desc' => __('The color of the social icons in the header when a mouse cursor is hovering over them.', 'options_check'),
		'id' => 'header_icon_hover_color',
		'std' => '',
		'type' => 'progressive_color');


	$options[] = array(
		'name' => __('Menu Item Color', 'options_check'),
		'desc' => __('The color of the top-level menu items.', 'options_check'),
		'id' => 'menu_item_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Menu Item Hover Color', 'options_check'),
		'desc' => __('The color of the top-level menu items when a mouse cursor is hovering over them.', 'options_check'),
		'id' => 'menu_item_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Submenu Item Color', 'options_check'),
		'desc' => __('The color of menu items in submenus.', 'options_check'),
		'id' => 'submenu_item_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Submenu Item Hover Color', 'options_check'),
		'desc' => __('The color of submenu items when a mouse cursor is hovering over them.', 'options_check'),
		'id' => 'submenu_item_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Submenu Background Color', 'options_check'),
		'desc' => __('The background color of submenus.', 'options_check'),
		'id' => 'submenu_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Submenu Background Image', 'options_check'),
		'desc' => __('Choose an image to use as the submenu background (optional).', 'options_check'),
		'id' => 'submenu_background_image',
		'class' => 'background-image-only',
		'std' => $background_defaults,
		'type' => 'background');

	$options[] = array(
		'name' => __('Header Border Color', 'options_check'),
		'desc' => __('The color of the small border between the menu items and the social icons.', 'options_check'),
		'id' => 'header_border_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Header Background Color', 'options_check'),
		'desc' => __('The background color of the header.', 'options_check'),
		'id' => 'header_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Header Background Image', 'options_check'),
		'desc' => __('Choose an image to use as the header background (optional).', 'options_check'),
		'id' => 'custom_header_background',
		'class' => 'background-image-only',
		'std' => $background_defaults,
		'type' => 'background');

	$options[] = array(
		'name' => __('Mobile Menu Item Color', 'options_check'),
		'desc' => __('The color of the top-level menu items in the mobile menu.', 'options_check'),
		'id' => 'mobile_menu_item_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Mobile Submenu Item Color', 'options_check'),
		'desc' => __('The color of submenu items in the mobile menu.', 'options_check'),
		'id' => 'mobile_submenu_item_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Mobile Menu Current Item Color', 'options_check'),
		'desc' => __('The color of the menu item that corresponds to the current page.', 'options_check'),
		'id' => 'mobile_menu_current_item_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Mobile Menu Background Color', 'options_check'),
		'desc' => __('The background color of the mobile menu.', 'options_check'),
		'id' => 'mobile_menu_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Mobile Menu Background Image', 'options_check'),
		'desc' => __('Choose an image to use as the mobile menu background (optional).', 'options_check'),
		'id' => 'mobile_menu_background',
		'class' => 'background-image-only',
		'std' => $background_defaults,
		'type' => 'background');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Subheader Colors</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Breadcrumb Link Color', 'options_check'),
		'desc' => __('The color of links in the breadcrumb.', 'options_check'),
		'id' => 'breadcrumb_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Breadcrumb Link Hover Color', 'options_check'),
		'desc' => __('The hover color of links in the breadcrumb.', 'options_check'),
		'id' => 'breadcrumb_link_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Breadcrumb Current Page Color', 'options_check'),
		'desc' => __('The color of the current page in the breadcrumb.', 'options_check'),
		'id' => 'breadcrumb_current_page_color',
		'std' => '',
		'type' => 'progressive_color');


	$options[] = array(
		'name' => __('Page Title Color', 'options_check'),
		'desc' => __('The color of the page title.', 'options_check'),
		'id' => 'page_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Subheader Background Color', 'options_check'),
		'desc' => __('The background color of the subheader.', 'options_check'),
		'id' => 'subheader_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Subheader Background Image', 'options_check'),
		'desc' => __('Choose an image to use as the background (optional).', 'options_check'),
		'id' => 'subheader_background_image',
		'class' => 'background-image-only',
		'std' => $background_defaults,
		'type' => 'background');


	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Main Content Colors</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

//	Typography

	$options[] = array(
		'name' => __('Main Content H1 Color', 'options_check'),
		'desc' => __('The color of h1 elements in the main page content.', 'options_check'),
		'id' => 'main_content_heading1_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content H2 Color', 'options_check'),
		'desc' => __('The color of h2 elements in the main page content.', 'options_check'),
		'id' => 'main_content_heading2_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content H3 Color', 'options_check'),
		'desc' => __('The color of h3 elements in the main page content.', 'options_check'),
		'id' => 'main_content_heading3_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content H4 Color', 'options_check'),
		'desc' => __('The color of h4 elements in the main page content.', 'options_check'),
		'id' => 'main_content_heading4_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content H5 Color', 'options_check'),
		'desc' => __('The color of h5 elements in the main page content.', 'options_check'),
		'id' => 'main_content_heading5_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content H6 Color', 'options_check'),
		'desc' => __('The color of h6 elements in the main page content.', 'options_check'),
		'id' => 'main_content_heading6_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content Text Color', 'options_check'),
		'desc' => __('The color of text in page content.', 'options_check'),
		'id' => 'main_content_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content Bolded Text Color', 'options_check'),
		'desc' => __('The color of bolded text (text contained inside a <strong>&lt;strong&gt;</strong> element).', 'options_check'),
		'id' => 'main_content_bolded_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content Link Color', 'options_check'),
		'desc' => __('The color of links.', 'options_check'),
		'id' => 'main_content_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content Link Hover Color', 'options_check'),
		'desc' => __('The color of links when a mouse cursor is hovering over them.', 'options_check'),
		'id' => 'main_content_link_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content Lead Color', 'options_check'),
		'desc' => __('The color of lead text elements in the main page content.', 'options_check'),
		'id' => 'main_content_lead_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content Intro Color', 'options_check'),
		'desc' => __('The color of intro text elements in the main page content.', 'options_check'),
		'id' => 'main_content_intro_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content Full-Width Row Background Color', 'options_check'),
		'desc' => __('The background color of rows that are set to display full-width.', 'options_check'),
		'id' => 'main_content_fullwidth_row_background_color',
		'std' => '',
		'type' => 'progressive_color');

//	Shortcodes

	$options[] = array(
		'name' => __('Border Color', 'options_check'),
		'desc' => __('The color of dividers and separators.', 'options_check'),
		'id' => 'main_content_border_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blockquote Text Color', 'options_check'),
		'desc' => __('The text color of blockquotes that <strong>don\'t</strong> have a color background.', 'options_check'),
		'id' => 'main_content_blockquote_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blockquote Background Color', 'options_check'),
		'desc' => __('The background color of blockquotes (only applies to the blockquote styles that have a background).', 'options_check'),
		'id' => 'main_content_blockquote_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blockquote Reverse Text Color', 'options_check'),
		'desc' => __('The text color of blockquotes that <strong>do</strong> have a color background.', 'options_check'),
		'id' => 'main_content_blockquote_reverse_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Dropcap Text Color', 'options_check'),
		'desc' => __('The text color of dropcaps that <strong>don\'t</strong> have a color background.', 'options_check'),
		'id' => 'main_content_dropcap_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Dropcap Background Color', 'options_check'),
		'desc' => __('The background color of dropcaps (only applies to the dropcap styles that have a background)', 'options_check'),
		'id' => 'main_content_dropcap_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Dropcap Reverse Text Color', 'options_check'),
		'desc' => __('The text color of blockquotes that <strong>do</strong> have a color background.', 'options_check'),
		'id' => 'main_content_dropcap_reverse_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Tooltip Link Color', 'options_check'),
		'desc' => __('The color of the link that has to be hovered over to show the tooltip.', 'options_check'),
		'id' => 'main_content_tooltip_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Tooltip Background Color', 'options_check'),
		'desc' => __('The background color of tooltips.', 'options_check'),
		'id' => 'main_content_tooltip_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Tooltip Text Color', 'options_check'),
		'desc' => __('The color of text in tooltips.', 'options_check'),
		'id' => 'main_content_tooltip_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Highlight Text Color', 'options_check'),
		'desc' => __('The color of highlighted text.', 'options_check'),
		'id' => 'main_content_highlight_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Highlight Background Color', 'options_check'),
		'desc' => __('The background color of highlighted text.', 'options_check'),
		'id' => 'main_content_highlight_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('List Icon Color', 'options_check'),
		'desc' => __('The color of icons in lists.', 'options_check'),
		'id' => 'main_content_list_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('List Text Color', 'options_check'),
		'desc' => __('The color of text in lists.', 'options_check'),
		'id' => 'main_content_list_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Label SC Text Color', 'options_check'),
		'desc' => __('The color of text inside the label element.', 'options_check'),
		'id' => 'main_content_label_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Label SC Background Color', 'options_check'),
		'desc' => __('The background color of the label element.', 'options_check'),
		'id' => 'main_content_label_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Badge SC Text Color', 'options_check'),
		'desc' => __('The color of text inside the badge element.', 'options_check'),
		'id' => 'main_content_badge_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Badge SC Background Color', 'options_check'),
		'desc' => __('The color of text inside the badge element.', 'options_check'),
		'id' => 'main_content_badge_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Popover Link Color', 'options_check'),
		'desc' => __('The color of the link that has to be hovered over to show the popover.', 'options_check'),
		'id' => 'main_content_popover_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Popover Heading Color', 'options_check'),
		'desc' => __('The color of the title in popovers.', 'options_check'),
		'id' => 'main_content_popover_heading_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Popover Text Color', 'options_check'),
		'desc' => __('The color of text inside popovers.', 'options_check'),
		'id' => 'main_content_popover_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Accordion Link Color (Minimalist Style)', 'options_check'),
		'desc' => __('The text color of the toggle headings in accordions (applies to the minimalist accordion style).', 'options_check'),
		'id' => 'main_content_accordion_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Accordion Active Link Color (Minimalist Style)', 'options_check'),
		'desc' => __('The color of an accordion toggle heading when it\'s open (applies to the minimalist accordion style).', 'options_check'),
		'id' => 'main_content_accordion_link_active_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Accordion Divider Color (Minimalist Style)', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_accordion_divider_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Accordion Background Color (Block Style)', 'options_check'),
		'desc' => __('The background color of the toggle heading (applies to the block accordion style).', 'options_check'),
		'id' => 'main_content_accordion_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Accordion Reverse Link Color (Block Style)', 'options_check'),
		'desc' => __('The text color of the toggle headings in accordions (applies to the block accordion style)', 'options_check'),
		'id' => 'main_content_accordion_reverse_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Accordion Active Background Color (Block Style)', 'options_check'),
		'desc' => __('The background color of the accordion toggle heading when it\'s open (applies to the block accordion style)', 'options_check'),
		'id' => 'main_content_accordion_active_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Accordion Active Reverse Link Color (Block Style)', 'options_check'),
		'desc' => __('The text color of an accordion toggle heading when it\'s open (applies to the block accordion style).', 'options_check'),
		'id' => 'main_content_accordion_active_reverse_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Alert Border Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_alert_border_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Alert Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_alert_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Alert Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_alert_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Counter Circle Label Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_counter_circle_label_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Counter Circle Track Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_counter_circle_track_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Counter Circle Bar Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_counter_circle_bar_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Counter Circle Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_counter_circle_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Counter Box Percentage Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_counter_box_percentage_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Counter Box Caption Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_counter_box_caption_color',
		'std' => '',
		'type' => 'progressive_color');


	$options[] = array(
		'name' => __('Counter Box Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_counter_box_background_color',
		'std' => '',
		'type' => 'progressive_color');


	$options[] = array(
		'name' => __('Progress Bar Label Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_progress_bar_label_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Progress Bar Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_progress_bar_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Progress Bar Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_progress_bar_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Progress Bar Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_progress_bar_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Button Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_button_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Button Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_button_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Button Hover Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_button_hover_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Button Hover Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_button_hover_text_color',
		'std' => '',
		'type' => 'progressive_color');

//	Content Box Style 1
//	Title Color
	$options[] = array(
		'name' => __('Content Box Style #1 - Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox1_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #1 - Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox1_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #2 - Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox2_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #2 - Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox2_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #2 - Icon Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox2_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #3 - Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox3_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #3 - Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox3_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #3 - Icon Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox3_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #4 - Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox4_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #4 - Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox4_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #4 - Icon Border Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox4_border_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #5 - Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox5_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #5 - Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox5_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #6 - Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox6_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #6 - Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox6_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #6 - Icon Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox6_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #6 - Border Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox6_border_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #6 - Content Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox6_content_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #6 - Content Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox6_content_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #6 - Button Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox6_button_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #6 - Button Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox6_button_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #6 - Button Background Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox6_button_background_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Content Box Style #6 - Button Text Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_contentbox6_button_text_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Icon Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_icon_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Icon Border Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_icon_border_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Icon Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_icon_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Icon Hover Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_icon_hover_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Icon Hover Border Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_icon_hover_border_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Icon Without Circle Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_icon_wo_circle_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Icon Without Circle Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_icon_wo_circle_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Profile Name Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_profile_name_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Profile Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_profile_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Profile Social Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_profile_social_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Profile Social Icon Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_profile_social_icon_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Plan Header Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_plan_header_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Plan Price Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_plan_price_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Plan Header Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_plan_header_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Plan Details Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_plan_details_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Plan Details Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_plan_details_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Table Border Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_table_border_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Table Header Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_table_header_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Table Price Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_table_price_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Table Header Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_table_header_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Table Details Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_table_details_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Table Details Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_table_details_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Table Details Alternate Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_table_details_alternate_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Table Featured Header Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_table_featured_header_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Pricing Table Featured Header Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_pricing_table_featured_header_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Posts SC Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_posts_sc_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Posts SC Title Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_posts_sc_title_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Posts SC Date Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_posts_sc_date_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Posts SC Comment Count Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_posts_sc_comment_count_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Posts SC Comment Count Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_posts_sc_comment_count_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Tab Heading Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_tab_heading_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Tab Heading Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_tab_heading_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Tab Active Heading Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_tab_active_heading_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Tab Active Heading Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_tab_active_heading_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Tab Hover Heading Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_tab_hover_heading_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Tab Hover Heading Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_tab_hover_heading_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Tab Content Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_tab_content_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Tab Content Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_tab_content_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Hero Unit Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_hero_unit_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Hero Unit Heading Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_hero_unit_heading_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Hero Unit Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_hero_unit_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Thumbnail Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_thumbnail_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Thumbnail Heading Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_thumbnail_heading_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Thumbnail Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_thumbnail_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Testimonial Style #1 - Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_testimonial1_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Testimonial Style #1 - Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_testimonial1_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Testimonia Style #1 - Author Name Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_testimonial1_author_name_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Testimonial Style #1 - Author Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_testimonial1_author_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Testimonial Style #2 - Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_testimonial2_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Testimonial Style #2 - Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_testimonial2_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Testimonial Style #2 - Author Name Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_testimonial2_author_name_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Testimonial Style #2 - Author Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_testimonial2_author_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider Paginator Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_paginator_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider Paginator Opacity', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_paginator_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Revolution Slider Current Paginator Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_current_paginator_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider Current Paginator Opacity', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_current_paginator_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Revolution Slider Nav Arrow Background (Big)', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_big_nav_arrow_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider Nav Arrow Background Opacity (Big)', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_big_nav_arrow_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Revolution Slider Nav Arrow Hover Background (Big)', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_big_nav_arrow_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider Nav Arrow Background Hover Opacity (Big)', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_big_nav_arrow_hover_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Revolution Slider Nav Arrow Background (Small)', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_small_nav_arrow_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider Nav Arrow Background Opacity (Small)', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_small_nav_arrow_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Revolution Slider Nav Arrow Hover Background (Small)', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_small_nav_arrow_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider Nav Arrow Hover Background Opacity (Small)', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_small_nav_arrow_hover_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Revolution Slider "Dark" Caption Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_dark_caption_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider "Light" Caption Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_light_caption_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider "Colored" Caption Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_colored_caption_color',
		'std' => '',
		'type' => 'progressive_color');


	$options[] = array(
		'name' => __('Revolution Slider "Dark" Button Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_dark_button_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider "Dark" Button Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_dark_button_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider "Dark" Button Hover Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_dark_button_hover_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider "Dark" Button Hover Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_dark_button_hover_background_color',
		'std' => '',
		'type' => 'progressive_color');


	$options[] = array(
		'name' => __('Revolution Slider "Light" Button Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_light_button_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider "Light" Button Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_light_button_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider "Light" Button Hover Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_light_button_hover_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider "Light" Button Hover Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_light_button_hover_background_color',
		'std' => '',
		'type' => 'progressive_color');


	$options[] = array(
		'name' => __('Revolution Slider "Colored" Button Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_colored_button_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider "Colored" Button Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_colored_button_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider "Colored" Button Hover Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_colored_button_hover_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Revolution Slider "Colored" Button Hover Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_revslider_colored_button_hover_background_color',
		'std' => '',
		'type' => 'progressive_color');


	$options[] = array(
		'name' => __('Nivo Slider Paginator Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_nivoslider_paginator_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Nivo Slider Paginator Opacity', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_nivoslider_paginator_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Nivo Slider Current Paginator Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_nivoslider_current_paginator_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Nivo Slider Current Paginator Opacity', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_nivoslider_current_paginator_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Nivo Slider Hover Paginator Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_nivoslider_hover_paginator_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Nivo Slider Hover Paginator Opacity', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_nivoslider_hover_paginator_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Nivo Slider Nav Arrow Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_nivoslider_nav_arrow_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Nivo Slider Nav Arrow Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_nivoslider_nav_arrow_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Nivo Slider Nav Arrow Background Opacity', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_nivoslider_nav_arrow_background_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Nivo Slider Nav Arrow Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_nivoslider_nav_arrow_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Nivo Slider Nav Arrow Background Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_nivoslider_nav_arrow_hover_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Nivo Slider Nav Arrow Background Hover Opacity', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_nivoslider_nav_arrow_hover_background_opacity',
		'std' => '',
		'type' => 'text');

//	Flexslider

	$options[] = array(
		'name' => __('Flexslider Nav Arrow Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_flexslider_nav_arrow_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Flexslider Nav Arrow Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_flexslider_nav_arrow_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Flexslider Nav Arrow Background Opacity', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_flexslider_nav_arrow_background_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Flexslider Nav Arrow Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_flexslider_nav_arrow_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Flexslider Nav Arrow Background Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_flexslider_nav_arrow_hover_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Flexslider Nav Arrow Background Hover Opacity', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_flexslider_nav_arrow_hover_background_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Flexslider Caption Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_flexslider_caption_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Flexslider Caption Background Opacity', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_flexslider_caption_background_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Flexslider Caption Heading Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_flexslider_caption_heading_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Flexslider Caption Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_flexslider_caption_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Filter Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_filter_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Filter Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_filter_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Filter Current Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_filter_current_color',
		'std' => '',
		'type' => 'progressive_color');




	$options[] = array(
		'name' => __('Portfolio Icon Filter Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_icon_filter_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Icon Filter Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_icon_filter_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Icon Filter Current Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_icon_filter_current_color',
		'std' => '',
		'type' => 'progressive_color');



	$options[] = array(
		'name' => __('Portfolio Overlay Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_overlay_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Overlay Background Opacity', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_overlay_background_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Portfolio Overlay Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_overlay_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Overlay Icon Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_overlay_icon_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Overlay Divider Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_overlay_divider_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Overlay Divider Opacity', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_overlay_divider_opacity',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Portfolio Pagination Arrow Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_pagination_arrow_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Pagination Arrow Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_pagination_arrow_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Pagination Arrow Disabled Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_pagination_arrow_disabled_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Pagination Page Number Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_pagination_page_number_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Pagination Page Number Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_pagination_page_number_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Pagination Current Page Number Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_pagination_current_page_number_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Title Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_title_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Category Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_category_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Category Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_category_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Excerpt Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_excerpt_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Item Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_item_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Item Link Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_item_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Item Link Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_item_link_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Item Categories Heading Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_item_categories_heading_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Item Category Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_item_category_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Nav Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_nav_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Nav Title Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_nav_title_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Nav Category Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_nav_category_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Nav Category Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_nav_category_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Nav Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_nav_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Portfolio Nav Icon Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_portfolio_nav_icon_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Pagination Button Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_pagination_button_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Pagination Button Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_pagination_button_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Pagination Button Background Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_pagination_button_background_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Pagination Button Text Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_pagination_button_text_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Pagination Disabled Button Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_pagination_disabled_button_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Pagination Disabled Button Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_pagination_disabled_button_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Pagination Current Page Button Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_pagination_current_page_button_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Pagination Current Page Button Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_pagination_current_page_button_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Post Preview Date Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_post_preview_date_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Post Preview Date Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_post_preview_date_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Post Preview Meta Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_post_preview_meta_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Post Preview Meta Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_post_preview_meta_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Post Preview Meta Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_post_preview_meta_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Post Preview Meta Icon Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_post_preview_meta_icon_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Post Preview Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_post_preview_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Post Preview Title Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_post_preview_title_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Post Preview Excerpt Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_post_preview_excerpt_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Post Preview Read More Button Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_post_preview_readmorebutton_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Post Preview Read More Button Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_post_preview_readmorebutton_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Post Preview Read More Button Background Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_post_preview_readmorebutton_background_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Post Preview Read More Button Text Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_post_preview_readmorebutton_text_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Blog Divider Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_blog_divider_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Date Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_date_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Date Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_date_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Meta Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_meta_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Meta Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_meta_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Meta Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_meta_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Meta Icon Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_meta_icon_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Title Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_title_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Bottom Divider Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_bottom_divider_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Author Label Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_author_label_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Author Link Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_author_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Author Link Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_author_link_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Tag Label Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_tag_label_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Tag Link Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_tag_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Tag Link Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_tag_link_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Nav Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_nav_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Nav Button Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_nav_button_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Nav Button Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_nav_button_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Nav Button Background Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_nav_button_background_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Nav Button Text Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_nav_button_text_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comments Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comments_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comments Author Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comments_author_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comments Link Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comments_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comments Link Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comments_link_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comments Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comments_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comment Form Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comment_form_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comment Form Label Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comment_form_label_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comment Form Input Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comment_form_input_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comment Form Input Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comment_form_input_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comment Form Input Placeholder Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comment_form_input_placeholder_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comment Form Button Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comment_form_button_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comment Form Button Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comment_form_button_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comment Form Button Background Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comment_form_button_background_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Post Comment Form Button Text Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_post_comment_form_button_text_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Form Label Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_form_label_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Form Input Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_form_input_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Form Input Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_form_input_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Form Input Placeholder Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_form_input_placeholder_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Form Button Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_form_button_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Form Button Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_form_button_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Form Button Background Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_form_button_background_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Form Button Text Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'main_content_form_button_text_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content Background Color', 'options_check'),
		'desc' => __('The background color.', 'options_check'),
		'id' => 'main_content_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Main Content Background Image', 'options_check'),
		'desc' => __('Choose an image to use as the background (optional).', 'options_check'),
		'id' => 'custom_main_content_background',
		'class' => 'background-image-only',
		'std' => $background_defaults,
		'type' => 'background');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Sidebar Colors</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Sidebar Widget Title Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'sidebar_widget_title_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Sidebar Widget Heading Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'sidebar_widget_heading_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Sidebar Widget Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'sidebar_widget_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Sidebar Widget Link Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'sidebar_widget_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Sidebar Widget Link Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'sidebar_widget_link_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Sidebar Twitter Widget Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'sidebar_widget_twitter_widget_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Sidebar Navigation Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'sidebar_navigation_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Sidebar Navigation Border Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'sidebar_navigation_border_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Sidebar Navigation Link Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'sidebar_navigation_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Sidebar Navigation Link Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'sidebar_navigation_link_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Sidebar Navigation Current Page Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'sidebar_navigation_current_page_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Sidebar Navigation Current Page Link Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'sidebar_navigation_current_page_link_color',
		'std' => '',
		'type' => 'progressive_color');


	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Footer Colors</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Footer Heading Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'footer_heading_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'footer_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Link Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'footer_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Link Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'footer_link_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Button Text Color', 'options_check'),
		'desc' => __('.', 'options_check'),
		'id' => 'footer_button_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Button Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'footer_button_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Button Text Hover Color', 'options_check'),
		'desc' => __('.', 'options_check'),
		'id' => 'footer_button_text_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Button Hover Background Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'footer_button_background_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Form Input Text Color', 'options_check'),
		'desc' => __('.', 'options_check'),
		'id' => 'footer_form_input_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Form Input Background Color', 'options_check'),
		'desc' => __('.', 'options_check'),
		'id' => 'footer_form_input_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Form Input Active Text Color', 'options_check'),
		'desc' => __('.', 'options_check'),
		'id' => 'footer_form_input_active_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Form Input Active Background Color', 'options_check'),
		'desc' => __('.', 'options_check'),
		'id' => 'footer_form_input_active_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'footer_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Icon Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'footer_icon_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Background Color', 'options_check'),
		'desc' => __('The background color.', 'options_check'),
		'id' => 'footer_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Footer Background Image', 'options_check'),
		'desc' => __('Choose an image to use as the background (optional).', 'options_check'),
		'id' => 'custom_footer_background',
		'class' => 'background-image-only',
		'std' => $background_defaults,
		'type' => 'background');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Subfooter Colors</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Subfooter Text Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'subfooter_text_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Subfooter Link Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'subfooter_link_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Subfooter Link Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'subfooter_link_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Subfooter Icon Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'subfooter_icon_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Subfooter Icon Hover Color', 'options_check'),
		'desc' => __('', 'options_check'),
		'id' => 'subfooter_icon_hover_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Subfooter Background Color', 'options_check'),
		'desc' => __('The background color.', 'options_check'),
		'id' => 'subfooter_background_color',
		'std' => '',
		'type' => 'progressive_color');

	$options[] = array(
		'name' => __('Subfooter Background Image', 'options_check'),
		'desc' => __('Choose an image to use as the background (optional).', 'options_check'),
		'id' => 'custom_subfooter_background',
		'class' => 'background-image-only',
		'std' => $background_defaults,
		'type' => 'background');

	$options[] = array(
		'name' => __('Other', 'options_check'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('', 'options_check'),
		'desc' => __('<h3>Portfolio</h3>', 'options_check'),
		'class' => 'section-subheading',
		'type' => 'info');

	$options[] = array(
		'name' => __('Portfolio Slug', 'options_check'),
		'desc' => __('The slug to use for portfolio URL rewrite. <strong>You must go to WP-Admin > Settings > Permalinks and resave your permalink settings after changing this value.</strong>', 'options_check'),
		'id' => 'portfolio_slug',
		'std' => 'portfolio_items',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Portfolio Items Heading', 'options_check'),
		'desc' => __('The heading to show at the top of all portfolio items', 'options_check'),
		'id' => 'portfolio_items_heading',
		'std' => 'Our Work',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Portfolio Filter Heading', 'options_check'),
		'desc' => __('The heading to show above the filter listing in the portfolio item pages.', 'options_check'),
		'id' => 'portfolio_items_filter_heading',
		'std' => 'Skills & Technologies Involved',
		'class' => 'mini',
		'type' => 'text');


//	EXAMPLE OPTIONS
//	Below are examples of the various options the options framework contained in this theme supports.
//	Use them to add your options for use elsewhere.
//
//    $options[] = array(
//        'name' => __('Example Heading', 'options_check'),
//        'type' => 'heading');
//
//    $options[] = array(
//        'name' => __('Basic Settings', 'options_check'),
//        'type' => 'heading');
//
//    $options[] = array(
//        'name' => __('Input Text Mini', 'options_check'),
//        'desc' => __('A mini text input field.', 'options_check'),
//        'id' => 'example_text_mini',
//        'std' => 'Default',
//        'class' => 'mini',
//        'type' => 'text');
//
//    $options[] = array(
//        'name' => __('Input Text', 'options_check'),
//        'desc' => __('A text input field.', 'options_check'),
//        'id' => 'example_text',
//        'std' => 'Default Value',
//        'type' => 'text');
//
//    $options[] = array(
//        'name' => __('Textarea', 'options_check'),
//        'desc' => __('Textarea description.', 'options_check'),
//        'id' => 'example_textarea',
//        'std' => 'Default Text',
//        'type' => 'textarea');
//
//    $options[] = array(
//        'name' => __('Input Select Small', 'options_check'),
//        'desc' => __('Small Select Box.', 'options_check'),
//        'id' => 'example_select',
//        'std' => 'three',
//        'type' => 'select',
//        'class' => 'mini', //mini, tiny, small
//        'options' => $test_array);
//
//    $options[] = array(
//        'name' => __('Input Select Wide', 'options_check'),
//        'desc' => __('A wider select box.', 'options_check'),
//        'id' => 'example_select_wide',
//        'std' => 'two',
//        'type' => 'select',
//        'options' => $test_array);
//
//    $options[] = array(
//        'name' => __('Select a Category', 'options_check'),
//        'desc' => __('Passed an array of categories with cat_ID and cat_name', 'options_check'),
//        'id' => 'example_select_categories',
//        'type' => 'select',
//        'options' => $options_categories);
//
//    $options[] = array(
//        'name' => __('Select a Tag', 'options_check'),
//        'desc' => __('Passed an array of tags with term_id and term_name', 'options_check'),
//        'id' => 'example_select_tags',
//        'type' => 'select',
//        'options' => $options_tags);
//
//    $options[] = array(
//        'name' => __('Select a Page', 'options_check'),
//        'desc' => __('Passed an pages with ID and post_title', 'options_check'),
//        'id' => 'example_select_pages',
//        'type' => 'select',
//        'options' => $options_pages);
//
//    $options[] = array(
//        'name' => __('Input Radio (one)', 'options_check'),
//        'desc' => __('Radio select with default options "one".', 'options_check'),
//        'id' => 'example_radio',
//        'std' => 'one',
//        'type' => 'radio',
//        'options' => $test_array);
//
//    $options[] = array(
//        'name' => __('Example Info', 'options_check'),
//        'desc' => __('This is just some example information you can put in the panel.', 'options_check'),
//        'type' => 'info');
//
//    $options[] = array(
//        'name' => __('Input Checkbox', 'options_check'),
//        'desc' => __('Example checkbox, defaults to true.', 'options_check'),
//        'id' => 'example_checkbox',
//        'std' => '1',
//        'type' => 'checkbox');
//
//    $options[] = array(
//        'name' => __('Advanced Settings', 'options_check'),
//        'type' => 'heading');
//
//    $options[] = array(
//        'name' => __('Check to Show a Hidden Text Input', 'options_check'),
//        'desc' => __('Click here and see what happens.', 'options_check'),
//        'id' => 'example_showhidden',
//        'type' => 'checkbox');
//
//    $options[] = array(
//        'name' => __('Hidden Text Input', 'options_check'),
//        'desc' => __('This option is hidden unless activated by a checkbox click.', 'options_check'),
//        'id' => 'example_text_hidden',
//        'std' => 'Hello',
//        'class' => 'hidden',
//        'type' => 'text');
//
//    $options[] = array(
//        'name' => __('Uploader Test', 'options_check'),
//        'desc' => __('This creates a full size uploader that previews the image.', 'options_check'),
//        'id' => 'example_uploader',
//        'type' => 'upload');
//
//    $options[] = array(
//        'name' => "Example Image Selector",
//        'desc' => "Images for layout.",
//        'id' => "example_images",
//        'std' => "2c-l-fixed",
//        'type' => "images",
//        'options' => array(
//            '1col-fixed' => $imagepath . '1col.png',
//            '2c-l-fixed' => $imagepath . '2cl.png',
//            '2c-r-fixed' => $imagepath . '2cr.png')
//    );
//
//    $options[] = array(
//        'name' => __('Example Background', 'options_check'),
//        'desc' => __('Change the background CSS.', 'options_check'),
//        'id' => 'example_background',
//        'std' => $background_defaults,
//        'type' => 'background');
//
//    $options[] = array(
//        'name' => __('Multicheck', 'options_check'),
//        'desc' => __('Multicheck description.', 'options_check'),
//        'id' => 'example_multicheck',
//        'std' => $multicheck_defaults, // These items get checked by default
//        'type' => 'multicheck',
//        'options' => $multicheck_array);
//
//    $options[] = array(
//        'name' => __('Colorpicker', 'options_check'),
//        'desc' => __('No color selected by default.', 'options_check'),
//        'id' => 'example_colorpicker',
//        'std' => '',
//        'type' => 'progressive_color');
//
//    $options[] = array('name' => __('Typography', 'options_check'),
//        'desc' => __('Example typography.', 'options_check'),
//        'id' => "example_typography",
//        'std' => $typography_defaults,
//        'type' => 'typography');
//
//    $options[] = array(
//        'name' => __('Custom Typography', 'options_check'),
//        'desc' => __('Custom typography options.', 'options_check'),
//        'id' => "custom_typography",
//        'std' => $typography_defaults,
//        'type' => 'typography',
//        'options' => $typography_options);
//
//    $options[] = array(
//        'name' => __('Text Editor', 'options_check'),
//        'type' => 'heading');

	/**
	 * For $settings options see:
	 * http://codex.wordpress.org/Function_Reference/wp_editor
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */

//    $wp_editor_settings = array(
//        'wpautop' => true, // Default
//        'textarea_rows' => 5,
//        'tinymce' => array('plugins' => 'wordpress')
//    );
//
//    $options[] = array(
//        'name' => __('Default Text Editor', 'options_check'),
//        'desc' => sprintf(__('You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'options_check'), 'http://codex.wordpress.org/Function_Reference/wp_editor'),
//        'id' => 'example_editor',
//        'type' => 'editor',
//        'settings' => $wp_editor_settings);

	return $options;
}



/**
 * Returns an array of supported skins
 */

function adap_options_styling_get_skin_select_options()
{

	$ret_array = array();

	global $adap_skin_colors;
	foreach ($adap_skin_colors as $key => $value) {
		$name = str_replace('_', ' ', $key);
		$ret_array[$key] = __(ucwords($name), 'options_check');
	}

	return $ret_array;
}


/**
 * Returns an array of system fonts
 * Feel free to edit this, update the font fallbacks, etc.
 */

function adap_options_typography_get_os_fonts()
{
	// OS Font Defaults
	$os_faces = array(
		'Arial, sans-serif' => 'Arial',
		'"Avant Garde", sans-serif' => 'Avant Garde',
		'Cambria, Georgia, serif' => 'Cambria',
		'Copse, sans-serif' => 'Copse',
		'Garamond, "Hoefler Text", Times New Roman, Times, serif' => 'Garamond',
		'Georgia, serif' => 'Georgia',
		'"Helvetica Neue", Helvetica, sans-serif' => 'Helvetica Neue',
		'Tahoma, Geneva, sans-serif' => 'Tahoma'
	);
	return $os_faces;
}

/**
 * Returns a select list of Google fonts
 * Feel free to edit this, update the fallbacks, etc.
 */

function adap_options_typography_get_google_fonts()
{
	// Google Font Defaults
	$google_faces = array(
		'Arvo, serif' => 'Arvo',
		'Copse, sans-serif' => 'Copse',
		'Droid Sans, sans-serif' => 'Droid Sans',
		'Droid Serif, serif' => 'Droid Serif',
		'Lobster, cursive' => 'Lobster',
		'Nobile, sans-serif' => 'Nobile',
		'Open Sans, sans-serif' => 'Open Sans',
		'Oswald, sans-serif' => 'Oswald',
		'Pacifico, cursive' => 'Pacifico',
		'Rokkitt, serif' => 'Rokkit',
		'PT Sans, sans-serif' => 'PT Sans',
		'Quattrocento, serif' => 'Quattrocento',
		'Raleway, cursive' => 'Raleway',
		'Ubuntu, sans-serif' => 'Ubuntu',
		'Yanone Kaffeesatz, sans-serif' => 'Yanone Kaffeesatz'
	);
	return $google_faces;
}