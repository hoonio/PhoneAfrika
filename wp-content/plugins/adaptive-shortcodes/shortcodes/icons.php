<?php

class AdapFontAwesomeSC extends AdapShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'icon' => null,
			'size' => 'small',
			'color' => null,
			'hover_color' => null,
			'show_circle' => 'true',
			'background' => null,
			'hover_background' => null,
			'border' => null,
			'hover_border' => null,
			'url' => null,
			'line_height' => null,
			'font_size' => null,
			'margin_right' => null
		);
		extract(shortcode_atts($defaults, $atts));

		// Create class for icon
		$class = 'icon-' . $icon;

		// Generate a Unique ID for the Element
		$element_id = uniqid('fontawesome_');

		// Configure Custom Color and Size
		global $custom_css;
		if ($size || $color) {
			ob_start();
			?>
			#<?php echo $element_id; ?> {
			background-color: <?php echo $background; ?>;
			border-color: <?php echo $border; ?>;
			<?php if ($line_height) { ?> line-height: <?php echo $line_height; ?>; <?php } ?>
			<?php if ($margin_right) { ?> margin-right: <?php echo $margin_right; ?>; <?php } ?>
			}
			#<?php echo $element_id; ?>:hover {
			<?php if ($hover_background) { ?> background-color: <?php echo $hover_background; ?>; <?php } ?>
			<?php if ($hover_border) { ?> border-color: <?php echo $hover_border; ?>; <?php } ?>
			}
			#<?php echo $element_id; ?> > i {
			color: <?php echo $color; ?>;
			<?php if ($line_height) { ?> line-height: <?php echo $line_height; ?>; <?php } ?>
			<?php if ($font_size) { ?> font-size: <?php echo $font_size; ?>; <?php } ?>
			}
			#<?php echo $element_id; ?>:hover > i {
			color: <?php echo $color; ?>;
			<?php if ($hover_color) { ?> color: <?php echo $hover_color; ?>; <?php } ?>
			}
			<?php
			$custom_css .= ob_get_contents();
			ob_end_clean();
		}

		$link_class = $show_circle == 'true' ? 'icon-circle-background' : 'no-circle-background';

		$link_url = $url ? $url : "javascript:void(0);";
		if ($url == null) {
			$link_class .= ' no-link';
		}

		// Generate Icon
		ob_start();
		?>
		<a href="<?php echo $link_url; ?>" id="<?php echo $element_id; ?>"
		   class="icon-shortcode fontawesome-icon-shortcode size-<?php echo $size; ?> <?php echo $link_class; ?>">
			<i class="<?php echo $class; ?>"></i>
		</a>
		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function register_vc()
	{
	}
}

new AdapFontAwesomeSC('fontawesome');

class AdapEntypoSC extends AdapShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'icon' => null,
			'size' => 'small',
			'color' => null,
			'hover_color' => null,
			'show_circle' => 'true',
			'background' => null,
			'hover_background' => null,
			'border' => null,
			'hover_border' => null,
			'url' => null,
			'line_height' => null,
			'font_size' => null,
			'margin_right' => null
		);
		extract(shortcode_atts($defaults, $atts));

		// Create class for icon
		$class = 'entypo-' . $icon;

		// Generate a Unique ID for the Element
		$element_id = uniqid('entypo');

		// Configure Custom Color and Size
		global $custom_css;
		if ($size || $color) {
			ob_start();
			?>
			#<?php echo $element_id; ?> {
			background-color: <?php echo $background; ?>;
			border-color: <?php echo $border; ?>;
			<?php if ($line_height) { ?> line-height: <?php echo $line_height; ?>; <?php } ?>
			<?php if ($margin_right) { ?> margin-right: <?php echo $margin_right; ?>; <?php } ?>
			}
			#<?php echo $element_id; ?>:hover {
			<?php if ($hover_background) { ?> background-color: <?php echo $hover_background; ?>; <?php } ?>
			<?php if ($hover_border) { ?> border-color: <?php echo $hover_border; ?>; <?php } ?>
			}
			#<?php echo $element_id; ?> > i {
			color: <?php echo $color; ?>;
			<?php if ($line_height) { ?> line-height: <?php echo $line_height; ?>; <?php } ?>
			<?php if ($font_size) { ?> font-size: <?php echo $font_size; ?>; <?php } ?>
			}
			#<?php echo $element_id; ?>:hover > i {
			color: <?php echo $color; ?>;
			<?php if ($hover_color) { ?> color: <?php echo $hover_color; ?>; <?php } ?>
			}
			<?php
			$custom_css .= ob_get_contents();
			ob_end_clean();
		}

		$link_class = $show_circle == 'true' ? 'icon-circle-background' : 'no-circle-background';

		$link_url = $url ? $url : "javascript:void(0);";
		if ($url == null) {
			$link_class .= ' no-link';
		}

		// Generate Icon
		ob_start();
		?><a href="<?php echo $link_url; ?>" id="<?php echo $element_id; ?>" class="icon-shortcode entypo-icon-shortcode size-<?php echo $size; ?> <?php echo $link_class; ?>"><i class="<?php echo $class; ?>"></i></a><?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return adap_sc_remove_wpautop($ret_val);
	}

	function register_vc()
	{
	}
}

new AdapEntypoSC('entypo');