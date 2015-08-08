<?php

class AdapButtonSC extends AdapAutoVCShortcode
{

	function shortcode_handler($atts, $content = null)
	{

		extract($this->getPreparedAtts($atts, $content));

		// Configure "Open in New Window" functionality
		$window = strtolower($window);
		if ($window && $window == 'true')
			$window = 'target="_blank" ';
		else
			$window = '';

		// Configure "Size"
		$size = !$size ? '' : 'btn-' . $size;

		// Configure "Full Width"
		$block = !$block || $block == 'false' ? '' : 'btn-block';

		// Generate a Unique ID for the Element
		$element_id = uniqid('btn_');

		// Configure Custom Colors
		global $custom_css;

		ob_start();
		?>
		#<?php echo $element_id; ?> {
		background: <?php echo $background_color; ?>;
		color: <?php echo $text_color; ?>;
		}
		#<?php echo $element_id; ?>:hover {
		background: <?php echo $hover_background_color; ?>;
		color: <?php echo $hover_text_color; ?>;
		}
		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		// Configure Icons
		$btn_icon_class = '';

		if ($icon && $icon != 'none') {
			$icon = '<i class="icon-' . $icon . '"></i>';
			$btn_icon_class .= 'btn-icon btn-icon-fontawesome';
		} else if ($entypo_icon && $entypo_icon != 'none' && $entypo_icon != 'None') {
			$icon = '<i class="entypo-' . $entypo_icon . '"></i>';
			$btn_icon_class .= 'btn-icon btn-icon-entypo';
		} else {
			$icon = null;
			$btn_icon_class = 'btn-no-icon';
		}


		// Generate Button
		ob_start();
		?>
		<a id="<?php echo $element_id; ?>" <?php echo $window; ?> href="<?php echo $url; ?>"
		   class="btn btn-shortcode <?php echo $size; ?> <?php echo $block; ?> <?php echo $btn_icon_class; ?>">
			<?php echo $icon; ?><span class="btn-text"><?php echo do_shortcode($label); ?></span>
		</a>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function configureParams()
	{
		global $icon_listing_with_none;
		global $entypo_listing_with_none;

		$this->params = array(
			'name' => 'Button',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Label", 'adap_sc'),
					'param_name' => 'label',
					'value' => 'Button',
					'description' => __("The button label.", 'adap_sc')
				),
				array(
					'type' => 'adap_dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Font Awesome Icon", 'adap_sc'),
					'param_name' => 'icon',
					'sch_default' => 'None',
					'value' => $icon_listing_with_none,
					'description' => __('Choose a Font Awesome Icon to appear at the beginning of this button. <a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/">Browse the icons here</a>.', 'adap_sc')
				),
				array(
					'type' => 'adap_dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Entypo Icon", 'adap_sc'),
					'param_name' => 'entypo_icon',
					'sch_default' => 'None',
					'value' => $entypo_listing_with_none,
					'description' => __('Choose an Entypo Icon to appear at the beginning of this button. <a target="_blank" href="http://www.entypo.com/">Browse the icons here</a>.', 'adap_sc')
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __("URL", 'adap_sc'),
					'param_name' => 'url',
					'value' => '',
					'description' => ''
				),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Size", 'adap_sc'),
					'param_name' => 'size',
					'sch_default' => 'Normal',
					'value' => array('Large' => 'large', 'Normal' => 'normal', 'Small' => 'small', 'Mini' => 'mini'),
					'description' => ''
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __("URL", 'adap_sc'),
					'param_name' => 'url',
					'value' => '',
					'description' => ''
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Open Link in New Window?', 'adap_sc'),
					'param_name' => 'window',

					'sch_default' => 'false',
					'value' => array('Enable' => 'true'),
					'description' => __('', 'adap_sc')
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Full Width?', 'adap_sc'),
					'param_name' => 'block',

					'sch_default' => 'false',
					'value' => array('Enable' => 'true'),
					'description' => __('Have the button take the width of its parent container.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Background Color', 'adap_sc'),
					'param_name' => 'background_color',
					'value' => null,
					'description' => __('', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Text Color', 'adap_sc'),
					'param_name' => 'text_color',
					'value' => null,
					'description' => __('', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Hover Background Color', 'adap_sc'),
					'param_name' => 'hover_background_color',
					'value' => null,
					'description' => __('', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Hover Text Color', 'adap_sc'),
					'param_name' => 'hover_text_color',
					'value' => null,
					'description' => __('', 'adap_sc'),
				)
			)
		);

	}

}

new AdapButtonSC('button');

class AdapButtonGroupSC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		extract(shortcode_atts(array(
			'vertical' => false
		), $atts));
		$vertical = !$vertical ? '' : 'btn-group-vertical';
		return sprintf('<div class="btn-group %s">%s</div>', $vertical, do_shortcode($content));
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapButtonGroupSC('button_group');

class AdapButtonToolbarSC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		return sprintf('<div class="btn-toolbar">%s</div>', do_shortcode($content));
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapButtonToolbarSC('button_toolbar');


