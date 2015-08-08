<?php

class AdapPricingPlanSC extends AdapAutoVCShortcode
{

	function shortcode_handler($atts, $content = null)
	{

		extract($this->getPreparedAtts($atts, $content));

		// Generate a Unique ID for the Element
		$element_id = uniqid('pricingplan_');

		// Configure Custom CSS
		global $custom_css;
		ob_start();
		?>

		<?php if ($header_text_color !== null) : ?>
		#<?php echo $element_id; ?> .pricing-plan-header {
		color: <?php echo $header_text_color; ?>;
		}
	<?php endif; ?>

		<?php if ($header_title_color !== null) : ?>
		#<?php echo $element_id; ?> .pricing-plan-header .pricing-plan-title {
		color: <?php echo $header_title_color; ?>;
		}
	<?php endif; ?>


		<?php if ($header_background_color !== null) : ?>
		#<?php echo $element_id; ?> .pricing-plan-header {
		background: <?php echo $header_background_color; ?>;
		}
	<?php endif; ?>

		<?php if ($details_text_color !== null) : ?>
		#<?php echo $element_id; ?> .pricing-plan-details,
		#<?php echo $element_id; ?> .pricing-plan-details p,
		#<?php echo $element_id; ?> .pricing-plan-details li {
		color: <?php echo $details_text_color; ?>;
		}
	<?php endif; ?>

		<?php if ($details_background_color !== null) : ?>
		#<?php echo $element_id; ?> .pricing-plan-details {
		background: <?php echo $details_background_color; ?>;
		}
		.pricing-table #<?php echo $element_id; ?> .pricing-plan-header{
		background: <?php echo $details_background_color; ?>;
		}
	<?php endif; ?>

		<?php if ($header_background_color !== null) : ?>
		.pricing-table #<?php echo $element_id; ?> .pricing-plan-title-wrapper {
		background: <?php echo $header_background_color; ?>;
		}

		.pricing-table #<?php echo $element_id; ?>.pricing-plan-featured .pricing-plan-title-wrapper {
		border-color: <?php echo $header_background_color; ?>;
		}
	<?php endif; ?>

		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		$featured_class = $featured && $featured == 'true' ? 'pricing-plan-featured' : '';

		// Generate Plan
		ob_start();
		?>

		<div id="<?php echo $element_id; ?>" class="pricing-plan-shortcode <?php echo $featured_class; ?>">
			<div class="pricing-plan-header">
				<div class="pricing-plan-title-wrapper"><h4 class="pricing-plan-title"><?php echo $title; ?></h4></div>
				<div class="pricing-plan-price-wrapper">
					<span class="pricing-plan-currency"><?php echo $currency; ?></span>
                    <span
						class="pricing-plan-price"><?php echo $price; ?></span><?php if ($period && strlen($period) > 0) { ?>
						<span class="pricing-plan-period">/<?php echo $period ?></span><?php } ?>
				</div>
			</div>
			<div class="pricing-plan-details"><?php echo do_shortcode($content); ?></div>
		</div>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}


	function configureParams()
	{
		$this->params = array(
			'name' => 'Pricing Plan',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Title", 'adap_sc'),
					'param_name' => 'title',
					'value' => '',
					'description' => __('The title of the pricing plan.', 'adap_sc')
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Currency", 'adap_sc'),
					'param_name' => 'currency',
					'value' => '$',
					'description' => __('The currency the price is in.', 'adap_sc')
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Price", 'adap_sc'),
					'param_name' => 'price',
					'value' => '',
					'description' => __('The price of the plan.', 'adap_sc')
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Price", 'adap_sc'),
					'param_name' => 'price',
					'value' => '',
					'description' => __('The price of the plan.', 'adap_sc')
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Period", 'adap_sc'),
					'param_name' => 'period',
					'value' => 'month',
					'description' => __('The period of time the price covers (leave blank if not needed).', 'adap_sc')
				),
				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Pricing Plan Details', 'adap_sc'),
					'param_name' => 'content',
					'sch_default' => '',
					'value' => '<ul>
                    <li>Vestibulum erat</li>
                    <li>Accumsan posuere</li>
                    <li>Sodales molestie </li>
                    <li>Mauris ut ante lacus</li>
                    <li>Vehicula dignissim</li>
                    </ul>
                    [button label="Sign Up" url="#" size="large" window="false" block="false" icon="none"]',
					'description' => __('Edit this list to change the details of the plan.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Header Title Color', 'adap_sc'),
					'param_name' => 'header_title_color',
					'value' => null,
					'description' => __('The text color of the title in the plan header.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Header Price Color', 'adap_sc'),
					'param_name' => 'header_text_color',
					'value' => null,
					'description' => __('The text color of the price in the plan header.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Header Background Color', 'adap_sc'),
					'param_name' => 'header_background_color',
					'value' => null,
					'description' => __('The background color of the plan header.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Details Text Color', 'adap_sc'),
					'param_name' => 'details_text_color',
					'value' => null,
					'description' => __('The text color in the plan details.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Details Background Color', 'adap_sc'),
					'param_name' => 'details_background_color',
					'value' => null,
					'description' => __('The background color of the plan details.', 'adap_sc')
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Featured?', 'adap_sc'),
					'param_name' => 'featured',

					'sch_default' => 'false',
					'value' => array('Enable' => 'true'),
					'description' => __('Whether the plan is featured and should pop out above the other plans. Note that this only works if the plan is contained inside a pricing table shortcode.', 'adap_sc')
				),

			));
	}
}

new AdapPricingPlanSC('pricing_plan');


class AdapPricingTableSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));

		$adap_pricing_plan_count = substr_count($content, '[pricing_plan ');

		// Generate a Unique ID for the Element
		$element_id = uniqid('pricingtable_');

		// Configure Custom CSS
		global $custom_css;
		ob_start();
		?>

		<?php if ($border_color !== null) : ?>
		#<?php echo $element_id; ?>,
		#<?php echo $element_id; ?> .pricing-plan-shortcode,
		#<?php echo $element_id; ?> .pricing-plan-header,
		#<?php echo $element_id; ?> .pricing-plan-price-wrapper,
		#<?php echo $element_id; ?> .pricing-plan-details,
		#<?php echo $element_id; ?> .pricing-plan-details ul,
		#<?php echo $element_id; ?> .pricing-plan-details li
		{
		border-color: <?php echo $border_color; ?>;
		}
	<?php endif; ?>


		<?php if ($alternate_background_color !== null) : ?>
		#<?php echo $element_id; ?> .pricing-plan-details li:nth-child(odd) {
		background-color: <?php echo $alternate_background_color; ?>;
		}
	<?php endif; ?>


		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();

		return sprintf('<div id="%s" class="pricing-table-column-count-%s pricing-table">%s</div>',
			$element_id, $adap_pricing_plan_count, do_shortcode($content));
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Pricing Table',
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
					'heading' => __('Border Color', 'adap_sc'),
					'param_name' => 'border_color',
					'value' => null,
					'description' => __('The border color of the elements in the pricing table.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Alternate Background Color', 'adap_sc'),
					'param_name' => 'alternate_background_color',
					'value' => null,
					'description' => __('The alternate background color to use in the details list.', 'adap_sc')
				),
			)
		);
	}
}

new AdapPricingTableSC('pricing_table');


/**
 * Register Container Behavior
 */
add_action('init', 'vc_pricing_table_class');
function vc_pricing_table_class()
{
	if (class_exists('WPBakeryShortCode_Adap_Container')) {
		class WPBakeryShortCode_Pricing_Table extends WPBakeryShortCode_Adap_Container
		{
		}
	}
}