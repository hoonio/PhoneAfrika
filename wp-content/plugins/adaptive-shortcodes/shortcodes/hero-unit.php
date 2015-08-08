<?php

class AdapHeroUnitSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));

		// Generate a Unique ID for the Element
		$element_id = uniqid('herounit_');

		// Mobile Alignment Option
		$mobile_alignment_class = '';
		if (isset($mobile_center)) {
			$mobile_center = strtolower($mobile_center);
			if ($mobile_center == 'true') {
				$mobile_alignment_class = 'mobile-center-align';
			}
		}

		// Configure Custom Colors
		global $custom_css;
		ob_start();
		?>

		<?php if (isset($background_color)) { ?>

		#<?php echo $element_id; ?> {
		background: <?php echo $background_color; ?>;
		}

	<?php } ?>

		<?php if (isset($text_color)) { ?>

		#<?php echo $element_id; ?>,
		#<?php echo $element_id; ?> p {
		color: <?php echo $text_color; ?>;
		}

	<?php } ?>

		<?php if (isset($heading_color)) { ?>

		#<?php echo $element_id; ?> h1,
		#<?php echo $element_id; ?> h2,
		#<?php echo $element_id; ?> h3,
		#<?php echo $element_id; ?> h4,
		#<?php echo $element_id; ?> h5,
		#<?php echo $element_id; ?> h6{
		color: <?php echo $heading_color; ?>;
		}

	<?php } ?>

		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();

		// Generate Hero Unit
		ob_start();


		$rounded_corners_class = '';
		if (isset($rounded_corners) && $rounded_corners == 'false') {
			$rounded_corners_class = 'no-rounded-corners';
		}

		$padding_class = 'hero-unit-';
		if (isset($padding)) {
			$padding_class .= $padding . '-padding';
		} else {
			$padding_class .= $padding . '-normal-padding';
		}

		?>
		<div id="<?php echo $element_id; ?>"
			 class="hero-unit hero-unit-shortcode <?php echo $mobile_alignment_class; ?> <?php echo $padding_class; ?> <?php echo $rounded_corners_class; ?>">
			<?php echo do_shortcode($content); ?>
		</div>
		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;

	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Hero Unit',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),

			//START VC Container Related Params
//            "allowed_container_element" => 'vc_row',
//            "as_child" => array('only' => 'vc_row'),

			"is_container" => true,
			'js_view' => 'VcColumnView',
			//END VC Container related Params

			'params' => array(
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Background Color', 'adap_sc'),
					'param_name' => 'background_color',
					'value' => null,
					'description' => __('The background color of blockquote.', 'adap_sc'),
					"dependency" => Array('element' => "style", 'value' => array('style1'))
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Text Color', 'adap_sc'),
					'param_name' => 'text_color',
					'value' => null,
					'description' => __('The text color of blockquote.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Heading Color', 'adap_sc'),
					'param_name' => 'heading_color',
					'value' => null,
					'description' => __('The heading color of blockquote.', 'adap_sc'),
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Center everything in mobile?', 'adap_sc'),
					'param_name' => 'mobile_center',

					'sch_default' => 'false',
					'value' => array('Enable' => 'true'),
					'description' => __('Check this to align content to the center in the mobile layout.', 'adap_sc')
				),
				AdapAutoVCShortcode::bool_param('rounded_corners', __('Round the corners?', 'adap_sc')),
				array(
					'type' => 'dropdown',
					'heading' => 'Padding',
					'param_name' => 'padding',
					'sch_default' => 'normal',
					'value' => array(
						'Normal' => 'normal',
						'Small' => 'small',
						'None' => 'none'

					),
				),

			)


		);
	}
}

new AdapHeroUnitSC('hero_unit');


/**
 * Register Container Behavior
 */
add_action('init', 'vc_hero_unit_class');
function vc_hero_unit_class()
{
	if (class_exists('WPBakeryShortCode_Adap_Container')) {
		class WPBakeryShortCode_Hero_Unit extends WPBakeryShortCode_Adap_Container
		{
		}
	}
}