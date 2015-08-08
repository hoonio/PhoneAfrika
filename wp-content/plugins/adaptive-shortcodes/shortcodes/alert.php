<?php

class AdapAlertSC extends AdapAutoVCShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));

		// Generate a Unique ID for the Element
		$element_id = uniqid('alert_');

		// Configure Custom Colors
		global $custom_css;
		ob_start();
		?>

		#<?php echo $element_id; ?> {
		<?php if ($background !== null) : ?>
		background: <?php echo $background; ?>;
	<?php endif; ?>

		<?php if ($border_color !== null) : ?>
		border-color: <?php echo $border_color; ?>;
	<?php endif; ?>

		}

		#<?php echo $element_id; ?>,
		#<?php echo $element_id; ?> p {
		<?php if ($color !== null) : ?>
		color: <?php echo $color; ?>;
	<?php endif; ?>

		}

		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();

		// Generate Alert
		ob_start();
		?>
		<div id="<?php echo $element_id; ?>" class="alert alert-message alert-shortcode" data-alert="alert">
			<?php if ($show_close != 'false') echo '<a class="close" data-dismiss="alert" style="color:' . $color . ';" href="#">&times;</a>'; ?><?php echo do_shortcode($content); ?>
		</div>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Alert',
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
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Color', 'adap_sc'),
					'param_name' => 'color',
					'value' => null,
					'description' => __('Text Color', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Background Color', 'adap_sc'),
					'param_name' => 'background',
					'value' => null,
					'description' => __('The background color', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Border Color', 'adap_sc'),
					'param_name' => 'border_color',
					'value' => null,
					'description' => __('The Alert Color', 'adap_sc')
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Show Close?', 'adap_sc'),
					'param_name' => 'show_close',

					'sch_default' => 'false',
					'value' => array('Show Close' => 'true'),
					'description' => __('Show close icon in the alert', 'adap_sc')
				)
			)
		);
	}
}

new AdapAlertSC('alert');

/**
 * Register Container Behavior
 */
add_action('init', 'vc_alert_class');
function vc_alert_class()
{
	if (class_exists('WPBakeryShortCode_Adap_Container')) {
		class WPBakeryShortCode_Alert extends WPBakeryShortCode_Adap_Container
		{
		}
	}
}