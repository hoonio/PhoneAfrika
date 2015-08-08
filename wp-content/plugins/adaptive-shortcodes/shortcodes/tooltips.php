<?php


class AdapTooltipSC extends AdapAutoVCShortcode
{
	/**
	 * Attributes:
	 * title - the title displayed on the tooltip
	 * http://getbootstrap.com/2.3.2/javascript.html#tooltips
	 * @param $atts
	 * @param null $content
	 * @return string
	 */
	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'title' => 'Tooltip Title',
			'placement' => 'top',
			'trigger' => 'hover',
			'html' => 'false',
			'color' => null,
			'tooltip_color' => null,
			'tooltip_background' => null,
			'opacity' => '0.9'
		);
		extract(shortcode_atts($defaults, $atts));

		// Generate a Unique ID for the Element
		$element_id = uniqid('tooltip_');

		// Configure Custom Colors
		global $custom_css;
		ob_start();
		?>

		<?php if ($color !== null) : ?>
		#<?php echo $element_id; ?> {
		color: <?php echo $color; ?>;
		}
	<?php endif; ?>

		#<?php echo $element_id; ?>+.tooltip.in {
		opacity: <?php echo $opacity; ?>;
		}

		#<?php echo $element_id; ?>+.tooltip .tooltip-inner {
		<?php if ($tooltip_color !== null) : ?>
		color: <?php echo $tooltip_color; ?>;
	<?php endif; ?>

		<?php if ($tooltip_background !== null) : ?>
		background: <?php echo $tooltip_background; ?>;
	<?php endif; ?>
		}

		<?php if ($tooltip_background !== null) : ?>
		#<?php echo $element_id; ?>+.tooltip.top .tooltip-arrow {
		border-top-color: <?php echo $tooltip_background; ?>;
		}
		#<?php echo $element_id; ?>+.tooltip.bottom .tooltip-arrow {
		border-bottom-color: <?php echo $tooltip_background; ?>;
		}
		#<?php echo $element_id; ?>+.tooltip.right .tooltip-arrow {
		border-right-color: <?php echo $tooltip_background; ?>;
		}
		#<?php echo $element_id; ?>+.tooltip.left .tooltip-arrow {
		border-left-color: <?php echo $tooltip_background; ?>;
		}
	<?php endif; ?>


		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		// Generate tooltip
		ob_start();
		?>

		<a class="tooltip-shortcode" id="<?php echo $element_id; ?>" href="#" data-toggle="tooltip"
		   title="<?php echo $title; ?>" data-placement="<?php echo $placement; ?>"
		   data-trigger="<?php echo $trigger; ?>"
		   data-html="<?php echo $html; ?>"><?php echo do_shortcode($content) ?></a>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function configureParams()
	{
	}
}

new AdapTooltipSC('tooltip');

class AdapPopoverSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		$defaults = $this->getShortcodeDefaults();
		extract(shortcode_atts($defaults, $atts));

		$html = strtolower($html);

		// Generate a Unique ID for the Element
		$element_id = uniqid('popover_');


		// Configure Custom Colors
		global $custom_css;
		ob_start();
		?>

		#<?php echo $element_id; ?> {
		color: <?php echo $target_color; ?>;
		}

		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		// Generate Popover
		ob_start();
		?>

		<a id="<?php echo $element_id; ?>" class="popover-shortcode" href="#" data-toggle="popover"
		   data-content="<?php echo do_shortcode($text); ?>"
		   data-placement="<?php echo $placement; ?>" data-trigger="<?php echo $trigger ?>"
		   data-original-title="<?php echo $title; ?>"
		   data-html="<?php echo $html; ?>"><?php echo do_shortcode($content); ?></a>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return trim($ret_val);
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Popover',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Title', 'adap_sc'),
					'param_name' => 'title',
					'value' => __('', 'adap_sc'),
					'description' => __('The title of the popover', 'adap_sc')
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Text", 'adap_sc'),
					"param_name" => "text",
					"value" => __("The content to show in the popover.", 'adap_sc'),
					"description" => __("The target content for the popover", 'adap_sc')
				),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Placement', 'adap_sc'),
					'param_name' => 'placement',

					'sch_default' => 'top',
					'value' => array('Top' => 'top', 'Left' => 'left', 'Right' => 'right', 'Bottom' => 'bottom'),
					'description' => __('Where the popover appears in relation to the target.', 'adap_sc')
				),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Trigger', 'adap_sc'),
					'param_name' => 'trigger',

					'sch_default' => 'click',
					'value' => array('Click' => 'click', 'Hover' => 'hover'),
					'description' => __('The action that will trigger the popover display', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Target Color','adap_sc'),
					'param_name' => 'target_color',
					'value' => null,
					'description' => __('The color of the link that opens the popover.', 'adap_sc'),
					"dependency" => Array('element' => "color", 'value' => array('custom'))
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Disable HTML?', 'adap_sc'),
					'param_name' => 'html',

					'sch_default' => 'true',
					'value' => array('Disable HTML' => 'false'),
					'description' => __('Disable HTML display in the popover', 'adap_sc')
				)
			)
		);
	}
}

new AdapPopoverSC('popover');
