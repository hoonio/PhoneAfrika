<?php

class AdapSpacerSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));

		$height = str_replace('px', '', $height);
		$display = '';
		if ($display_desktop == 'false') {
			$display .= 'hidden-desktop ';
		}

		if ($display_tablet == 'false') {
			$display .= 'hidden-tablet ';
		}

		if ($display_mobile == 'false') {
			$display .= 'hidden-phone ';
		}
		ob_start();
		?>
		<div class="adap-spacer <?php echo $display; ?>" style="height:<?php echo $height ?>px;"></div>
		<?php

		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Spacer',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Height", 'adap_sc'),
					'param_name' => 'height',
					'value' => '23',
					'description' => __('The height (in pixels) of the spacer', 'adap_sc')
				),
				AdapAutoVCShortcode::bool_param('display_desktop', __('Display in Desktop Layout', 'adap_sc')),
				AdapAutoVCShortcode::bool_param('display_tablet', __('Display in Tablet Layout', 'adap_sc')),
				AdapAutoVCShortcode::bool_param('display_mobile', __('Display in Mobile Layout', 'adap_sc')),

			)
		);
	}
}

new AdapSpacerSC('spacer');