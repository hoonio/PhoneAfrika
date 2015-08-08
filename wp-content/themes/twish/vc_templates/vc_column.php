<?php
$output = $el_class = $width = '';
extract(shortcode_atts(array(
	'el_class' => '',
	'width' => '1/1',
	'full_width' => 'false',
	'align' => 'align-none'
), $atts));

$el_class = $this->getExtraClass($el_class);

$width = wpb_translateColumnWidthToSpan($width);
switch ($width) {
	case 'vc_1/12':
		$width = 'span1';
		break;
	case 'vc_2/12':
	case 'vc_1/6':
		$width = 'span2';
		break;
	case 'vc_3/12':
	case 'vc_1/4':
		$width = 'span3';
		break;
	case 'vc_4/12':
	case 'vc_2/6':
	case 'vc_1/3':
		$width = 'span4';
		break;
	case 'vc_5/12':
		$width = 'span5';
		break;
	case 'vc_6/12':
	case 'vc_3/6':
	case 'vc_2/4':
	case 'vc_1/2':
		$width = 'span6';
		break;
	case 'vc_7/12':
		$width = 'span7';
		break;
	case 'vc_8/12':
	case 'vc_4/6':
	case 'vc_2/3':
		$width = 'span8';
		break;
	case 'vc_9/12':
	case 'vc_3/4':
		$width = 'span9';
		break;
	case 'vc_10/12':
	case 'vc_5/6':
		$width = 'span10';
		break;
	case 'vc_11/12':
		$width = 'span11';
		break;
	case 'vc_12/12':
	case 'vc_1/1':
	case 'vc_2/2':
	case 'vc_3/3':
	case 'vc_4/4':
	case 'vc_5/5':
	case 'vc_6/6':
		$width = 'span12';
		break;
}
$el_class .= ' wpb_column column_container';

if ($full_width === 'false') {
	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class, $this->settings['base']);
} else {
	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'make-full-width ' . $el_class, $this->settings['base']);
}
$output .= "\n\t" . '<div class="' . $css_class . ' ' . $align . '">';
$output .= "\n\t\t" . '<div class="wpb_wrapper">';
$output .= "\n\t\t\t" . wpb_js_remove_wpautop($content);
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment('.wpb_wrapper');
$output .= "\n\t" . '</div> ' . $this->endBlockComment($el_class) . "\n";

echo $output;