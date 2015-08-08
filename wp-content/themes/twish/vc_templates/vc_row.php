<?php
$output = $el_class = '';
extract(shortcode_atts(array(
	'el_class' => '',
), $atts));

$style_attr = '';
if (!isset($atts['full_width']) || $atts['full_width'] == 'false') {
	$color = isset($atts['background_color']) ? 'background-color: ' . $atts['background_color'] . ';' : '';

	$attach_id = isset($atts['background_image']) ? $atts['background_image'] : false;

	$image = '';
	if ($attach_id) {
		$url = wp_get_attachment_image_src($attach_id, 'full');
		if (!empty($url[0]))
			$image = isset($atts['background_image']) ? 'background-image: url(\'' . $url[0] . '\');' : '';
	}

	$attachment = isset($atts['background_attachment']) ? 'background-attachment: ' . $atts['background_attachment'] . ';' : '';
	$position = isset($atts['background_position']) ? 'background-position: ' . $atts['background_position'] . ';' : '';
	$repeat = isset($atts['background_repeat']) ? 'background-repeat: ' . $atts['background_repeat'] . ';' : '';

	$position = str_replace('_', ' ', $position);

	$size = isset($atts['background_cover']) && $atts['background_cover'] != 'false' ? 'background-size: cover;' : '';

	$style_attr = 'style="' . $image . $color . $attachment . $position . $repeat . $size . '"';
}

wp_enqueue_style('js_composer_front');
wp_enqueue_script('wpb_composer_front_js');
wp_enqueue_style('js_composer_custom_css');


if (isset($atts['full_width']) && $atts['full_width'] == 'true') {

$add_full_classes = $el_class . ' ';
if (isset($atts['background_transparent']) && $atts['background_transparent'] == 'true') {
	$add_full_classes .= 'adap-transparent-row';
}

$color = isset($atts['background_color']) ? 'background-color: ' . $atts['background_color'] . ';' : '';

$attach_id = isset($atts['background_image']) ? $atts['background_image'] : false;

$image = '';
if ($attach_id) {
	$url = wp_get_attachment_image_src($attach_id, 'full');
	if (!empty($url[0]))
		$image = isset($atts['background_image']) ? 'background-image: url(\'' . $url[0] . '\');' : '';
}

$attachment = isset($atts['background_attachment']) ? 'background-attachment: ' . $atts['background_attachment'] . ';' : '';
$position = isset($atts['background_position']) ? 'background-position: ' . $atts['background_position'] . ';' : '';
$repeat = isset($atts['background_repeat']) ? 'background-repeat: ' . $atts['background_repeat'] . ';' : '';

$position = str_replace('_', ' ', $position);

$size = isset($atts['background_cover']) && $atts['background_cover'] != 'false' ? 'background-size: cover;' : '';

ob_start();?></section> <!-- Close the previous section -->
</article> <!-- Close the previous article -->
</div> <!-- Close the previous div.span12 -->
</div> <!-- Close the previous div.row -->
</div> <!-- Close the previous div.container -->

<!-- Add our full-width section -->
<div class="full-width-section <?php echo $add_full_classes; ?>"
	 style="<?php echo $image;
	 echo $color;
	 echo $attachment;
	 echo $position;
	 echo $repeat;
	 echo $size ?>"><!-- This is the element that has the bg -->
	<?php

	if (isset($atts['content_full_width']) && $atts['content_full_width'] != 'false') {
		echo '<div class="full-width-container">';
	} else {
		echo '<div class="container">';
	}

	$ret_val = ob_get_contents();
	ob_end_clean();
	echo wpb_js_remove_wpautop(trim($ret_val));
	}


	$el_class = $this->getExtraClass($el_class);

	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row ' . get_row_css_class() . $el_class, $this->settings['base']);

	$output .= '<div class="' . $css_class . '" ' . $style_attr . '>';
	$output .= wpb_js_remove_wpautop($content);
	$output .= '</div>' . $this->endBlockComment('row');

	echo $output;

	if (isset($atts['full_width']) && $atts['full_width'] == 'true') {

	?>

</div>
<?php
ob_start();
?>
</div>

<!-- Resume normal layout -->
<div class="container">
	<div class="row">
		<div class="span12">
			<article <?php post_class('clearfix'); // need to add the same classes as the original article ?>>
				<section class="entry-content clearfix">
					<div class="hide"></div>
<?php

$ret_val = ob_get_contents();
ob_end_clean();
echo wpb_js_remove_wpautop(trim($ret_val));
}