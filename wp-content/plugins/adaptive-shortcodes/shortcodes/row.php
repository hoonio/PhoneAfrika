<?php

add_action('admin_init', 'init_alt_row');
/**
 * Override Row behavior
 */
function init_alt_row()
{
	if (function_exists('wpb_map')) {
		wpb_map(array(
			"name" => __("Row", 'adap_sc'),
			"base" => "vc_row",
			"is_container" => true,
			"icon" => "icon-wpb-row",
			"show_settings_on_create" => false,
			"category" => __('Content', 'adap_sc'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'adap_sc'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'adap_sc')
				),
				AdapAutoVCShortcode::bool_param('full_width', 'Full Width', 'Make Full Width', 'Don\'t Make Full Width', false),
				AdapAutoVCShortcode::bool_param('content_full_width', 'Content Full Width', 'Make Content Full Width', 'Don\'t Make Content Full Width', false, array('element' => "full_width", 'value' => array('true'))),
				AdapAutoVCShortcode::bool_param('background_transparent', 'Background Transparency', 'Make Transparent', 'Don\'t Make Transparent', false, array('element' => "full_width", 'value' => array('true'))),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Background Color', 'adap_sc'),
					'param_name' => 'background_color',
					'value' => null,
					'description' => __('The background color that is applied to the row if the row is full width.', 'adap_sc'),
				),
				array(
					"type" => "attach_image",
					'holder' => 'div',
					'class' => '',
					'heading' => __('Background Image', 'adap_sc'),
					'param_name' => 'background_image',
					'value' => null,
					'description' => __('The background image that is applied to the row if the row is full width.', 'adap_sc'),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background Image Repeat', 'adap_sc'),
					'param_name' => 'background_repeat',
					'sch_default' => 'repeat',
					'value' => array(
						'Repeat All' => 'repeat',
						'Repeat X' => 'repeat-x',
						'Repeat Y' => 'repeat-y',
						'No Repeat' => 'no-repeat'
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background Position', 'adap_sc'),
					'param_name' => 'background_position',
					'sch_default' => 'top left',
					'value' => array(
						'Top Left' => 'top left',
						'Top Center' => 'top center',
						'Top Right' => 'top right',
						'Center Left' => 'center left',
						'Center Center' => 'center center',
						'Center Right' => 'center right',
						'Bottom Left' => 'bottom left',
						'Bottom Center' => 'bottom center',
						'Bottom Right' => 'bottom right',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Background Attachment', 'adap_sc'),
					'param_name' => 'background_attachment',
					'sch_default' => 'scroll',
					'value' => array(
						'Scroll' => 'scroll',
						'Fixed' => 'fixed',
						'Inherit' => 'inherit'
					),
				),
				AdapAutoVCShortcode::bool_param('background_cover', 'Stretch Background Image')
			),
			"js_view" => 'VcRowView'
		));
	}

}