<?php

add_action('admin_init', '_adap_sc_add_column_full_width_option');

function _adap_sc_add_column_full_width_option()
{
	if (function_exists('wpb_add_param')) {
		wpb_add_param('vc_column', AdapAutoVCShortcode::bool_param('full_width', 'Full Width', 'Make Full Width', 'Don\'t Make Full Width', false));

		wpb_add_param('vc_column',
			array(
				'type' => 'dropdown',
				'heading' => 'Align',
				'param_name' => 'align',
				'sch_default' => 'align-none',
				'value' => array(
					'None' => 'align-none',
					'Align Left' => 'align-left',
					'Align Center' => 'align-center',
					'Align Right' => 'align-right'
				),
				'description' => 'The content alignment of the column'

			)
		);

	 vc_add_param('rev_slider_vc', array(
			'type' => 'dropdown',
			'heading' => 'Arrow Style',
			'param_name' => 'arrow_style',
			'sch_default' => 'small',
			'value' => array(
				'Small' => 'small',
				'Big' => 'big',
			),
			'description' => 'The arrow styling'
		));
	}
}