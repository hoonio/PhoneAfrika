<?php

class AdapBlockquoteSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));

		// Generate a Unique ID for the Element
		$element_id = uniqid('blockquote');

		// Configure Custom Colors
		global $custom_css;
		ob_start();
		?>

		<?php if ($color !== null) : ?>
		#<?php echo $element_id; ?> {
		color: <?php echo $color; ?>;
		border-color: <?php echo $color; ?>;
		}
		#<?php echo $element_id; ?> p {
		color: <?php echo $color; ?>;
		}
		#<?php echo $element_id; ?> .blockquote-left-border {
		background: <?php echo $color; ?>;
		}
		#<?php echo $element_id; ?> .top-divider,
		#<?php echo $element_id; ?> .bottom-divider {
		background: <?php echo $color; ?>;
		}
	<?php endif; ?>

		<?php if ($divider_color !== null) : ?>
		#<?php echo $element_id; ?>.blockquote-style-style2 blockquote {
		border-color: <?php echo $divider_color; ?>;
		}
	<?php endif; ?>

		<?php if ($background_color !== null) : ?>

		#<?php echo $element_id; ?>.blockquote-style-style1 {
		background: <?php echo $background_color; ?>;
		}
	<?php endif; ?>

		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		// Generate Blockquote
		ob_start();
		?>
		<div id="<?php echo $element_id; ?>" class="blockquote-shortcode blockquote-style-<?php echo $style; ?>">
			<blockquote>
				<div class="top-divider"></div>
				<div class="blockquote-shortcode-inner">
					<div class="blockquote-left-border"></div>
					<?php echo $content; ?>
				</div>
				<?php if ($source && strlen($source) > 0) { ?>
					<div class="blockquote-shortcode-source"><?php echo $source; ?></div>
				<?php } ?>
				<div class="bottom-divider"></div>
			</blockquote>
		</div>
		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Blockquote',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					"type" => "textfield",
					"heading" => 'Source',
					"param_name" => "source",
					"value" => false,
					"description" => 'The source the quote is attributed to'
				),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Style", 'adap_sc'),
					'param_name' => 'style',
					'sch_default' => 'normal',
					'value' => array('Style #1 (large colored background)' => 'style1',
						'Style #2 (small serif with dividers)' => 'style2',
						'Style #3 (large serif)' => 'style3',
						'Style #4 (standard)' => 'style4'),
					'description' => 'The style of the blockquote.',
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Text Color', 'adap_sc'),
					'param_name' => 'color',
					'value' => null,
					'description' => __('The text color of blockquote.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Divider Color', 'adap_sc'),
					'param_name' => 'divider_color',
					'value' => null,
					'description' => __('The divider color of blockquote.', 'adap_sc'),
					"dependency" => Array('element' => "style", 'value' => array('style2'))
				),
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
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => __("Content", 'adap_sc'),
					"param_name" => "content",
					"value" => __("Content", 'adap_sc'),
					"description" => __("This is an example quote.", 'adap_sc')
				),
			)
		);
	}
}

new AdapBlockquoteSC('blockquote');