<?php

/**
 * Reponsible for the frontend output of the theme options.
 */
class AdapThemeOptions
{
	/**
	 * Actually generate the dynamic CSS specified by the Theme Options
	 * @return string
	 */
	static function get_theme_options_css()
	{
		ob_start();

		// Print out backgrounds
		if (of_get_option('stretched_or_boxed') == 'boxed') {
			echo '@media (min-width: 767px) {';
				AdapThemeOptions::print_background_css_rule(of_get_option('site_background'), 'html');
			echo '}';
			AdapThemeOptions::print_background_css_rule(of_get_option('site_background'), 'html.lt-ie9');
		}


		// Insert Logo CSS
		AdapThemeOptions::print_site_logo_css_rule();

		// Skins -- Header
		AdapThemeOptions::print_background_and_color_css_rule(of_get_option('custom_header_background'), of_get_option('header_background_color'), '.navbar-inner, .enable-sticky-header .sticky-header-small .navbar-inner');
		AdapThemeOptions::print_color_css_rule(of_get_option('header_icon_color'), '.header-social-icon-list > li > a');
		AdapThemeOptions::print_color_css_rule(of_get_option('header_icon_hover_color'), '.header-social-icon-list > li > a:hover');
		AdapThemeOptions::print_border_left_color_css_rule(of_get_option('header_border_color'), '.header-social-icon-list:before');

		// Open Media Query -- Only apply to desktop widths
		echo '@media (min-width: 979px) {';
		AdapThemeOptions::print_color_css_rule(of_get_option('menu_item_color'), '.navbar .nav > li > a');
		AdapThemeOptions::print_color_css_rule(of_get_option('menu_item_color'), '.navbar .nav > li > a');
		AdapThemeOptions::print_color_css_rule(of_get_option('menu_item_hover_color'),
			'.navbar .nav > li > a:hover,
			.navbar .nav li.dropdown.open > .dropdown-toggle,
			.navbar .nav li.dropdown.active > .dropdown-toggle,
			.navbar .nav > li.current-menu-ancestor > a,
			.navbar .nav > li.current-menu-item > a');
		AdapThemeOptions::print_color_css_rule(of_get_option('submenu_item_color'), '.dropdown-menu > li > a');
		AdapThemeOptions::print_color_css_rule(of_get_option('submenu_item_hover_color'),
			'.dropdown-menu > li:hover > a,
			.dropdown-menu > li.current-menu-ancestor > a,
			.dropdown-menu > li.current-menu-item > a,
			.dropdown-menu > li.current-menu-item:hover > a');
		AdapThemeOptions::print_background_and_color_css_rule(of_get_option('submenu_background_image'), of_get_option('submenu_background_color'), '.dropdown-menu');
		echo '}';
		// Needs to be repeated outside media query for IE8
		AdapThemeOptions::print_color_css_rule(of_get_option('menu_item_color'), '.lt-ie9 .navbar .nav > li > a');
		AdapThemeOptions::print_color_css_rule(of_get_option('menu_item_color'), '.lt-ie9 .navbar .nav > li > a');
		AdapThemeOptions::print_color_css_rule(of_get_option('menu_item_hover_color'),
			'.lt-ie9 .navbar .nav > li > a:hover,
			.navbar .nav li.dropdown.open > .dropdown-toggle,
			.navbar .nav li.dropdown.active > .dropdown-toggle,
			.navbar .nav > li.current-menu-ancestor > a,
			.navbar .nav > li.current-menu-item > a');
		AdapThemeOptions::print_color_css_rule(of_get_option('submenu_item_color'), '.dropdown-menu > li > a');
		AdapThemeOptions::print_color_css_rule(of_get_option('submenu_item_hover_color'),
			'.dropdown-menu > li:hover > a,
			.dropdown-menu > li.current-menu-ancestor > a,
			.dropdown-menu > li.current-menu-item > a,
			.dropdown-menu > li.current-menu-item:hover > a');
		AdapThemeOptions::print_background_and_color_css_rule(of_get_option('submenu_background_image'), of_get_option('submenu_background_color'), '.dropdown-menu');

		// Close Media Query
		// Open Mobile Query
		echo '@media (max-width: 979px) {';
		AdapThemeOptions::print_background_and_color_css_rule(of_get_option('mobile_menu_background'), of_get_option('mobile_menu_background_color'), '.nav-collapse, .nav-collapse.collapse');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('menu_item_color'), '.navbar .btn-navbar.collapsed .icon-bar');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('menu_item_hover_color'), '.navbar .btn-navbar .icon-bar');
		AdapThemeOptions::print_color_css_rule(of_get_option('mobile_menu_item_color'),
			'.navbar .nav > li.menu-depth-0 > a,
			.navbar .nav > li.menu-depth-0 > a:hover,
			.navbar .nav li.dropdown.open > .dropdown-toggle,
			.navbar .nav li.dropdown.active > .dropdown-toggle,
			.navbar .nav li.dropdown.open.active > .dropdown-toggle');
		AdapThemeOptions::print_color_css_rule(of_get_option('mobile_submenu_item_color'),
			'.nav-collapse .nav > li > a,
			.nav-collapse .dropdown-menu a,
			.nav-collapse .dropdown-menu a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('mobile_menu_current_item_color'),
			'.nav > li.current-menu-item > a,
			.navbar .nav li.dropdown.active.current-menu-item > .dropdown-toggle,
			.nav-collapse .nav > li.current-menu-item > a,
			.nav-collapse .dropdown-menu li.current-menu-item a,
			.nav-collapse .dropdown-menu li.current-menu-item a:hover');
		echo '}';
		// Close Mobile Query

		// Skins -- Subfooter
		AdapThemeOptions::print_background_and_color_css_rule(of_get_option('custom_subfooter_background'), of_get_option('subfooter_background_color'), '.subfooter');
		AdapThemeOptions::print_color_css_rule(of_get_option('subfooter_text_color'), '.footer .subfooter, .footer .subfooter p');
		AdapThemeOptions::print_color_css_rule(of_get_option('subfooter_link_color'), '.footer .subfooter a');
		AdapThemeOptions::print_color_css_rule(of_get_option('subfooter_link_hover_color'),
			'.footer .subfooter a:hover,
			.footer .subfooter a:focus,
			.footer .footer-nav > li > a:hover,
			.footer .footer-nav > li > a:focus');
		AdapThemeOptions::print_color_css_rule(of_get_option('subfooter_icon_color'), '.footer .subfooter-social-icon-list li a');
		AdapThemeOptions::print_color_css_rule(of_get_option('subfooter_icon_hover_color'), '.footer .subfooter-social-icon-list li a:hover');

		// Skins -- Footer
		AdapThemeOptions::print_background_and_color_css_rule(of_get_option('custom_footer_background'), of_get_option('footer_background_color'), '.footer');
		$footer_form_input_selector = '.footer textarea,
			.footer input[type="text"],
			.footer input[type="password"],
			.footer input[type="datetime"],
			.footer input[type="datetime-local"],
			.footer input[type="date"],
			.footer input[type="month"],
			.footer input[type="time"],
			.footer input[type="week"],
			.footer input[type="number"],
			.footer input[type="email"],
			.footer input[type="url"],
			.footer input[type="search"],
			.footer input[type="tel"],
			.footer input[type="color"],
			.footer .uneditable-input';
		$footer_focus_form_input_selector = '.footer textarea:focus,
			.footer input[type="text"]:focus,
			.footer input[type="password"]:focus,
			.footer input[type="datetime"]:focus,
			.footer input[type="datetime-local"]:focus,
			.footer input[type="date"]:focus,
			.footer input[type="month"]:focus,
			.footer input[type="time"]:focus,
			.footer input[type="week"]:focus,
			.footer input[type="number"]:focus,
			.footer input[type="email"]:focus,
			.footer input[type="url"]:focus,
			.footer input[type="search"]:focus,
			.footer input[type="tel"]:focus,
			.footer input[type="color"]:focus,
			.footer .uneditable-input:focus';
		$footer_placeholder_selector_moz = '.footer :-moz-placeholder';
		$footer_placeholder_selector_moz2 = '.footer ::-moz-placeholder';
		$footer_placeholder_selector_webkit = '.footer ::-webkit-input-placeholder';
		$footer_placeholder_selector_ie10 = '.footer :-ms-input-placeholder';
		$footer_placeholder_selector_ie9 = '.footer :-ms-input-placeholder';
		$footer_focus_placeholder_selector_moz = '.footer :focus:-moz-placeholder';
		$footer_focus_placeholder_selector_moz2 = '.footer :focus::-moz-placeholder';
		$footer_focus_placeholder_selector_webkit = '.footer :focus::-webkit-input-placeholder';
		$footer_focus_placeholder_selector_ie10 = '.footer :focus:-ms-input-placeholder';
		$footer_focus_placeholder_selector_ie9 = '.footer :focus:-ms-input-placeholder';
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_heading_color'), '.footer .widgettitle, .footer .widgettitle a, .footer .widgettitle label');
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_text_color'), '.footer, .footer p, .footer li');
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_link_color'), '.footer a, .footer a:focus');
		AdapThemeOptions::print_border_color_css_rule(of_get_option('footer_link_color'), 'abbr[title], abbr[data-original-title]');
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_link_hover_color'), '.footer a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_button_text_color'), '.footer .btn, .footer button, .footer input[type="submit"]');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('footer_button_background_color'), '.footer .btn, .footer button, .footer input[type="submit"]');
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_button_text_hover_color'), '.footer .btn:hover, .footer button:hover, .footer input[type="submit"]:hover');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('footer_button_background_hover_color'), '.footer .btn:hover, .footer button:hover, .footer input[type="submit"]:hover');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('footer_form_input_background_color'), $footer_form_input_selector);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_text_color'), $footer_form_input_selector);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_text_color'), $footer_placeholder_selector_moz);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_text_color'), $footer_placeholder_selector_moz2);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_text_color'), $footer_placeholder_selector_webkit);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_text_color'), $footer_placeholder_selector_ie10);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_text_color'), $footer_placeholder_selector_ie9);
		AdapThemeOptions::print_background_color_css_rule(of_get_option('footer_form_input_active_background_color'), $footer_focus_form_input_selector);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_active_color'), $footer_form_input_selector);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_active_color'), $footer_form_input_selector);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_active_color'), $footer_focus_placeholder_selector_moz);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_active_color'), $footer_focus_placeholder_selector_moz2);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_active_color'), $footer_focus_placeholder_selector_webkit);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_active_color'), $footer_focus_placeholder_selector_ie10);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_active_color'), $footer_focus_placeholder_selector_ie9);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_form_input_active_color'), $footer_focus_placeholder_selector_ie9);
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_icon_color'),
			'.footer a.icon-shortcode, .footer a.icon-shortcode i, .footer a.icon-shortcode:focus, .footer a.icon-shortcode:focus i');
		AdapThemeOptions::print_color_css_rule(of_get_option('footer_icon_hover_color'),
			'.footer a.icon-shortcode:hover, .footer a.icon-shortcode:hover i, .footer a.icon-shortcode:focus:hover, .footer a.icon-shortcode:focus:hover i');

		// Skins -- Subheader
		AdapThemeOptions::print_color_css_rule(of_get_option('breadcrumb_link_color'), '.theme-breadcrumbs a, .theme-breadcrumbs a:after');
		AdapThemeOptions::print_color_css_rule(of_get_option('breadcrumb_link_hover_color'), '.theme-breadcrumbs a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('breadcrumb_current_page_color'), '.theme-breadcrumbs');
		AdapThemeOptions::print_color_css_rule(of_get_option('page_title_color'), '.subhead h1');
		AdapThemeOptions::print_background_and_color_css_rule(of_get_option('subheader_background_image'), of_get_option('subheader_background_color'), '.subhead');

		// Skins -- Main Content
		AdapThemeOptions::print_background_and_color_css_rule(of_get_option('custom_main_content_background'), of_get_option('main_content_background_color'), 'body');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_heading1_color'), 'h1, .h1, .page-title-404, .page-404-error');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_heading2_color'), 'h2, .h2');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_heading3_color'), 'h3, .h3');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_heading4_color'), 'h4, .h4');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_heading5_color'), 'h5, .h5');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_heading6_color'), 'h6, .h6, h6 strong');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_text_color'), 'body, p, li');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_bolded_text_color'), 'strong');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_link_color'), 'a, a:focus');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_link_hover_color'), 'a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_lead_color'), '.lead, .hero-unit .lead');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_intro_color'), '.intro, .hero-unit .intro');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_fullwidth_row_background_color'), '.full-width-section');


		// Shortcodes
		AdapThemeOptions::print_border_color_css_rule(of_get_option('main_content_border_color'), '.divider-shortcode, .blockquote-shortcode.blockquote-style-style2 blockquote');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blockquote_text_color'), '.blockquote-shortcode, .blockquote-shortcode p');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_blockquote_text_color'),
			'.blockquote-shortcode .blockquote-left-border, .blockquote-shortcode .top-divider, .blockquote-shortcode .bottom-divider');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blockquote_reverse_text_color'),
			'.blockquote-shortcode.blockquote-style-style1, .blockquote-shortcode.blockquote-style-style1 p');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_blockquote_reverse_text_color'),
			'.blockquote-shortcode.blockquote-style-style1 .blockquote-left-border, blockquote');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_blockquote_background_color'), '.blockquote-shortcode.blockquote-style-style1, blockquote');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_dropcap_text_color'), '.dropcap-shortcode');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_dropcap_background_color'), '.dropcap-shortcode.dropcap-style-style2');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_dropcap_reverse_text_color'), '.dropcap-shortcode.dropcap-style-style2');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_tooltip_link_color'), '.tooltip-shortcode, .tooltip-shortcode:hover');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_tooltip_background_color'), '.tooltip-inner');
		AdapThemeOptions::print_border_top_color_css_rule(of_get_option('main_content_tooltip_background_color'),
			'.tooltip.top .tooltip-arrow');
		AdapThemeOptions::print_border_bottom_color_css_rule(of_get_option('main_content_tooltip_background_color'),
			'.tooltip.bottom .tooltip-arrow');
		AdapThemeOptions::print_border_right_color_css_rule(of_get_option('main_content_tooltip_background_color'),
			'.tooltip.right .tooltip-arrow');
		AdapThemeOptions::print_border_left_color_css_rule(of_get_option('main_content_tooltip_background_color'),
			'.tooltip.left .tooltip-arrow');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_highlight_background_color'), '.highlight-shortcode');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_highlight_text_color'), '.highlight-shortcode');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_list_icon_color'), '.list-shortcode i');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_list_text_color'), 'li');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_label_text_color'), '.label-shortcode');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_label_background_color'), '.label-shortcode');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_badge_text_color'), '.badge-shortcode');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_badge_background_color'), '.badge-shortcode');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_popover_link_color'), '.popover-shortcode, .popover-shortcode:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_popover_heading_color'), '.popover-title');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_popover_text_color'), '.popover-content');

//		Accordion
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_accordion_link_color'),
			'.accordion-style-style1 .accordion-heading .accordion-toggle.collapsed:hover,
			.accordion-style-style1 .accordion-heading .accordion-toggle.collapsed,
			.accordion-style-style1 .accordion-heading .accordion-toggle.collapsed:hover .accordion-title-wrapper,
			.accordion-style-style1 .accordion-heading .accordion-toggle.collapsed .accordion-title-wrapper');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_accordion_link_active_color'),
			'.accordion-style-style1 .accordion-heading .accordion-toggle:hover,
			.accordion-style-style1 .accordion-heading .accordion-toggle,
			.accordion-style-style1 .accordion-heading .accordion-toggle:hover .accordion-title-wrapper,
			.accordion-style-style1 .accordion-heading .accordion-toggle .accordion-title-wrapper');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_accordion_active_background_color'),
			'.accordion-style-style2 .accordion-heading .accordion-toggle');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_accordion_active_reverse_link_color'),
			'.accordion-style-style2 .accordion-heading .accordion-toggle');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_accordion_background_color'),
			'.accordion-style-style2 .accordion-heading .accordion-toggle.collapsed');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_accordion_reverse_link_color'),
			'.accordion-style-style2 .accordion-heading .accordion-toggle.collapsed');
		AdapThemeOptions::print_border_bottom_color_css_rule(of_get_option('main_content_accordion_divider_color'),
			'.accordion-style-style1 .accordion-group');

//		Alerts
		AdapThemeOptions::print_border_color_css_rule(of_get_option('main_content_alert_border_color'),
			'.alert');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_alert_background_color'),
			'.alert');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_alert_text_color'),
			'.alert, .alert p, .alert .close');

//		Counter Circle
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_counter_circle_label_color'),
			'.animated-circle-intro, .animated-circle-label');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_counter_circle_background_color'),
			'.animated-circle-wrapper canvas');

//		Counter Boxes
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_counter_box_percentage_color'),
			'.count-wrapper');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_counter_box_caption_color'),
			'.count-caption');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_counter_box_background_color'),
			'.count-box');

//		Progress Bars
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_progress_bar_icon_color'),
			'.progress-bar-icon');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_progress_bar_label_color'),
			'.progress-bar-label');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_progress_bar_background_color'),
			'.progress-bar-label-wrapper');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_progress_bar_color'),
			'.progress .bar');

//		Buttons
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_button_background_color'),
			'.btn, button, input[type="submit"], .btn:active');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_button_hover_background_color'),
			'.btn:hover, button:hover, input[type="submit"]:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_button_text_color'),
			'.btn, button, input[type="submit"], .btn:active');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_button_hover_text_color'),
			'.btn:hover, button:hover, input[type="submit"]:hover');

//		Content Boxes
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox1_title_color'),
			'.box-shortcode-style1 .box-shortcode-heading');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox1_icon_color'),
			'.box-shortcode-style1 .box-shortcode-icon');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox2_title_color'),
			'.box-shortcode-style2 .box-shortcode-heading');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox2_icon_color'),
			'.box-shortcode-style2 .box-shortcode-icon');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_contentbox2_background_color'),
			'.box-shortcode-style2 .box-shortcode-icon-wrapper');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox3_title_color'),
			'.box-shortcode-style3 .box-shortcode-heading');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox3_icon_color'),
			'.box-shortcode-style3 .box-shortcode-icon');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_contentbox3_background_color'),
			'.box-shortcode-style3 .box-shortcode-icon-wrapper');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox4_title_color'),
			'.box-shortcode-style4 .box-shortcode-heading');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox4_icon_color'),
			'.box-shortcode-style4 .box-shortcode-icon');
		AdapThemeOptions::print_border_color_css_rule(of_get_option('main_content_contentbox4_border_color'),
			'.box-shortcode-style4 .box-shortcode-icon-wrapper');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox5_title_color'),
			'.box-shortcode-style5 .box-shortcode-heading');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox5_icon_color'),
			'.box-shortcode-style5 .box-shortcode-icon');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox6_title_color'),
			'.box-shortcode-style6 .box-shortcode-heading');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox6_icon_color'),
			'.box-shortcode-style6 .box-shortcode-icon');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_contentbox6_background_color'),
			'.box-shortcode-style6 .box-shortcode-icon-wrapper');
		AdapThemeOptions::print_border_color_css_rule(of_get_option('main_content_contentbox6_border_color'),
			'.box-shortcode-style6 .box-shortcode-icon-wrapper');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox6_content_color'),
			'.box-shortcode-style6 .box-shortcode-content, .box-shortcode-style6 .box-shortcode-content p');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_contentbox6_content_background_color'),
			'.box-shortcode-style6 .box-shortcode-inner-wrapper');

		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_contentbox6_button_background_color'),
			'.box-shortcode-style6 .btn, .box-shortcode-style6 button, .box-shortcode-style6 input[type="submit"], .box-shortcode-style6 .btn:active');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_contentbox6_button_background_hover_color'),
			'.box-shortcode-style6 .btn:hover, .box-shortcode-style6 button:hover, .box-shortcode-style6 input[type="submit"]:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox6_button_text_color'),
			'.box-shortcode-style6 .btn, .box-shortcode-style6 button, .box-shortcode-style6 input[type="submit"], .box-shortcode-style6 .btn:active');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_contentbox6_button_text_hover_color'),
			'.box-shortcode-style6 .btn:hover, .box-shortcode-style6 button:hover, .box-shortcode-style6 input[type="submit"]:hover');


		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_icon_color'),
			'.icon-circle-background i');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_icon_background_color'),
			'.icon-circle-background');
		AdapThemeOptions::print_border_color_css_rule(of_get_option('main_content_icon_border_color'),
			'.icon-circle-background');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_icon_hover_color'),
			'.icon-circle-background:hover i');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_icon_hover_background_color'),
			'.icon-circle-background:hover');
		AdapThemeOptions::print_border_color_css_rule(of_get_option('main_content_icon_hover_border_color'),
			'.icon-circle-background:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_icon_wo_circle_color'),
			'.icon-shortcode.no-circle-background i');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_icon_wo_circle_hover_color'),
			'.icon-shortcode.no-circle-background:hover i');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_profile_name_color'),
			'.adap-profile-shortcode .profile-name');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_profile_title_color'),
			'.adap-profile-shortcode .profile-title');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_profile_social_icon_color'),
			'.adap-profile-shortcode .profile-social-links a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_profile_social_icon_hover_color'),
			'.adap-profile-shortcode .profile-social-links a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_pricing_plan_header_color'),
			'.pricing-plan-title');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_pricing_plan_price_color'),
			'.pricing-plan-header');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_pricing_plan_header_background_color'),
			'.pricing-plan-header');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_pricing_plan_header_background_color'),
			'.pricing-plan-header');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_pricing_plan_details_color'),
			'.pricing-plan-details, .pricing-plan-details p, .pricing-plan-details li');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_pricing_plan_details_background_color'),
			'.pricing-plan-details');
		AdapThemeOptions::print_border_color_css_rule(of_get_option('main_content_pricing_table_border_color'),
			'.pricing-table, .pricing-table .pricing-plan-shortcode, .pricing-table .pricing-plan-header,
			.pricing-table .pricing-plan-price-wrapper, .pricing-table .pricing-plan-details,
			.pricing-table .pricing-plan-details ul, .pricing-table .pricing-plan-details li');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_pricing_table_header_color'),
			'.pricing-table .pricing-plan-title');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_pricing_table_price_color'),
			'.pricing-table .pricing-plan-header');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_pricing_table_header_background_color'),
			'.pricing-table .pricing-plan-header');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_pricing_table_details_color'),
			'.pricing-table .pricing-plan-details, .pricing-table .pricing-plan-details p, .pricing-table .pricing-plan-details li');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_pricing_table_details_background_color'),
			'.pricing-table .pricing-plan-details');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_pricing_table_details_alternate_background_color'),
			'.pricing-table .pricing-plan-details li:nth-child(odd)');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_pricing_table_featured_header_color'),
			'.pricing-table .pricing-plan-featured .pricing-plan-title');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_pricing_table_featured_header_background_color'),
			'.pricing-table .pricing-plan-featured .pricing-plan-title-wrapper');
		AdapThemeOptions::print_border_color_css_rule(of_get_option('main_content_pricing_table_featured_header_background_color'),
			'.pricing-table .pricing-plan-featured .pricing-plan-title-wrapper');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_posts_sc_title_color'),
			'.recent-posts-shortcode .article-header .h2, .recent-posts-shortcode .article-header .h2 a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_posts_sc_title_hover_color'),
			'.recent-posts-shortcode .article-header .h2 a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_posts_sc_date_color'),
			'.recent-posts-shortcode time');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_posts_sc_comment_count_color'),
			'.recent-posts-shortcode .byline-comments a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_posts_sc_comment_count_hover_color'),
			'.recent-posts-shortcode .byline-comments a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_tab_heading_color'),
			'.nav-tabs > li > a.tab-shortcode-tab');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_tab_heading_background_color'),
			'.nav-tabs > li > a.tab-shortcode-tab');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_tab_active_heading_color'),
			'.nav-tabs > .active > a.tab-shortcode-tab, .nav-tabs > .active > a.tab-shortcode-tab:hover');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_tab_active_heading_background_color'),
			'.nav-tabs > .active > a.tab-shortcode-tab, .nav-tabs > .active > a.tab-shortcode-tab:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_tab_hover_heading_color'),
			'.nav-tabs > li > a.tab-shortcode-tab:hover');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_tab_hover_heading_background_color'),
			'.nav-tabs > li > a.tab-shortcode-tab:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_tab_content_color'),
			'.tab-content, .tab-content p, .tab-content li');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_tab_content_background_color'),
			'.tab-content');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_hero_unit_background_color'),
			'.hero-unit');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_hero_unit_text_color'),
			'.hero-unit, .hero-unit p, .hero-unit li');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_hero_unit_heading_color'),
			'.hero-unit h1, .hero-unit h2, .hero-unit h3, .hero-unit h4, .hero-unit h5, .hero-unit h6');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_thumbnail_background_color'),
			'.thumbnail-shortcode');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_thumbnail_text_color'),
			'.thumbnail-shortcode, .thumbnail-shortcode p, .thumbnail-shortcode li');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_thumbnail_heading_color'),
			'.thumbnail-shortcode h1, .thumbnail-shortcode h2, .thumbnail-shortcode h3, .thumbnail-shortcode h4, .thumbnail-shortcode h5, .thumbnail-shortcode h6');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_testimonial1_background_color'),
			'.testimonial-shortcode.testimonial-shortcode-style-style1 .testimonials-text');
		AdapThemeOptions::print_border_top_color_css_rule(of_get_option('main_content_testimonial1_background_color'),
			'.testimonial-shortcode.testimonial-shortcode-style-style1 .arrow-down');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_testimonial1_text_color'),
			'.testimonial-shortcode.testimonial-shortcode-style-style1 .testimonials-text');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_testimonial1_author_name_color'),
			'.testimonial-shortcode.testimonial-shortcode-style-style1 .author-name');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_testimonial1_author_title_color'),
			'.testimonial-shortcode.testimonial-shortcode-style-style1 .author-title');

		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_testimonial2_background_color'),
			'.testimonial-shortcode.testimonial-shortcode-style-style2 .testimonials-text');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_testimonial2_text_color'),
			'.testimonial-shortcode.testimonial-shortcode-style-style2 .testimonials-text');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_testimonial2_author_name_color'),
			'.testimonial-shortcode.testimonial-shortcode-style-style2 .author-name,
			.testimonial-shortcode.testimonial-shortcode-style-style2 .testimonial-shortcode-user-icon,
			.testimonial-shortcode.testimonial-shortcode-style-style2 .testimonial-shortcode-user-chevron');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_testimonial2_author_title_color'),
			'.testimonial-shortcode.testimonial-shortcode-style-style2 .author-title');


		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_revslider_paginator_color'),
			of_get_option('main_content_revslider_paginator_opacity'),
			'.tp-bullets.simplebullets.round .bullet');
		AdapThemeOptions::print_background_and_opacity_msie_css_rule(of_get_option('main_content_revslider_paginator_color'),
			of_get_option('main_content_revslider_paginator_opacity'),
			'.lt-ie9 .tp-bullets.simplebullets.round .bullet');
		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_revslider_current_paginator_color'),
			of_get_option('main_content_revslider_current_paginator_opacity'),
			'.tp-bullets.simplebullets.round .bullet.selected');
		AdapThemeOptions::print_background_and_opacity_msie_css_rule(of_get_option('main_content_revslider_current_paginator_color'),
			of_get_option('main_content_revslider_current_paginator_opacity'),
			'.lt-ie9 .tp-bullets.simplebullets.round .bullet.selected');
		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_revslider_big_nav_arrow_color'),
			of_get_option('main_content_revslider_big_nav_arrow_opacity'),
			'.big-arrows .tparrows.default');
		AdapThemeOptions::print_background_and_opacity_msie_css_rule(of_get_option('main_content_revslider_big_nav_arrow_color'),
			of_get_option('main_content_revslider_big_nav_arrow_opacity'),
			'.lt-ie9 .big-arrows .tparrows.default');
		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_revslider_big_nav_arrow_hover_color'),
			of_get_option('main_content_revslider_big_nav_arrow_hover_opacity'),
			'.no-touch .tparrows.default:hover');
		AdapThemeOptions::print_background_and_opacity_msie_css_rule(of_get_option('main_content_revslider_big_nav_arrow_hover_color'),
			of_get_option('main_content_revslider_big_nav_arrow_hover_opacity'),
			'.lt-ie9.no-touch .tparrows.default:hover');
		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_revslider_small_nav_arrow_color'),
			of_get_option('main_content_revslider_small_nav_arrow_opacity'),
			'.small-arrows .tparrows.default');
		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_revslider_small_nav_arrow_hover_color'),
			of_get_option('main_content_revslider_small_nav_arrow_hover_opacity'),
			'.small-arrows .tparrows.default:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_revslider_dark_caption_color'),
			'.tp-caption.twish_big_dark_heading_thin, .tp-caption.twish_dark_heading,
			.tp-caption.twish_big_dark_heading, .tp-caption.twish_regular_dark_text,
			.tp-caption.twish_big_dark_text, .tp-caption.twish_regular_dark_text_right_align');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_revslider_light_caption_color'),
			'.tp-caption.twish_large_light_text, .tp-caption.twish_light_heading,
			.tp-caption.twish_big_light_heading, .tp-caption.twish_thin_light_heading,
			.tp-caption.twish_regular_light_text, .tp-caption.twish_regular_light_text_align_right,
			.tp-caption.twish_big_light_text ');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_revslider_colored_caption_color'),
			'.tp-caption.twish_big_color_heading');


		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_revslider_dark_button_background_color'),
			'.tp-caption.twish_dark_button .btn,
			.tp-caption.twish_dark_button button,
			.tp-caption.twish_dark_button input[type="submit"],
			.tp-caption.twish_dark_button .btn:active');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_revslider_dark_button_hover_background_color'),
			'.tp-caption.twish_dark_button .btn:hover,
			.tp-caption.twish_dark_button button:hover,
			.tp-caption.twish_dark_button input[type="submit"]:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_revslider_dark_button_text_color'),
			'.tp-caption.twish_dark_button .btn,
			.tp-caption.twish_dark_button button,
			.tp-caption.twish_dark_button input[type="submit"],
			.tp-caption.twish_dark_button .btn:active');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_revslider_dark_button_hover_text_color'),
			'.tp-caption.twish_dark_button .btn:hover,
			.tp-caption.twish_dark_button button:hover,
			.tp-caption.twish_dark_button input[type="submit"]:hover');

		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_revslider_light_button_background_color'),
			'.tp-caption.twish_light_button .btn,
			.tp-caption.twish_light_button button,
			.tp-caption.twish_light_button input[type="submit"],
			.tp-caption.twish_light_button .btn:active');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_revslider_light_button_hover_background_color'),
			'.tp-caption.twish_light_button .btn:hover,
			.tp-caption.twish_light_button button:hover,
			.tp-caption.twish_light_button input[type="submit"]:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_revslider_light_button_text_color'),
			'.tp-caption.twish_light_button .btn,
			.tp-caption.twish_light_button button,
			.tp-caption.twish_light_button input[type="submit"],
			.tp-caption.twish_light_button .btn:active');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_revslider_light_button_hover_text_color'),
			'.tp-caption.twish_light_button .btn:hover,
			.tp-caption.twish_light_button button:hover,
			.tp-caption.twish_light_button input[type="submit"]:hover');

		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_revslider_colored_button_background_color'),
			'.tp-caption.twish_colored_button .btn,
			.tp-caption.twish_colored_button button,
			.tp-caption.twish_colored_button input[type="submit"],
			.tp-caption.twish_colored_button .btn:active');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_revslider_colored_button_hover_background_color'),
			'.tp-caption.twish_colored_button .btn:hover,
			.tp-caption.twish_colored_button button:hover,
			.tp-caption.twish_colored_button input[type="submit"]:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_revslider_colored_button_text_color'),
			'.tp-caption.twish_colored_button .btn,
			.tp-caption.twish_colored_button button,
			.tp-caption.twish_colored_button input[type="submit"],
			.tp-caption.twish_colored_button .btn:active');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_revslider_colored_button_hover_text_color'),
			'.tp-caption.twish_colored_button .btn:hover,
			.tp-caption.twish_colored_button button:hover,
			.tp-caption.twish_colored_button input[type="submit"]:hover');


		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_nivoslider_paginator_color'),
			of_get_option('main_content_nivoslider_paginator_opacity'),
			'.wpb_slider_nivo.theme-default .nivo-controlNav a');
		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_nivoslider_hover_paginator_color'),
			of_get_option('main_content_nivoslider_hover_paginator_opacity'),
			'.wpb_slider_nivo.theme-default .nivo-controlNav a:hover');
		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_nivoslider_current_paginator_color'),
			of_get_option('main_content_nivoslider_current_paginator_opacity'),
			'.wpb_slider_nivo.theme-default .nivo-controlNav a.active, .wpb_slider_nivo.theme-default .nivo-controlNav a.active:hover');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_nivoslider_nav_arrow_color'),
			'.wpb_slider_nivo.theme-default a.nivo-nextNav, .wpb_slider_nivo.theme-default a.nivo-prevNav');
		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_nivoslider_nav_arrow_background_color'),
			of_get_option('main_content_nivoslider_nav_arrow_background_opacity'),
			'.wpb_slider_nivo.theme-default a.nivo-nextNav, .wpb_slider_nivo.theme-default a.nivo-prevNav');
		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_nivoslider_nav_arrow_background_color'),
			of_get_option('main_content_nivoslider_nav_arrow_background_opacity'),
			'.wpb_slider_nivo.theme-default a.nivo-nextNav, .wpb_slider_nivo.theme-default a.nivo-prevNav');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_nivoslider_nav_arrow_hover_color'),
			'.wpb_slider_nivo.theme-default a.nivo-nextNav:hover, .wpb_slider_nivo.theme-default a.nivo-prevNav:hover');
		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_nivoslider_nav_arrow_hover_background_color'),
			of_get_option('main_content_nivoslider_nav_arrow_hover_background_opacity'),
			'.wpb_slider_nivo.theme-default a.nivo-nextNav:hover, .wpb_slider_nivo.theme-default a.nivo-prevNav:hover');


		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_flexslider_nav_arrow_color'),
			'.flexslider.wpb_flexslider .flex-direction-nav a');
		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_flexslider_nav_arrow_background_color'),
			of_get_option('main_content_flexslider_nav_arrow_background_opacity'),
			'.flexslider.wpb_flexslider .flex-direction-nav a');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_flexslider_nav_arrow_hover_color'),
			'.flexslider.wpb_flexslider .flex-direction-nav a:hover');
		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_flexslider_nav_arrow_hover_background_color'),
			of_get_option('main_content_flexslider_nav_arrow_hover_background_opacity'),
			'.flexslider.wpb_flexslider .flex-direction-nav a:hover');

		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_flexslider_caption_background_color'),
			of_get_option('main_content_flexslider_caption_background_opacity'),
			'.slide-text-wrapper');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_flexslider_caption_heading_color'),
			'.slide-text-wrapper h3');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_flexslider_caption_text_color'),
			'.slide-text-wrapper span');


		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_filter_color'),
			'.adap-portfolio .filter-link');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_filter_hover_color'),
			'.adap-portfolio .filter-link:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_filter_current_color'),
			'.adap-portfolio .filter-link.active, .adap-portfolio .filter-link.active:hover');


		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_icon_filter_color'),
			'.adap-portfolio .filters.show-icon-true .filter-link');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_icon_filter_hover_color'),
			'.adap-portfolio .filters.show-icon-true .filter-link:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_icon_filter_current_color'),
			'.adap-portfolio .filters.show-icon-true .filter-link.active, .adap-portfolio .filters.show-icon-true .filter-link.active:hover');


		AdapThemeOptions::print_background_and_opacity_css_rule(of_get_option('main_content_portfolio_overlay_background_color'),
			of_get_option('main_content_portfolio_overlay_background_opacity'),
			'.portfolio-image-preview .image-overlay');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_overlay_icon_color'),
			'.image-overlay a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_overlay_icon_hover_color'),
			'.image-overlay a:hover');
		AdapThemeOptions::print_border_color_with_opacity_css_rule(of_get_option('main_content_portfolio_overlay_divider_color'),
			of_get_option('main_content_portfolio_overlay_divider_opacity'),
			'.portfolio-lightbox-link');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_pagination_arrow_color'),
			'.portfolio-pagination-links ul > li.bpn-prev-link > a, .portfolio-pagination-links ul > li.bpn-next-link > a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_pagination_arrow_hover_color'),
			'.portfolio-pagination-links ul > li.bpn-prev-link > a:hover, .portfolio-pagination-links ul > li.bpn-next-link > a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_pagination_arrow_disabled_color'),
			'.portfolio-pagination-links ul > li.bpn-prev-link.disabled > a, .portfolio-pagination-links ul > li.bpn-next-link.disabled > a,
			.portfolio-pagination-links ul > li.bpn-prev-link.disabled > a:hover, .portfolio-pagination-links ul > li.bpn-next-link.disabled > a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_pagination_page_number_color'),
			'.portfolio-pagination-links ul > li > .numbered-pagination-link');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_pagination_page_number_hover_color'),
			'.portfolio-pagination-links ul > li > .numbered-pagination-link:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_pagination_current_page_number_color'),
			'.portfolio-pagination-links ul > li.bpn-current > .numbered-pagination-link,
			.portfolio-pagination-links ul > li.bpn-current > .numbered-pagination-link:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_title_color'),
			'.portfolio-preview-title a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_title_hover_color'),
			'.portfolio-preview-title a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_category_color'),
			'.portfolio-categories, .portfolio-categories a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_category_hover_color'),
			'.portfolio-categories a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_excerpt_color'),
			'.portfolio-item-excerpt, .portfolio-item-excerpt p, .portfolio-item-excerpt li');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_item_title_color'),
			'.portfolio-item-details h1 a, .portfolio-item-details h1 a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_item_link_color'),
			'.portfolio-item-details-link');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_item_link_hover_color'),
			'.portfolio-item-details-link:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_item_categories_heading_color'),
			'.post-categories-heading');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_item_category_color'),
			'.portfolio-item-skills li');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_nav_title_color'),
			'.adap-post-nav .post-nav-title');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_nav_title_hover_color'),
			'.adap-post-nav a:hover .post-nav-title');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_nav_category_color'),
			'.adap-post-nav .adjacent-post-categories');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_nav_category_hover_color'),
			'.adap-post-nav a:hover .adjacent-post-categories');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_nav_icon_color'),
			'.adap-post-nav i');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_portfolio_nav_icon_hover_color'),
			'.adap-post-nav a:hover i');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_blog_pagination_button_background_color'),
			'.blog-pagination .pagination ul > li > a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_pagination_button_text_color'),
			'.blog-pagination .pagination ul > li > a');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_blog_pagination_button_background_hover_color'),
			'.blog-pagination .pagination ul > li > a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_pagination_button_text_hover_color'),
			'.blog-pagination .pagination ul > li > a:hover');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_blog_pagination_disabled_button_background_color'),
			'.blog-pagination .pagination ul > li.disabled > a, .blog-pagination .pagination ul > li.disabled > a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_pagination_disabled_button_text_color'),
			'.blog-pagination .pagination ul > li.disabled > a, .blog-pagination .pagination ul > li.disabled > a:hover');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_blog_pagination_current_page_button_background_color'),
			'.blog-pagination .pagination ul > li.bpn-current.disabled > a, .blog-pagination .pagination ul > li.disabled.bpn-current > a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_pagination_current_page_button_text_color'),
			'.blog-pagination .pagination ul > li.bpn-current.disabled > a, .blog-pagination .pagination ul > li.bpn-current.disabled > a:hover');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_post_preview_date_color'),
			'.adap-blog-shortcode .post-preview .byline-datetime a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_post_preview_date_hover_color'),
			'.adap-blog-shortcode .post-preview .byline-datetime a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_post_preview_meta_color'),
			'.adap-blog-shortcode .post-preview .byline-item, .adap-blog-shortcode .post-preview .byline-item a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_post_preview_meta_icon_color'),
			'.adap-blog-shortcode .post-preview .byline-item a:before, .adap-blog-shortcode .post-preview .byline-item div:before');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_post_preview_meta_icon_hover_color'),
			'.adap-blog-shortcode .post-preview .byline-item a:hover:before');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_post_preview_meta_hover_color'),
			'.adap-blog-shortcode .type-post .post-preview .byline-item a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_post_preview_title_color'),
			'.adap-blog-shortcode .type-post .post-title,
			.adap-blog-shortcode  .type-post .post-title a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_post_preview_title_hover_color'),
			'.adap-blog-shortcode  .type-post .post-title:hover,
			 .type-post .adap-blog-shortcode .post-title a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_post_preview_excerpt_color'),
			'.adap-blog-shortcode  .type-post .entry-content,
			.adap-blog-shortcode .type-post .entry-content p,
			.adap-blog-shortcode .type-post .entry-content li');

		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_blog_post_preview_readmorebutton_background_color'),
			'.adap-blog-shortcode .type-post .excerpt-read-more');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_post_preview_readmorebutton_text_color'),
			'.adap-blog-shortcode .type-post .excerpt-read-more');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_blog_post_preview_readmorebutton_background_hover_color'),
			'.adap-blog-shortcode .type-post .excerpt-read-more:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_blog_post_preview_readmorebutton_text_hover_color'),
			'.adap-blog-shortcode .type-post .excerpt-read-more:hover');
		AdapThemeOptions::print_border_top_color_css_rule(of_get_option('main_content_blog_divider_color'),
			'.adap-blog-shortcode .post-divider');


		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_date_color'),
			'.type-post .byline-datetime.byline-item a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_date_hover_color'),
			'.type-post .byline-datetime.byline-item a:hover');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_meta_color'),
			'.type-post .byline-item, .type-post .byline-item a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_meta_hover_color'),
			'.type-post .byline-item a:hover');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_meta_icon_color'),
			'.type-post .byline-item a:before, .type-post .byline-item div:before');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_meta_icon_hover_color'),
			'.type-post .byline-item a:hover:before');


		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_title_color'),
			'.type-post .post-title a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_title_hover_color'),
			'.type-post .post-title a:hover');

		AdapThemeOptions::print_border_top_color_css_rule(of_get_option('main_content_post_bottom_divider_color'),
			'.post-meta-footer-divider');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_author_label_color'),
			'.type-post .footer-byline .byline-author');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_author_link_color'),
			'.type-post .footer-byline .byline-author a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_author_link_hover_color'),
			'.type-post .footer-byline .byline-author a:hover');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_tag_label_color'),
			'.type-post .footer-byline .byline-tags');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_tag_link_color'),
			'.type-post .footer-byline .byline-tags a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_tag_link_hover_color'),
			'.type-post .footer-byline .byline-tags a:hover');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_nav_title_color'),
			'.type-post .post-nav-title');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_post_nav_button_background_color'),
			'.type-post .nav-previous a,
			.type-post .nav-next a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_nav_button_text_color'),
			'.type-post .nav-previous a,
			.type-post .nav-next a');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_post_nav_button_background_hover_color'),
			'.type-post .nav-previous a:hover,
			.type-post .nav-next a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_nav_button_text_hover_color'),
			'.type-post .nav-previous a:hover,
			.type-post .nav-next a:hover');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comments_title_color'),
			'.comments-title');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comments_author_color'),
			'.comment-citation');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comments_text_color'),
			'.comment, .comment p, .comment li');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comments_link_color'),
			'.comment a');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comments_link_hover_color'),
			'.comment a:hover');


		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comment_form_title_color'),
			'#comment-form-title');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comment_form_label_color'),
			'.comment-form label');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_post_comment_form_input_background_color'),
			'.comment-form textarea, .comment-form input[type="text"], .comment-form input[type="password"],
			.comment-form input[type="datetime"], .comment-form input[type="datetime-local"],
			.comment-form input[type="date"], .comment-form input[type="month"],
			.comment-form input[type="time"],.comment-form  input[type="week"],
			.comment-form input[type="number"], .comment-form input[type="email"],
			.comment-form input[type="url"], .comment-form input[type="search"],
			.comment-form input[type="tel"], .comment-form input[type="color"], .comment-form .uneditable-input');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comment_form_input_text_color'),
			'.comment-form textarea, .comment-form input[type="text"], .comment-form input[type="password"],
			.comment-form input[type="datetime"], .comment-form input[type="datetime-local"],
			.comment-form input[type="date"], .comment-form input[type="month"],
			.comment-form input[type="time"],.comment-form  input[type="week"],
			.comment-form input[type="number"], .comment-form input[type="email"],
			.comment-form input[type="url"], .comment-form input[type="search"],
			.comment-form input[type="tel"], .comment-form input[type="color"], .comment-form .uneditable-input');

		// The syntax for each browser has to be done separately, or the browsers don't apply it correctly
		$commentform_placeholder_selector_moz = '.comment-form :-moz-placeholder';
		$commentform_placeholder_selector_moz2 = '.comment-form ::-moz-placeholder';
		$commentform_placeholder_selector_webkit = '.comment-form ::-webkit-input-placeholder';
		$commentform_placeholder_selector_ie9 = '.comment-form :-ms-input-placeholder, .comment-form input:-ms-input-placeholder';
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comment_form_input_placeholder_color'),
			$commentform_placeholder_selector_moz);
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comment_form_input_placeholder_color'),
			$commentform_placeholder_selector_moz2);
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comment_form_input_placeholder_color'),
			$commentform_placeholder_selector_webkit);
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comment_form_input_placeholder_color'),
			$commentform_placeholder_selector_ie9);


		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_post_comment_form_button_background_color'),
			'.comment-form .btn');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comment_form_button_text_color'),
			'.comment-form .btn');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_post_comment_form_button_background_hover_color'),
			'.comment-form .btn:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_post_comment_form_button_text_hover_color'),
			'.comment-form .btn:hover');

		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_form_label_color'),
			'label');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_form_input_background_color'),
			'textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"],
			input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"],
			input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"],
			.uneditable-input');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_form_input_text_color'),
			'textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"],
			input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"],
			input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"],
			.uneditable-input');

		// The syntax for each browser has to be done separately, or the browsers don't apply it correctly
		$placeholder_selector_moz = '.main-content :-moz-placeholder';
		$placeholder_selector_moz2 = '.main-content ::-moz-placeholder';
		$placeholder_selector_webkit = '.main-content ::-webkit-input-placeholder';
		$placeholder_selector_ie9 = '.main-content :-ms-input-placeholder, .main-content input:-ms-input-placeholder';
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_form_input_placeholder_color'),
			$placeholder_selector_moz);
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_form_input_placeholder_color'),
			$placeholder_selector_moz2);
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_form_input_placeholder_color'),
			$placeholder_selector_webkit);
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_form_input_placeholder_color'),
			$placeholder_selector_ie9);

		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_form_button_background_color'),
			'form .btn, form input[type="submit"]');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_form_button_text_color'),
			'form .btn, form input[type="submit"]');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('main_content_form_button_background_hover_color'),
			'form .btn:hover, form input[type="submit"]:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('main_content_form_button_text_hover_color'),
			'form .btn:hover, form input[type="submit"]:hover');


		AdapThemeOptions::print_color_css_rule(of_get_option('sidebar_widget_title_color'),
			'.sidebar .widgettitle, .sidebar .widgettitle a, .sidebar .widgettitle label,
			.wpb_widgetised_column .widgettitle, .wpb_widgetised_column .widgettitle a, .wpb_widgetised_column .widgettitle label');
		AdapThemeOptions::print_color_css_rule(of_get_option('sidebar_widget_heading_color'),
			'.sidebar h1, .sidebar h2, .sidebar h3, .sidebar h4, .sidebar h5, .sidebar h6,
			.sidebar h1, .sidebar .h2, .sidebar .h3, .sidebar .h4, .sidebar .h5, .sidebar .h6,
			.wpb_widgetised_column h1, .wpb_widgetised_column h2, .wpb_widgetised_column h3, .wpb_widgetised_column h4, .wpb_widgetised_column h5, .wpb_widgetised_column h6,
			.wpb_widgetised_column h1, .wpb_widgetised_column .h2, .wpb_widgetised_column .h3, .wpb_widgetised_column .h4, .wpb_widgetised_column .h5, .wpb_widgetised_column .h6');
		AdapThemeOptions::print_color_css_rule(of_get_option('sidebar_widget_text_color'),
			'.sidebar .widget, .wpb_widgetised_column .widget');
		AdapThemeOptions::print_color_css_rule(of_get_option('sidebar_widget_link_color'),
			'.sidebar .widget a, .wpb_widgetised_column .widget a');
		AdapThemeOptions::print_color_css_rule(of_get_option('sidebar_widget_link_hover_color'),
			'.sidebar .widget a:hover, .wpb_widgetised_column .widget a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('sidebar_widget_twitter_widget_color'),
			'.sidebar .really_simple_twitter_widget li, .wpb_widgetised_column .really_simple_twitter_widget li');

		AdapThemeOptions::print_border_color_css_rule(of_get_option('sidebar_navigation_border_color'),
			'.sidebar .widget-sidenav > ul > li > ul > li');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('sidebar_navigation_background_color'),
			'.sidebar .widget-sidenav > ul > li > ul > li');
		AdapThemeOptions::print_border_top_color_css_rule(of_get_option('sidebar_navigation_background_color'),
			'.sidebar .widget-sidenav > ul > li > ul > li.current_page_item + li');
		AdapThemeOptions::print_color_css_rule(of_get_option('sidebar_navigation_link_color'),
			'.sidebar .widget-sidenav > ul > li > ul > li > a');
		AdapThemeOptions::print_color_css_rule(of_get_option('sidebar_navigation_link_hover_color'),
			'.sidebar .widget-sidenav > ul > li > ul > li > a:hover');
		AdapThemeOptions::print_color_css_rule(of_get_option('sidebar_navigation_current_page_link_color'),
			'.sidebar .widget-sidenav > ul > li > ul > li.current_page_item > a,
			.sidebar .widget-sidenav > ul > li > ul > li.current_page_item > a:hover');
		AdapThemeOptions::print_background_color_css_rule(of_get_option('sidebar_navigation_current_page_background_color'),
			'.sidebar .widget-sidenav > ul > li > ul > li.current_page_item');
		AdapThemeOptions::print_border_color_css_rule(of_get_option('sidebar_navigation_current_page_background_color'),
			'.sidebar .widget-sidenav > ul > li > ul > li.current_page_item');


		$ret_val = ob_get_contents();
		ob_end_clean();

		return $ret_val;
	}

	/**
	 * Actually generate the dynamic CSS specified by the Post Options
	 * @return string
	 */
	static function get_post_options_css()
	{
		ob_start();

		global $post;
		if ($post) {
			$hide_subheader = get_post_meta($post->ID, '_peach_hide_subheader', true);
			if ($hide_subheader) {
				echo 'header.jumbotron {display: none;}';
			}

			//add page background
			$hide_subheader = get_post_meta($post->ID, '_peach_hide_subheader', true);

			AdapThemeOptions::page_background();

		}
		$ret_val = ob_get_contents();
		ob_end_clean();

		return $ret_val;
	}

	static function page_background()
	{
		$prefix = '_peach_'; // Prefix for all fields
		global $post;
		$pid = $post->ID;
		if ($post) {
			$bkgd_option = AdapThemeOptions::retrieve_bkgd_option('_peach_bkgd_');
			AdapThemeOptions::print_background_css_rule($bkgd_option, 'body');
			AdapThemeOptions::print_background_css_rule('transparent', '.main-content');

			$bkgd_option = AdapThemeOptions::retrieve_bkgd_option('_peach_header_bkgd_');
			AdapThemeOptions::print_background_css_rule($bkgd_option, '.navbar-inner');
		}
	}

	static function retrieve_bkgd_option($prefix)
	{
		global $post;
		$pid = $post->ID;

		$color = get_post_meta($pid, $prefix . 'color', true);
		$image = get_post_meta($pid, $prefix . 'img', true);
		$repeat = get_post_meta($pid, $prefix . 'repeat', true);
		$position = get_post_meta($pid, $prefix . 'position', true);
		$attachment = get_post_meta($pid, $prefix . 'attachment', true);
		$cover = get_post_meta($pid, $prefix . 'cover', true);
		$transparent = get_post_meta($pid, $prefix . 'transparent', true);


		$option = array(
			'color' => $color,
			'image' => $image,
			'repeat' => $repeat,
			'position' => $position,
			'attachment' => $attachment,
			'cover' => $cover,
			'transparent' => $transparent

		);

		return $option;
	}


	static function init()
	{
		//The stylesheets enqueued by Bones are priority 999, so we have to
		//executre wp_add_inline_style after that. Hence the 1000 priority
		add_action('wp_enqueue_scripts', array('AdapThemeOptions', 'enqueue_css_and_script'), 1000);
	}

	static function enqueue_css_and_script()
	{
		$style_css_handle = 'peach-css';
		if (function_exists('of_get_option'))
			wp_add_inline_style($style_css_handle, AdapThemeOptions::get_theme_options_css());

		wp_add_inline_style('fonts-css', AdapThemeOptions::get_post_options_css());
	}

	// CSS GENERATORS===================================================================================================

	public static function color_is_set($color)
	{
		return $color != null && $color != '#' && $color != '';
	}

	public static function print_background_css_rule($background, $css_selector)
	{
		$background_options = array(
			'color',
			'repeat',
			'attachment',
			'position',
			'image',
			'transparent'
		);

		/*
		 * If set transparent, write out the rule with just "background: transparent"
		 * and return
		 */
		if (!empty($background['transparent']) && $background['transparent']) {
			printf($css_selector . '{');
			echo 'background: transparent;';
			printf('}');
			print PHP_EOL;
			return;
		}

		if ((empty($background['color']) || $background['color'] == '#') && empty($background['image'])) {
			return;
		}

		printf($css_selector . '{');

		// Check to see if only color has been set
		if (!empty($background['color']) && $background['color'] != '#' && empty($background['image'])) {
			printf('background: ' . $background['color'] . ';');
		} else {
			$hasSetting = false;
			foreach ($background_options as $o) {
				if (!empty($background[$o])) {
					$hasSetting = true;
					break;
				}
			}

			if ($hasSetting) {
				if (isset($background['cover']) && $background['cover']) {
					echo ' background-size: cover;';
				}

				foreach ($background_options as $o) {
					if ($o == 'image') {
						printf(' background-%s: url("%s");', $o, $background[$o]);
					} elseif (isset($background[$o]) && $background[$o] != '') {
						printf(' background-%s: %s;', $o, $background[$o]);
					}
				}
			}
		}
		printf('}');
		print PHP_EOL;

	}

	public static function print_background_and_color_css_rule($background, $background_color, $css_selector)
	{
		$background['color'] = $background_color;
		AdapThemeOptions::print_background_css_rule($background, $css_selector);
	}

	public static function print_background_color_css_rule($background_color, $css_selector)
	{
		$background = array();
		$background['color'] = $background_color;
		AdapThemeOptions::print_background_css_rule($background, $css_selector);
	}

	public static function print_background_rgba_css_rule($background_rgba, $css_selector)
	{
		printf($css_selector . '{');
		printf('background: rgba( %s, %s, %s, %s);', $background_rgba[0], $background_rgba[1], $background_rgba[2], $background_rgba[3]);
		printf('}');
		print PHP_EOL;
	}

	public static function print_background_and_opacity_css_rule($background_color, $background_opacity, $css_selector)
	{

		if ($background_color) {
			$color_rgba = adap_html2rgb($background_color);
			$color_rgba[] = $background_opacity;
			AdapThemeOptions::print_background_rgba_css_rule($color_rgba, $css_selector);
		}

	}

	public static function print_background_and_opacity_msie_css_rule($background_color, $background_opacity, $css_selector) {

		if($background_color) {
			?>
			<?php echo $css_selector; ?> {
				background-color: <?php echo $background_color; ?>;
				-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=<?php echo $background_opacity*100; ?>)";
			}
			<?php
		}

	}


	public static function print_color_css_rule($color, $css_selector)
	{

		if (AdapThemeOptions::color_is_set($color)) {
			?>
			<?php echo $css_selector; ?> {
			color: <?php echo $color; ?>;
			}

		<?php
		}
	}

	public static function print_border_color_css_rule($border_color, $css_selector)
	{

		if (AdapThemeOptions::color_is_set($border_color)) {
			printf($css_selector . '{');
			echo 'border-color: ' . $border_color . ';';
			printf('}');
			print PHP_EOL;
		}
		return;


	}

	public static function print_border_color_rgba_css_rule($border_rgba, $css_selector)
	{
		printf($css_selector . '{');
		printf('border-color: rgba( %s, %s, %s, %s);', $border_rgba[0], $border_rgba[1], $border_rgba[2], $border_rgba[3]);
		printf('}');
		print PHP_EOL;

	}

	public static function print_border_color_with_opacity_css_rule($border_color, $border_opacity, $css_selector)
	{
		if (AdapThemeOptions::color_is_set($border_color)) {
			$color_rgba = adap_html2rgb($border_color);
			$color_rgba[] = $border_opacity;
			AdapThemeOptions::print_border_color_rgba_css_rule($color_rgba, $css_selector);
		}
	}


	public static function print_border_top_color_css_rule($border_color, $css_selector)
	{
		if (AdapThemeOptions::color_is_set($border_color)) {
			printf($css_selector . '{');
			echo 'border-top-color: ' . $border_color . ';';
			printf('}');
			print PHP_EOL;
		}
		return;
	}

	public static function print_border_bottom_color_css_rule($border_color, $css_selector)
	{
		if (AdapThemeOptions::color_is_set($border_color)) {
			printf($css_selector . '{');
			echo 'border-bottom-color: ' . $border_color . ';';
			printf('}');
			print PHP_EOL;
		}
		return;

	}

	public static function print_border_right_color_css_rule($border_color, $css_selector)
	{
		if (AdapThemeOptions::color_is_set($border_color)) {
			printf($css_selector . '{');
			echo 'border-right-color: ' . $border_color . ';';
			printf('}');
			print PHP_EOL;
		}
		return;

	}

	public static function print_border_left_color_css_rule($border_color, $css_selector)
	{
		if (AdapThemeOptions::color_is_set($border_color)) {
			printf($css_selector . '{');
			echo 'border-left-color: ' . $border_color . ';';
			printf('}');
			print PHP_EOL;
		}
		return;

	}

	// PORTFOLIO =======================================================================================================

	public static function get_portfolio_item_heading()
	{

		$portfolio_item_title = of_get_option('portfolio_items_heading');
		return $portfolio_item_title;

	}


	// SITE LOGO =======================================================================================================

	public static function print_site_logo_img_element()
	{
		$default_logo_src = get_template_directory_uri() . '/library/img/logo@2x.png';


		$color_scheme = of_get_option('base_color_scheme');
		if(strpos($color_scheme,'_dark') !== false) {
			$default_logo_src = get_template_directory_uri() . '/library/img/logo-' . $color_scheme . '@2x.png';
		}

		/* Can't use the default parameter since of_get_option doesn't catch for an empty string */
		$logo_src = of_get_option('site_logo');
		if (strlen($logo_src) == 0) {
			$logo_src = $default_logo_src;
		}

		ob_start();
		?>
		<img src="<?php echo $logo_src; ?>" alt="<?php bloginfo('description'); ?>" title="<?php bloginfo('name'); ?>"/>
		<?php

		$ret_val = ob_get_contents();
		ob_end_clean();

		echo $ret_val;
	}


	public static function print_site_logo_css_rule()
	{

		// Fullsize Logo
		$width = trim(of_get_option('site_logo_width'));
		$height = trim(of_get_option('site_logo_height'));
		$voffset = trim(of_get_option('site_logo_voffset'));


		$width = AdapThemeOptions::strip_nonnumeric($width);
		$height = AdapThemeOptions::strip_nonnumeric($height);
		$voffset = AdapThemeOptions::strip_nonnumeric($voffset);


		?>
		.brand img, .brand a {
		width: <?php echo $width; ?>px;
		height: <?php echo $height; ?>px;
		}
		body > .navbar .brand {
		margin-top: <?php echo $voffset ?>px;
		}

		<?php

		// Mobile Logo
		$width = trim(of_get_option('site_mobile_logo_width'));
		$height = trim(of_get_option('site_mobile_logo_height'));
		$voffset = trim(of_get_option('site_mobile_logo_voffset'));


		$width = AdapThemeOptions::strip_nonnumeric($width);
		$height = AdapThemeOptions::strip_nonnumeric($height);
		$voffset = AdapThemeOptions::strip_nonnumeric($voffset);

		?>

		@media (max-width: 979px) {
		.brand img, .brand a {
		width: <?php echo $width; ?>px;
		height: <?php echo $height; ?>px;
		}
		body > .navbar .brand {
		margin-top: <?php echo $voffset ?>px;
		}
		}

	<?php
	}

	static function strip_nonnumeric($string)
	{

		return preg_replace("/[^0-9,.]/", "", $string);

	}

	// SKIN DEFS =======================================================================================================

	public static function get_skin_class()
	{

		$skin = of_get_option('base_color_scheme');
		return $skin .= '_skin';

	}


	// PAGE BACKGROUND =================================================================================================

	public static function get_stretched_or_boxed_class()
	{

		$layout = of_get_option('stretched_or_boxed');
		return 'page-layout-' . $layout . ' ';

	}

	public static function get_page_shadow_class()
	{

		if (of_get_option('enable_page_shadow')) {
			return 'boxed-page-shadow';
		}

	}

	public static function get_background_cover_class() {

		if (of_get_option('enable_cover_background')) {
			return 'boxed-cover-background';
		}

	}


	// LOGO ATTRIBUTES =================================================================================================

	public static function get_logo_fullsize_height($echo = false) {

		$value = of_get_option('site_logo_height');

		if($echo) {
			echo $value;
		}
		else {
			return $value;
		}


	}

	public static function get_logo_fullsize_width($echo = false) {

		$value = of_get_option('site_logo_width');
		if($echo) {
			echo $value;
		}
		else {
			return $value;
		}
	}

	public static function get_logo_fullsize_voffset($echo = false) {

		$value = of_get_option('site_logo_voffset');
		if($echo) {
			echo $value;
		}
		else {
			return $value;
		}
	}


	public static function get_logo_mobile_height($echo = false) {

		$value = of_get_option('site_mobile_logo_height');
		if($echo) {
			echo $value;
		}
		else {
			return $value;
		}
	}

	public static function get_logo_mobile_width($echo = false) {

		$value = of_get_option('site_mobile_logo_width');
		if($echo) {
			echo $value;
		}
		else {
			return $value;
		}
	}

	public static function get_logo_mobile_voffset($echo = false) {

		$value = of_get_option('site_mobile_logo_voffset');
		if($echo) {
			echo $value;
		}
		else {
			return $value;
		}
	}



	// HEADER BEHAVIOR =================================================================================================

	public static function get_sticky_header_class() {

		if(of_get_option('enable_sticky_header')) {
			return 'enable-sticky-header';
		}

	}

	public static function get_translucent_sticky_header_class() {
		if(of_get_option('enable_translucent_sticky_header')) {
			return 'enable-translucent-sticky-header';
		}
	}



	// SIDEBAR POSITIONING =============================================================================================


	public static function get_archive_content_classes()
	{

		return AdapThemeOptions::get_content_classes(of_get_option('sidebar_archive_pages'));
	}

	public static function get_blog_content_classes()
	{

		return AdapThemeOptions::get_content_classes(of_get_option('sidebar_blog'));
	}

	public static function get_post_content_classes()
	{

		return AdapThemeOptions::get_content_classes(of_get_option('sidebar_posts'));
	}

	public static function get_page_content_classes()
	{

		return AdapThemeOptions::get_content_classes(of_get_option('sidebar_pages'));
	}

	public static function get_archive_sidebar_classes()
	{

		return AdapThemeOptions::get_sidebar_classes(of_get_option('sidebar_archive_pages'));
	}

	public static function get_blog_sidebar_classes()
	{

		return AdapThemeOptions::get_sidebar_classes(of_get_option('sidebar_blog'));
	}

	public static function get_post_sidebar_classes()
	{

		return AdapThemeOptions::get_sidebar_classes(of_get_option('sidebar_posts'));
	}

	public static function get_page_sidebar_classes()
	{

		return AdapThemeOptions::get_sidebar_classes(of_get_option('sidebar_pages'));
	}

	public static function show_archive_sidebar()
	{

		return AdapThemeOptions::show_sidebar(of_get_option('sidebar_archive_pages'));
	}

	public static function show_blog_sidebar()
	{

		return AdapThemeOptions::show_sidebar(of_get_option('sidebar_blog'));
	}

	public static function show_post_sidebar()
	{

		return AdapThemeOptions::show_sidebar(of_get_option('sidebar_posts'));
	}

	public static function show_page_sidebar()
	{

		return AdapThemeOptions::show_sidebar(of_get_option('sidebar_pages'));
	}


	// Generates the relevant layout classes for the sidebar div based on where the sidebar is supposed to show up
	static function get_sidebar_classes($position)
	{

		$sidebar_classes = '';

		switch ($position) {
			case 'no_sidebar':
				break;
			case 'left_sidebar':
				$sidebar_classes .= 'span3';
				break;
			case 'right_sidebar':
			default:
				$sidebar_classes .= 'span3 offset1';
				break;
		}

		return $sidebar_classes;
	}

	// Generates the relevant classes for the content div based on where the sidebar is supposed to show up
	static function get_content_classes($position)
	{

		$content_classes = '';

		switch ($position) {
			case 'no_sidebar':
				$content_classes .= 'span12';
				break;
			case 'left_sidebar':
				$content_classes .= 'span8 offset1 pull-right';
				break;
			case 'right_sidebar':
			default:
				$content_classes .= 'span8';
				break;
		}

		return $content_classes;
	}

	// Returns a true if, according to the sidebar position theme option, a sidebar should be shown on the page
	static function show_sidebar($position)
	{

		$show_sidebar = $position != 'no_sidebar';
		return $show_sidebar;

	}


	// FOOTER LAYOUT ===================================================================================================

	public static function show_footer_widget_area()
	{

		return of_get_option('enable_footer');
	}

	public static function show_subfooter()
	{

		return of_get_option('enable_subfooter');
	}

	public static function show_footer_column_1()
	{
		return true;
	}

	public static function show_footer_column_2()
	{

		$layout = of_get_option('footer_layout');
		return $layout != '1-even';
	}

	public static function show_footer_column_3()
	{

		$layout = of_get_option('footer_layout');

		switch ($layout) {

			case '1-even':
			case '2-even':
				return false;
			default:
				return true;
		}
	}

	public static function show_footer_column_4()
	{

		$layout = of_get_option('footer_layout');

		switch ($layout) {

			case 'default':
			case '4-even':
				return true;
			default:
				return false;
		}

	}

	public static function get_footer_column_1_classes()
	{

		$layout = of_get_option('footer_layout');
		$classes = '';

		switch ($layout) {

			case 'default':
				$classes .= 'span2';
				break;
			case '1-even':
				$classes .= 'span12';
				break;
			case '2-even':
			case '1-wide-2-narrow':
				$classes .= 'span6';
				break;
			case '3-even':
				$classes .= 'span4';
				break;
			case '4-even':
			case '2-narrow-1-wide':
			default:
				$classes .= 'span3';
				break;
		}

		return $classes;
	}

	public static function get_footer_column_2_classes()
	{

		$layout = of_get_option('footer_layout');
		$classes = '';

		switch ($layout) {

			case 'default':
				$classes .= 'span2 offset1';
				break;
			case '2-even':
				$classes .= 'span6';
				break;
			case '3-even':
				$classes .= 'span4';
				break;
			case '4-even':
			case '2-narrow-1-wide':
			case '1-wide-2-narrow':
			default:
				$classes .= 'span3';
		}

		return $classes;

	}

	public static function get_footer_column_3_classes()
	{

		$layout = of_get_option('footer_layout');
		$classes = '';

		switch ($layout) {

			case 'default':
				$classes .= 'span3';
				break;
			case '3-even':
				$classes .= 'span4';
				break;
			case '2-narrow-1-wide':
				$classes .= 'span6';
				break;
			case '4-even':
			case '1-wide-2-narrow':
			default:
				$classes .= 'span3';
		}

		return $classes;
	}

	public static function get_footer_column_4_classes()
	{

		$layout = of_get_option('footer_layout');
		$classes = '';

		switch ($layout) {

			case 'default':
				$classes .= 'span3 offset1';
				break;
			case '4-even':
			default:
				$classes .= 'span3';
		}

		return $classes;
	}

	// SUBFOOTER CONTENT ===============================================================================================

	public static function get_subfooter_copyright_text()
	{

		return of_get_option('copyright_text');
	}

	public static function print_subfooter_social_icons()
	{

		ob_start();
		?>

		<ul class="social-icon-list subfooter-social-icon-list">

			<?php
			// Cycle through social icons 1 thru 4
			for ($i = 1; $i <= 4; $i++) {
				$social_icon = of_get_option('subfooter_social_icon_' . $i, 'none');
				$social_icon_url = of_get_option('subfooter_social_icon_url_' . $i, '#');
				AdapThemeOptions::print_subfooter_social_icon_li($social_icon, $social_icon_url);
			} ?>

		</ul>

		<?php

		$ret_val = ob_get_contents();
		ob_end_clean();

		echo $ret_val;
	}

	static function print_subfooter_social_icon_li($icon, $url)
	{

		// If there's no icon selected, return
		if ($icon == 'none') return;

		ob_start();

		?>
		<li>
			<a href="<?php echo $url ?>" target="_blank">
				<i class="social-icon subfooter-social-icon social-icon-<?php echo $icon; ?> icon-<?php echo $icon; ?> entypo-<?php echo $icon; ?>-circled"></i>
			</a>
		</li>
		<?php

		$ret_val = ob_get_contents();
		ob_end_clean();

		echo $ret_val;

	}


	// HEADER SOCIAL ICONS =============================================================================================

	public static function print_header_social_icons()
	{
		ob_start();
		?>
		<ul class="social-icon-list header-social-icon-list">
			<?php
			// Cycle through social icons 1 thru 4
			for ($i = 1; $i <= 4; $i++) {
				$social_icon = of_get_option('social_icon_' . $i, 'none');
				$social_icon_url = of_get_option('social_icon_url_' . $i, '#');
				$social_icon_email = of_get_option('social_icon_emailaddress_' . $i, '');
				$social_icon_phonenumber = of_get_option('social_icon_phonenumber_' . $i, '');
				AdapThemeOptions::print_social_icon_li($social_icon, $social_icon_url, $social_icon_email, $social_icon_phonenumber);
			} ?>
		</ul>
		<?php

		$ret_val = ob_get_contents();
		ob_end_clean();

		echo $ret_val;

	}

	static function print_social_icon_li($icon, $url, $email = false, $phone = false)
	{
		// If there's no icon selected, return
		if ($icon == 'none') return;

		// Set a mailto URL if the email icon is used
		if ($icon == 'email') {
			$url = 'mailto:' . $email;
		}

		ob_start();

		if ($icon == 'phone') {
			?>
			<li>
				<a class="adap-tel-mobile-link" href="tel://<?php echo $phone ?>" target="_blank">
					<i class="social-icon header-social-icon social-icon-<?php echo $icon; ?> icon-<?php echo $icon; ?> entypo-<?php echo $icon; ?>"></i>
				</a>
				<a class="adap-tel-desktop-link" href="<?php echo $url ?>" target="_blank">
					<i class="social-icon header-social-icon social-icon-<?php echo $icon; ?> icon-<?php echo $icon; ?> entypo-<?php echo $icon; ?>"></i>
				</a>
			</li>
		<?php
		} else {
			?>
			<li>
				<a href="<?php echo $url ?>" target="_blank">
					<i class="social-icon header-social-icon social-icon-<?php echo $icon; ?> icon-<?php echo $icon; ?> entypo-<?php echo $icon; ?>"></i>
				</a>
			</li>
		<?php
		}

		$ret_val = ob_get_contents();
		ob_end_clean();

		echo $ret_val;
	}


}

if (!is_admin())
	AdapThemeOptions::init();
