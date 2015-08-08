<?php

function peach_metaboxes($meta_boxes)
{
	$prefix = '_peach_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'peach_options_metabox',
		'title' => 'Subheader Options',
		'pages' => array('page', 'post'), // post type
		'context' => 'normal',
		'priority' => 'low',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Hide Subheader?',
				'desc' => 'Hide the Subheader that appears at the top of the page?',
				'id' => $prefix . 'hide_subheader',
				'type' => 'checkbox'
			),
		),
	);

	$meta_boxes[] = array(
		'id' => 'page_background_metabox',
		'title' => 'Background Options',
		'pages' => array('page'), // post type
		'context' => 'normal',
		'priority' => 'low',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Color',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'bkgd_color',
				'type' => 'colorpicker',
				'std' => ''
			),
			array(
				'name' => 'Image',
				'desc' => 'The Background Image',
				'id' => $prefix . 'bkgd_img',
				'type' => 'file',
			),
			array(
				'name' => 'Repeat',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'bkgd_repeat',
				'type' => 'select',
				'options' => array(
					array('name' => 'No Repeat', 'value' => 'no-repeat',),
					array('name' => 'Repeat Horizontally', 'value' => 'repeat-x',),
					array('name' => 'Repeat Vertically', 'value' => 'repeat-y',),
					array('name' => 'Repeat All', 'value' => 'repeat',),
				)
			),
			array(
				'name' => 'Position',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'bkgd_position',
				'type' => 'select',
				'options' => array(
					array('name' => 'Top Left', 'value' => 'top left'),
					array('name' => 'Top Center', 'value' => 'top center'),
					array('name' => 'Top Right', 'value' => 'top right'),
					array('name' => 'Middle Left', 'value' => 'center left'),
					array('name' => 'Middle Center', 'value' => 'center center'),
					array('name' => 'Middle Right', 'value' => 'center right'),
					array('name' => 'Bottom Left', 'value' => 'bottom left'),
					array('name' => 'Bottom Center', 'value' => 'bottom center'),
					array('name' => 'Bottom Right', 'value' => 'bottom right')
				)
			),
			array(
				'name' => 'Attachment',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'bkgd_attachment',
				'type' => 'select',
				'options' => array(
					array('name' => 'Scroll Normally', 'value' => 'scroll',),
					array('name' => 'Fixed in Place', 'value' => 'fixed',),

				)
			),
			array(
				'name' => 'Background Cover',
				'desc' => 'Stretch the background image to cover the entire e=area',
				'id' => $prefix . 'bkgd_cover',
				'type' => 'checkbox'
			),
		));

	$meta_boxes[] = array(
		'id' => 'page_background_metabox',
		'title' => 'Background Options',
		'pages' => array('page'), // post type
		'context' => 'normal',
		'priority' => 'low',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Color',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'bkgd_color',
				'type' => 'colorpicker',
				'std' => ''
			),
			array(
				'name' => 'Image',
				'desc' => 'The Background Image',
				'id' => $prefix . 'bkgd_img',
				'type' => 'file',
			),
			array(
				'name' => 'Repeat',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'bkgd_repeat',
				'type' => 'select',
				'options' => array(
					array('name' => 'No Repeat', 'value' => 'no-repeat',),
					array('name' => 'Repeat Horizontally', 'value' => 'repeat-x',),
					array('name' => 'Repeat Vertically', 'value' => 'repeat-y',),
					array('name' => 'Repeat All', 'value' => 'repeat',),
				)
			),
			array(
				'name' => 'Position',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'bkgd_position',
				'type' => 'select',
				'options' => array(
					array('name' => 'Top Left', 'value' => 'top left'),
					array('name' => 'Top Center', 'value' => 'top center'),
					array('name' => 'Top Right', 'value' => 'top right'),
					array('name' => 'Middle Left', 'value' => 'center left'),
					array('name' => 'Middle Center', 'value' => 'center center'),
					array('name' => 'Middle Right', 'value' => 'center right'),
					array('name' => 'Bottom Left', 'value' => 'bottom left'),
					array('name' => 'Bottom Center', 'value' => 'bottom center'),
					array('name' => 'Bottom Right', 'value' => 'bottom right')
				)
			),
			array(
				'name' => 'Attachment',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'bkgd_attachment',
				'type' => 'select',
				'options' => array(
					array('name' => 'Scroll Normally', 'value' => 'scroll',),
					array('name' => 'Fixed in Place', 'value' => 'fixed',),

				)
			),
			array(
				'name' => 'Background Cover',
				'desc' => 'Stretch the background image to cover the entire e=area',
				'id' => $prefix . 'bkgd_cover',
				'type' => 'checkbox'
			),
		));

	$meta_boxes[] = array(
		'id' => 'page_header_background_metabox',
		'title' => 'Header Background Options',
		'pages' => array('page'), // post type
		'context' => 'normal',
		'priority' => 'low',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Color',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'header_bkgd_color',
				'type' => 'colorpicker',
				'std' => ''
			),
			array(
				'name' => 'Image',
				'desc' => 'The Background Image',
				'id' => $prefix . 'header_bkgd_img',
				'type' => 'file',
			),
			array(
				'name' => 'Repeat',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'header_bkgd_repeat',
				'type' => 'select',
				'options' => array(
					array('name' => 'No Repeat', 'value' => 'no-repeat',),
					array('name' => 'Repeat Horizontally', 'value' => 'repeat-x',),
					array('name' => 'Repeat Vertically', 'value' => 'repeat-y',),
					array('name' => 'Repeat All', 'value' => 'repeat',),
				)
			),
			array(
				'name' => 'Position',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'header_bkgd_position',
				'type' => 'select',
				'options' => array(
					array('name' => 'Top Left', 'value' => 'top left'),
					array('name' => 'Top Center', 'value' => 'top center'),
					array('name' => 'Top Right', 'value' => 'top right'),
					array('name' => 'Middle Left', 'value' => 'center left'),
					array('name' => 'Middle Center', 'value' => 'center center'),
					array('name' => 'Middle Right', 'value' => 'center right'),
					array('name' => 'Bottom Left', 'value' => 'bottom left'),
					array('name' => 'Bottom Center', 'value' => 'bottom center'),
					array('name' => 'Bottom Right', 'value' => 'bottom right')
				)
			),
			array(
				'name' => 'Attachment',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'header_bkgd_attachment',
				'type' => 'select',
				'options' => array(
					array('name' => 'Scroll Normally', 'value' => 'scroll',),
					array('name' => 'Fixed in Place', 'value' => 'fixed',),

				)
			),
			array(
				'name' => 'Background Cover',
				'desc' => 'Stretch the background image to cover the entire area',
				'id' => $prefix . 'header_bkgd_cover',
				'type' => 'checkbox'
			),
			array(
				'name' => 'Background Transparent',
				'desc' => 'Set the background transparent. This will override all the other background options',
				'id' => $prefix . 'header_bkgd_transparent',
				'type' => 'checkbox'
			),
		));

	if (function_exists('bcn_display')) {
		$meta_boxes[] = array(
			'id' => 'breadcrumb_metabox',
			'title' => 'Breadcrumb Options',
			'pages' => array('page', 'post', 'portfolio'), // post type
			'context' => 'normal',
			'priority' => 'low',
			'show_names' => true, // Show field names on the left
			'fields' => array(
				array(
					'name' => 'Align',
					'desc' => 'the aligment of the breadcrumb',
					'id' => $prefix . 'breadcrumb_align',
					'type' => 'select',
					'options' => array(
						array('name' => 'Left', 'value' => 'left',),
						array('name' => 'Right', 'value' => 'right'),
					)
				),
				array(
					'name' => 'Hide Breadcrumb?',
					'desc' => 'Hide the Breadcrumb that appears at the top of the page?',
					'id' => $prefix . 'hide_breadcrumb',
					'type' => 'checkbox'
				),
			));
	}

	return $meta_boxes;
}

add_filter('cmb_meta_boxes', 'peach_metaboxes');