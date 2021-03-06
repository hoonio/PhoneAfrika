<?php
$output = $el_class = $css_animation = '';

extract(shortcode_atts(array(
	'el_class' => '',
	'css_animation' => ''
), $atts));

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_text_column wpb_content_element ' . $el_class, $this->settings['base']);
$css_class .= $this->getCSSAnimation($css_animation);
$output .= "\n\t" . '<div class="' . $css_class . '">';
$output .= "\n\t\t" . '<div class="wpb_wrapper">';
if (function_exists('adap_sc_remove_wpautop')) {
	$output .= "\n\t\t\t" . adap_sc_remove_wpautop($content);
} else {
	$output .= "\n\t\t\t" . wpb_js_remove_wpautop($content);
}
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment('.wpb_wrapper');
$output .= "\n\t" . '</div> ' . $this->endBlockComment('.wpb_text_column');

echo $output;