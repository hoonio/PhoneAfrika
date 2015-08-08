<?php

class AdapDropcapSC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'class' => null,
			'style' => 'style1', /* Can be style1 or style2 */
			'color' => null,
			'background' => null /* Only valid if style2 */
		);
		extract(shortcode_atts($defaults, $atts));


		// Generate a Unique ID for the Element
		$element_id = uniqid('alert_');

		// Configure Custom Colors
		global $custom_css;
		ob_start();
		?>

		<?php if ($color !== null) : ?>
		#<?php echo $element_id; ?> {
		color: <?php echo $color; ?>;
		}
	<?php endif; ?>

		<?php if ($background !== null) : ?>
		#<?php echo $element_id; ?>.dropcap-style-style2 {
		background: <?php echo $background; ?>;
		}
	<?php endif; ?>


		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		// Generate dropcap
		ob_start();
		?>
		<span id="<?php echo $element_id; ?>"
			  class="dropcap-shortcode <?php echo $class; ?> dropcap-style-<?php echo $style ?>">
        <?php echo do_shortcode($content); ?>
    </span>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapDropcapSC('dropcap');