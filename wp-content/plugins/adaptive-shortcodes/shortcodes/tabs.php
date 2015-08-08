<?php

global $tab_content_ids;
$tab_content_ids = null;

class AdapTabsSC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'style' => 'default',
			'title' => '',
			'tab_heading_color' => null,
			'tab_heading_background_color' => null,
			'active_tab_heading_color' => null,
			'active_tab_heading_background_color' => null,
			'hover_tab_heading_color' => null,
			'hover_tab_heading_background_color' => null,
			'content_color' => null,
			'content_background_color' => null
		);

		extract(shortcode_atts($defaults, $atts));

		// Generate a Unique ID for the Element
		$element_id = uniqid('tabs_');

		// Configure Custom Colors
		global $custom_css;
		ob_start();
		?>

		<?php if (isset($tab_heading_color)) { ?>

		#<?php echo $element_id; ?> .nav-tabs > li > a.tab-shortcode-tab {
		color: <?php echo $tab_heading_color; ?>;
		}

	<?php } ?>

		<?php if (isset($tab_heading_background_color)) { ?>

		#<?php echo $element_id; ?> .nav-tabs > li > a.tab-shortcode-tab {
		background: <?php echo $tab_heading_background_color; ?>;
		}

	<?php } ?>

		<?php if (isset($active_tab_heading_color)) { ?>

		#<?php echo $element_id; ?> .nav-tabs > .active > a.tab-shortcode-tab,
		#<?php echo $element_id; ?> .nav-tabs > .active > a.tab-shortcode-tab:hover,
		#<?php echo $element_id; ?> .nav-tabs > .active > a.tab-shortcode-tab:active {
		color: <?php echo $active_tab_heading_color; ?>;
		}

	<?php } ?>

		<?php if (isset($active_tab_heading_background_color)) { ?>

		#<?php echo $element_id; ?> .nav-tabs > .active > a.tab-shortcode-tab,
		#<?php echo $element_id; ?> .nav-tabs > .active > a.tab-shortcode-tab:hover,
		#<?php echo $element_id; ?> .nav-tabs > .active > a.tab-shortcode-tab:active  {
		background: <?php echo $active_tab_heading_background_color; ?>;
		}

	<?php } ?>

		<?php if (isset($hover_tab_heading_color)) { ?>

		#<?php echo $element_id; ?> .nav-tabs > li > a.tab-shortcode-tab:hover {
		color: <?php echo $hover_tab_heading_color; ?>;
		}

	<?php } ?>

		<?php if (isset($hover_tab_heading_background_color)) { ?>

		#<?php echo $element_id; ?> .nav-tabs > li > a.tab-shortcode-tab:hover {
		background: <?php echo $hover_tab_heading_background_color; ?>;
		}

	<?php } ?>

		<?php if (isset($content_color)) { ?>

		#<?php echo $element_id; ?> .tab-pane,
		#<?php echo $element_id; ?> .tab-pane p {
		color: <?php echo $content_color; ?>;
		}

	<?php } ?>

		<?php if (isset($content_background_color)) { ?>

		#<?php echo $element_id; ?> .tab-content {
		background: <?php echo $content_background_color; ?>;
		}

	<?php } ?>

		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		$style_att = '';

		// Extract the tab titles for use in the tabber widget.
		preg_match_all('/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE);

		$tab_titles = array();
		$tabs_class = 'tab_titles';

		if (isset($matches[1])) {
			$tab_titles = $matches[1];
		} // End IF Statement

		$titles_html = '';

		global $tab_content_ids;
		$tab_content_ids = array();

		if (count($tab_titles)) {

			if ($title) {
				$titles_html .= '<h4 class="tab_header"><span>' . esc_html($title) . '</span></h4>';
				$tabs_class .= ' has_title';
			} // End IF Statement

			$titles_html .= '<ul id="' . uniqid('tabs_') . '" class="tabs nav nav-tabs" data-tabs="tabs">' . "\n";

			$counter = 1;

			$border_style = '';

			foreach ($tab_titles as $t) {

				$id = uniqid(sanitize_title($t[0]) . '_');
				$is_last = $counter == count($tab_titles) ? true : false;
				$last_class = $is_last ? 'last-tab' : '';
				$titles_html .= '<li ' . $border_style . ' class="nav-tab ' . $last_class . '"><a class="tab-shortcode-tab" href="#' . $id . '" data-toggle="tab" ' . $style_att . '>' . $t[0] . '</a></li>' . "\n";
				$tab_content_ids[] = $id;
				$counter++;

			} // End FOREACH Loop

			$titles_html .= '</ul>' . "\n";

		}

		$ret_val = $titles_html . '<div class="tab-content">' . do_shortcode($content) . '</div><!--/.tabs-->';

		$ret_val = '<div id="' . $element_id . '" class="tab-shortcode">' . $ret_val . '</div>';

		$tab_content_ids = null;

		return $ret_val;
	}

	function register_vc()
	{
		$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

		//deregister and reregister how we'd like the accordion options to appear
		wpb_remove('vc_tabs');
		wpb_remove('vc_tab');

		$tab_id_1 = time() . '-1-' . rand(0, 100);
		$tab_id_2 = time() . '-2-' . rand(0, 100);
		wpb_map(array(
			"name" => __("Tabs", 'adap_sc'),
			"base" => "vc_tabs",
			"show_settings_on_create" => false,
			"is_container" => true,
			"icon" => "icon-wpb-ui-tab-content",
			"category" => __('Content', 'adap_sc'),
			"params" => array(

				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Tab Heading Color', 'adap_sc'),
					'param_name' => 'tab_heading_color',
					'value' => null,
					'description' => __('The color of the text in tab headings.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Tab Heading Background Color', 'adap_sc'),
					'param_name' => 'tab_heading_background_color',
					'value' => null,
					'description' => __('The background color of the tab headings.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Active Tab Heading Color', 'adap_sc'),
					'param_name' => 'active_tab_heading_color',
					'value' => null,
					'description' => __('The color of the text in the active tab heading.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Active Tab Heading background Color', 'adap_sc'),
					'param_name' => 'active_tab_heading_background_color',
					'value' => null,
					'description' => __('The background color of the active tab heading.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Hover Tab Heading Color', 'adap_sc'),
					'param_name' => 'hover_tab_heading_color',
					'value' => null,
					'description' => __('The hover color of the text in tab headings.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Hover Tab Heading Background Color', 'adap_sc'),
					'param_name' => 'hover_tab_heading_background_color',
					'value' => null,
					'description' => __('The hover background color of the tab headings.', 'adap_sc'),
				),

				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Content Color', 'adap_sc'),
					'param_name' => 'content_color',
					'value' => null,
					'description' => __('The color of the content in tabs.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Content Background Color', 'adap_sc'),
					'param_name' => 'content_background_color',
					'value' => null,
					'description' => __('The background color of the tab content.', 'adap_sc'),
				),
			),
			"custom_markup" => '
  <div class="wpb_tabs_holder wpb_holder vc_container_for_children">
  <ul class="tabs_controls">
  </ul>
  %content%
  </div>'
		,
			'default_content' => '
  [vc_tab title="' . __('Tab 1', 'adap_sc') . '" tab_id="' . $tab_id_1 . '"][/vc_tab]
  [vc_tab title="' . __('Tab 2', 'adap_sc') . '" tab_id="' . $tab_id_2 . '"][/vc_tab]
  ',
			"js_view" => ($vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35')
		));

		/* Tour section
		---------------------------------------------------------- */
		$tab_id_1 = time() . '-1-' . rand(0, 100);
		$tab_id_2 = time() . '-2-' . rand(0, 100);
//		WPBMap::map('vc_tour', array(
//			"name" => __("Tour Section", 'adap_sc'),
//			"base" => "vc_tour",
//			"show_settings_on_create" => false,
//			"is_container" => true,
//			"container_not_allowed" => true,
//			"icon" => "icon-wpb-ui-tab-content-vertical",
//			"category" => __('Content', 'js_composer'),
//			"wrapper_class" => "clearfix",
//			"params" => array(),
//			"custom_markup" => '
//  <div class="wpb_tabs_holder wpb_holder clearfix vc_container_for_children">
//  <ul class="tabs_controls">
//  </ul>
//  %content%
//  </div>'
//		,
//			'default_content' => '
//  [vc_tab title="' . __('Slide 1', 'js_composer') . '" tab_id="' . $tab_id_1 . '"][/vc_tab]
//  [vc_tab title="' . __('Slide 2', 'js_composer') . '" tab_id="' . $tab_id_2 . '"][/vc_tab]
//  ',
//			"js_view" => ($vc_is_wp_version_3_6_more ? 'VcTabsView' : 'VcTabsView35')
//		));

		wpb_map(array(
			"name" => __("Tab", 'adap_sc'),
			"base" => "vc_tab",
			"allowed_container_element" => 'vc_row',
			"is_container" => true,
			"content_element" => false,
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __("Title", 'adap_sc'),
					"param_name" => "title",
					"description" => __("Tab title.", 'adap_sc')
				),
				array(
					"type" => "tab_id",
					"heading" => __("Tab ID", 'adap_sc'),
					"param_name" => "tab_id"
				),
				AdapAutoVCShortcode::bool_param('active', 'Display on load', null, null, false)
			),
			'js_view' => ($vc_is_wp_version_3_6_more ? 'VcTabView' : 'VcTabView35')
		));

	}
}

global $tabs_sc_handler;
$tabs_sc_handler = new AdapTabsSC('tabs');

/*-----------------------------------------------------------------------------------*/
/* 16.1 A Single Tab - [tab title="The title goes here"][/tab]
/*-----------------------------------------------------------------------------------*/

class AdapTabSC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		$defaults = array('title' => 'Tab',
			'active' => 'false');

		extract(shortcode_atts($defaults, $atts));

		$class = 'tab-pane ';
		if ($active != 'false') $class .= 'active ';


		global $tab_content_ids;
		$id = array_shift($tab_content_ids);

		return sprintf('<div id="%s" class="%s">%s</div>', $id, $class, do_shortcode($content));
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

/**
 * Override Visual Composer Tab control output
 */
global $tab_sc_handler;
$tab_sc_handler = new AdapTabSC('tab');

function vc_theme_vc_tabs($atts, $content = null)
{
	global $tabs_sc_handler;
	return $tabs_sc_handler->shortcode_handler($atts, $content);
}

function vc_theme_vc_tab($atts, $content = null)
{
	global $tab_sc_handler;
	return $tab_sc_handler->shortcode_handler($atts, $content);
}


