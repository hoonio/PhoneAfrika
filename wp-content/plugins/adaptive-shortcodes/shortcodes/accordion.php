<?php

// Used to pass an accordion's ID to its children items
$accordion_parent_id = null;
$accordion_sync = false;

class AdapAccordionSC extends AdapShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'sync' => true,
			'bold_titles' => true,
			'style' => 'style1',
			'item_heading_color' => null,
			'item_heading_background_color' => null,
			'open_item_heading_color' => null,
			'divider_color' => null,
			'open_item_heading_background_color' => null

		);
		extract(shortcode_atts($defaults, $atts));

		$sync = $sync == "false" ? false : true;
		$bold_titles = $bold_titles == 'false' ? false : true;

		if ($bold_titles) {
			$style .= ' show-bolded-titles';
		} else {
			$style .= ' show-unbolded-titles';
		}

		global $accordion_sync;
		$accordion_sync = $sync;

		global $accordion_parent_id;
		$accordion_parent_id = uniqid('accordion_');

		// Configure Custom CSS
		global $custom_css;
		ob_start();
		?>

		#<?php echo $accordion_parent_id; ?>.accordion-style-style1 .accordion-group {
			<?php if ($divider_color !== null) : ?>
				border-bottom-color: <?php echo $divider_color; ?>;
			<?php endif; ?>
		}

		#<?php echo $accordion_parent_id; ?>.accordion-style-style2 .accordion-heading .accordion-toggle.collapsed,
		#<?php echo $accordion_parent_id; ?>.accordion-style-style1 .accordion-heading .accordion-toggle.collapsed:hover,
		#<?php echo $accordion_parent_id; ?>.accordion-style-style1 .accordion-heading .accordion-toggle.collapsed,
		#<?php echo $accordion_parent_id; ?>.accordion-style-style1 .accordion-heading .accordion-toggle.collapsed:hover .accordion-title-wrapper,
		#<?php echo $accordion_parent_id; ?>.accordion-style-style1 .accordion-heading .accordion-toggle.collapsed .accordion-title-wrapper {
			<?php if ($item_heading_color !== null) : ?>
				color: <?php echo $item_heading_color; ?>;
			<?php endif; ?>
		}

		#<?php echo $accordion_parent_id; ?>.accordion-style-style2 .accordion-heading .accordion-toggle.collapsed {
			<?php if ($item_heading_background_color !== null) : ?>
				background: <?php echo $item_heading_background_color; ?>;
			<?php endif; ?>
		}

		#<?php echo $accordion_parent_id; ?>.accordion-style-style2 .accordion-heading .accordion-toggle,
		#<?php echo $accordion_parent_id; ?>.accordion-style-style1 .accordion-heading .accordion-toggle,
		#<?php echo $accordion_parent_id; ?>.accordion-style-style1 .accordion-heading .accordion-toggle:hover,
		#<?php echo $accordion_parent_id; ?>.accordion-style-style1 .accordion-heading .accordion-toggle,
		#<?php echo $accordion_parent_id; ?>.accordion-style-style1 .accordion-heading .accordion-toggle:hover .accordion-title-wrapper,
		#<?php echo $accordion_parent_id; ?>.accordion-style-style1 .accordion-heading .accordion-toggle .accordion-title-wrapper {
			<?php if ($open_item_heading_color !== null) : ?>
				color: <?php echo $open_item_heading_color; ?>;
			<?php endif; ?>
		}

		#<?php echo $accordion_parent_id; ?>.accordion-style-style2 .accordion-heading .accordion-toggle {
			<?php if ($open_item_heading_background_color !== null) : ?>
			background: <?php echo $open_item_heading_background_color; ?>;
			<?php endif; ?>
		}




		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		$ret_val = '<div class="accordion accordion-style-' . $style . '" id="' . $accordion_parent_id . '">' . do_shortcode($content) . '</div>';
		$accordion_parent_id = null;
		return $ret_val;
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

global $accordion_sc_handler;
$accordion_sc_handler = new AdapAccordionSC('accordion');

class AdapAccordionItemSC extends AdapShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'title' => 'Accordion Item',
			'open' => 'false');
		extract(shortcode_atts($defaults, $atts));

		$open = $open == "false" ? false : true;
		$open_class = $open ? 'in' : '';

		$collapsed_class = $open ? '' : 'collapsed';

		$icon_class = $open ? 'entypo-minus-squared' : 'entypo-plus-squared';
		$link_class = $open ? '' : 'closed';

		global $accordion_parent_id;
		global $accordion_sync;

		// Don't write out the accordion parent id if sync isn't wanted
		$accordion_parent_id = $accordion_sync ? $accordion_parent_id : null;

		$accordion_item_id = uniqid('accordion_item_');

		$ret_val = '<div class="accordion-group">';
		$ret_val .= '<div class="accordion-heading">';
		$ret_val .= '<a class="accordion-toggle ' . $link_class . ' ' . $collapsed_class . '" data-toggle="collapse" data-parent="#' . $accordion_parent_id
			. '" data-target="#' . $accordion_item_id . '">';
		$ret_val .= '<i class="' . $icon_class . ' accordion-toggle-icon"></i>';
		$ret_val .= '<span class="accordion-title-wrapper ">' . $title . '</span>';
		$ret_val .= '</a>';
		$ret_val .= '</div>';
		$ret_val .= '<div id="' . $accordion_item_id . '" class="accordion-body collapse ' . $open_class . '">';
		$ret_val .= '<div class="accordion-inner" >';
		$ret_val .= do_shortcode($content);
		$ret_val .= '</div></div></div>';

		return $ret_val;
	}

	function register_vc()
	{
		//deregister and reregister how we'd like the accordion options to appear
		wpb_remove('vc_accordion');
		wpb_remove('vc_accordion_tab');

		//copy the js_editor declarations and modify the "params" so that
		//we can have the options we want to appear. We'll use there options when we route to
		//our own accordion shortcode handler.
		wpb_map(array(
			"name" => __("Accordion", 'adap_sc'),
			"base" => "vc_accordion",
			"show_settings_on_create" => false,
			"is_container" => true,
			"icon" => "icon-wpb-ui-accordion",
			"category" => __('Content', 'adap_sc'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'adap_sc'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'adap_sc')
				),
				array(
					"type" => 'checkbox',
					"heading" => __("Sync Accordion Items", 'adap_sc'),
					"param_name" => "sync",
					"description" => __("", 'adap_sc'),
					"value" => Array(__("Sync", 'adap_sc') => 'true')
				),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Style", 'adap_sc'),
					'param_name' => 'style',
					'sch_default' => 'normal',
					'value' => array('Style #1 (standard with minimal styling)' => 'style1', 'Style #2 (colored block headings)' => 'style2'),
					'description' => 'The color of the progress bar.',
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Item Heading Text Color', 'adap_sc'),
					'param_name' => 'item_heading_color',
					'value' => null,
					'description' => __('The text color of accordion item headings.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Item Heading Background Color', 'adap_sc'),
					'param_name' => 'item_heading_background_color',
					'value' => null,
					'description' => __('The background color of accordion item headings.', 'adap_sc'),
					"dependency" => Array('element' => "style", 'value' => array('style2'))
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Open Item Heading Text Color', 'adap_sc'),
					'param_name' => 'open_item_heading_color',
					'value' => null,
					'description' => __('The text color of open accordion item headings.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Divider Color', 'adap_sc'),
					'param_name' => 'divider_color',
					'value' => null,
					'description' => __('The color of the divider between each toggle in the accordion.', 'adap_sc'),
					"dependency" => Array('element' => "style", 'value' => array('style1'))
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Open Item Heading Background Color', 'adap_sc'),
					'param_name' => 'open_item_heading_background_color',
					'value' => null,
					'description' => __('The background color of open accordion item headings.', 'adap_sc'),
					"dependency" => Array('element' => "style", 'value' => array('style2'))
				),
				array(
					"type" => 'checkbox',
					"heading" => __("Bold Titles?", 'adap_sc'),
					"param_name" => "bold_titles",
					"description" => __("", 'adap_sc'),
					"value" => Array(__("Yes", 'adap_sc') => 'true')
				),

			),
			"custom_markup" => '
  <div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
  %content%
  </div>
  <div class="tab_controls">
  <button class="add_tab" title="' . __("Add accordion section", 'adap_sc') . '">' . __("Add accordion section", 'adap_sc') . '</button>
  </div>
  ',
			'default_content' => '
  [vc_accordion_tab title="' . __('Section 1', 'adap_sc') . '"][/vc_accordion_tab]
  [vc_accordion_tab title="' . __('Section 2', 'adap_sc') . '"][/vc_accordion_tab]
  ',
			'js_view' => 'VcAccordionView'
		));
		wpb_map(array(
			"name" => __("Accordion Section", 'adap_sc'),
			"base" => "vc_accordion_tab",
			"allowed_container_element" => 'vc_row',
			"is_container" => true,
			"content_element" => false,
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __("Title", 'adap_sc'),
					"param_name" => "title",
					"description" => __("Accordion section title.", 'adap_sc')
				),
				array(
					"type" => 'checkbox',
					"heading" => __("Open on load", 'adap_sc'),
					"param_name" => "open",
					"description" => __("", 'adap_sc'),
					"value" => Array(__("Open", 'adap_sc') => 'true')
				)
			),
			'js_view' => 'VcAccordionTabView'
		));
	}
}

/**
 * Override Visual Composer Accordion control output
 */

global $accordion_item_sc_handler;
$accordion_item_sc_handler = new AdapAccordionItemSC('accordion_item');

function vc_theme_vc_accordion_tab($atts, $content = null)
{
	global $accordion_item_sc_handler;
	return $accordion_item_sc_handler->shortcode_handler($atts, $content);
}

function vc_theme_vc_accordion($atts, $content = null)
{
	global $accordion_sc_handler;
	return $accordion_sc_handler->shortcode_handler($atts, $content);
}