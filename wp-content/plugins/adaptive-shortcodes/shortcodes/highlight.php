<?php

class AdapHighlightSC extends AdapAutoVCShortcode
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
			'color' => null,
			'background_color' => null,
		);
		extract(shortcode_atts($defaults, $atts));

		// Generate a Unique ID for the Element
		$element_id = uniqid('highlight_');

		// Configure Custom Colors
		global $custom_css;
		ob_start();
		?>

		#<?php echo $element_id; ?> {
		<?php if($background_color) { ?>
			background: <?php echo $background_color; ?>;
		<?php } ?>
		<?php if($color) { ?>
			color: <?php echo $color; ?>;
		<?php } ?>
		}

		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		// Generate Highlight
		ob_start();
		?>
		<span id="<?php echo $element_id; ?>" class="highlight-shortcode"><?php echo $content; ?></span>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function configureParams()
	{
	}
}

new AdapHighlightSC('highlight');
