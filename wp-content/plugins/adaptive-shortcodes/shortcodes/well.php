<?php

class AdapWellSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));

		if ($size) {
			$size = 'well-' . $size;
		}
		return sprintf('<div class="well %s">%s</div>', $size, do_shortcode($content));
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Well',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),

			//START VC Container Related Params
			"allowed_container_element" => 'vc_row',
			"is_container" => true,
			'js_view' => 'VcColumnView',
			//END VC Container related Params

			'params' => array(
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => __("Content", 'adap_sc'),
					"param_name" => "content",
					"value" => __("This is an example well content", 'adap_sc'),
//                    "description" => __("This is an example well content.")
				),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Size', 'adap_sc'),
					'param_name' => 'size',

					'sch_default' => false,
					'value' => array('Regular' => false, 'Large' => 'large', 'Small' => 'small'),
					'description' => __('The well size', 'adap_sc')
				)
			)
		);
	}
}

new AdapWellSC('well');

/**
 * Register Container Behavior
 */
add_action('init', 'vc_well_class');
function vc_well_class()
{
	if (class_exists('WPBakeryShortCode_Adap_Container')) {
		class WPBakeryShortCode_Well extends WPBakeryShortCode_Adap_Container
		{
		}
	}
}
