<?php

global $adap_list_icon_class;
$adap_list_icon_class = '';

class AdapStyledListSC extends AdapShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'icon_type' => 'entypo',
			'icon' => 'plus',
			'icon_color' => null,
			'content_color' => null
		);
		extract(shortcode_atts($defaults, $atts));

		// Set the icon_class to use for chiu
		global $adap_list_icon_class;
		if ($icon_type == 'entypo') {
			$adap_list_icon_class = 'entypo-' . $icon;
		} else {
			$adap_list_icon_class = 'icon-' . $icon;
		}

		// Generate a Unique ID for the Element
		$element_id = uniqid('list_');

		// Configure Custom Colors
		global $custom_css;
		ob_start();
		?>


		<?php if ($content_color != null) : ?>
		#<?php echo $element_id; ?> li {
		color: <?php echo $content_color; ?>;
		}
	<?php endif; ?>

		<?php if ($icon_color != null) : ?>
		#<?php echo $element_id; ?> i {
		color: <?php echo $icon_color; ?>;
		}
	<?php endif; ?>

		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		// Generate List
		ob_start();
		?>
		<ul id="<?php echo $element_id; ?>" class="list-shortcode">
			<?php echo do_shortcode($content); ?>
		</ul>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function register_vc()
	{
	}
}

new AdapStyledListSC('list');

class AdapStyledListItemSC extends AdapShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'icon_type' => null,
			'icon' => null,
			'icon_color' => null

		);
		extract(shortcode_atts($defaults, $atts));


		global $adap_list_icon_class;
		global $adap_list_icon_color;

		// Override the global values if icon_type and icon are set on the list item
		$icon_class = $adap_list_icon_class;
		if ($icon_type != null && $icon != null) {
			if ($icon_type == 'entypo') {
				$icon_class = 'entypo-' . $icon;
			} else {
				$icon_class = 'icon-' . $icon;
			}
		}

		// Generate a Unique ID for the Element
		$element_id = uniqid('listitem_');

		// Configure Custom Colors
		global $custom_css;
		ob_start();
		?>


		#<?php echo $element_id; ?> i {
		color: <?php echo $icon_color; ?>;
		}


		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		ob_start();
		?>
	<li id="<?php echo $element_id; ?>" class="list-item-shortcode"><i class="<?php echo $icon_class; ?> "></i><?php echo do_shortcode($content); ?></li><?php
		$ret_val = ob_get_contents();
		ob_end_clean();

		return $ret_val;
	}

	function register_vc()
	{
	}
}

new AdapStyledListItemSC('list_item');