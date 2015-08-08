<?php

class AdapDividerSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));

		// Generate a Unique ID for the Element
		$element_id = uniqid('divider_');

		// Configure Custom CSS
		global $custom_css;
		ob_start();
		?>

		<?php if ($color !== null) : ?>
		#<?php echo $element_id; ?> {
		border-color: <?php echo $color; ?>;
		}
	<?php endif; ?>


		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();

		$divider_style = 'divider-style-' . $style;

		ob_start();
		?>
		<hr id="<?php echo $element_id; ?>" class="divider-shortcode <?php echo $divider_style; ?>"/>
		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}


	function configureParams()
	{
		$this->params = array(
			'name' => 'Divider',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Style', 'adap_sc'),
					'param_name' => 'style',

					'sch_default' => '',
					'value' => array(
						'Thin' => 'thin',
						'Thick' => 'thick',
						'Dashed' => 'dashed'
					),
					'description' => __('Choose which divider style you\'d like.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Color', 'adap_sc'),
					'param_name' => 'color',
					'value' => null,
					'description' => __('Choose a color to use for the divider.', 'adap_sc')
				),
			));
	}
}

new AdapDividerSC('divider');