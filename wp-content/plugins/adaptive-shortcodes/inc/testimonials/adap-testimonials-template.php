<?php
if (!defined('ABSPATH')) exit;

if (!function_exists('adap_get_testimonials')) {
	/**
	 * Wrapper function to get the testimonials from the adapDojo_Testimonials class.
	 * @param  string/array $args  Arguments.
	 * @since  1.0.0
	 * @return array/boolean       Array if true, boolean if false.
	 */
	function adap_get_testimonials($args = '')
	{
		global $adap_testimonials;
		return $adap_testimonials->get_testimonials($args);
	} // End Adap_get_testimonials()
}

/**
 * Enable the usage of do_action( 'adap_testimonials' ) to display testimonials within a theme/plugin.
 *
 * @since  1.0.0
 */
add_action('adap_testimonials', 'adap_testimonials');

if (!function_exists('adap_testimonials')) {
	/**
	 * Display or return HTML-formatted testimonials.
	 * @param  string/array $args  Arguments.
	 * @since  1.0.0
	 * @return string
	 */
	function adap_testimonials($args = '')
	{
		global $post;

		$defaults = array(
			'limit' => 5,
			'orderby' => 'menu_order',
			'order' => 'DESC',
			'id' => 0,
			'display_author' => true,
			'display_avatar' => true,
			'display_url' => true,
			'effect' => 'none', // Options: 'fade', 'none'
			'pagination' => false,
			'echo' => true,
			'size' => 50,
			'title' => '',
			'before' => '',
			'after' => '',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
			'category' => 0,
			'interval' => 7000
		);

		$args = wp_parse_args($args, $defaults);

		// Allow child themes/plugins to filter here.
		$args = apply_filters('adap_testimonials_args', $args);
		$html = '';

		do_action('adap_testimonials_before', $args);

		// The Query.
		$query = adap_get_testimonials($args);

		// The Display.
		if (!is_wp_error($query) && is_array($query) && count($query) > 0) {

			if ($args['effect'] != 'none') {
				$effect = ' ' . $args['effect'];
			}

			$html .= $args['before'] . "\n";
			if ('' != $args['title']) {
				$html .= $args['before_title'] . esc_html($args['title']) . $args['after_title'] . "\n";
			}

			$html .= '[carousel interval="' . $args['interval'] . '"]' . "\n";

			// Begin templating logic.
			$tpl = '<div id="quote-%%ID%%" class="%%CLASS%%"><div class="testimonials-text i">%%TEXT%%<div class="arrow-down"></div></div>%%AVATAR%% %%AUTHOR%%<div class="fix"></div></div>';
			$tpl = apply_filters('adap_testimonials_item_template', $tpl, $args);

			$count = 0;
			foreach ($query as $post) {
				$count++;
				$template = $tpl;

				$css_class = 'quote item';
				if (1 == $count) {
					$css_class .= ' first';
				}
				if (count($query) == $count) {
					$css_class .= ' last';
				}

				setup_postdata($post);

				$author = '';
				$author_text = '';

				// If we need to display the author, get the data.
				if ((get_the_title($post) != '') && true == $args['display_author']) {
					$author .= '<cite class="author"><i class="entypo-user testimonial-shortcode-user-icon"></i> ';

					$author_name = get_the_title($post);

					$author .= '<span class="author-name">';
					$author .= $author_name;
					$author .= '</span>';


					if (isset($post->byline) && '' != $post->byline) {
						$author .= ' <span class="author-title">' . $post->byline . '</span><!--/.excerpt-->' . "\n";
					}

					if (true == $args['display_url'] && '' != $post->url) {
						$author .= ' <span class="url"><a href="' . esc_url($post->url) . '">' . $post->url . '</a></span><!--/.excerpt-->' . "\n";
					}

					$author .= '<i class="entypo-down-open testimonial-shortcode-user-chevron"></i></cite><!--/.author-->' . "\n";

					// Templating engine replacement.
					$template = str_replace('%%AUTHOR%%', $author, $template);
				} else {
					$template = str_replace('%%AUTHOR%%', '', $template);
				}

				// Templating logic replacement.
				$template = str_replace('%%ID%%', get_the_ID(), $template);
				$template = str_replace('%%CLASS%%', esc_attr($css_class), $template);

				if (isset($post->image) && ('' != $post->image) && true == $args['display_avatar']) {
					$template = str_replace('%%AVATAR%%', '<a href="' . esc_url($post->url) . '" class="avatar-link">' . $post->image . '</a>', $template);
				} else {
					$template = str_replace('%%AVATAR%%', '', $template);
				}

				// Remove any remaining %%AVATAR%% template tags.
				$template = str_replace('%%AVATAR%%', '', $template);
				$content = apply_filters('adap_testimonials_content', get_the_content(), $post);
				$template = str_replace('%%TEXT%%', $content, $template);

				// Assign for output.
				$html .= $template;
			}

			wp_reset_postdata();

			$html .= '[/carousel]' . "\n";

			if ($args['pagination'] == true && count($query) > 1 && $args['effect'] != 'none') {
				$html .= '<div class="pagination">' . "\n";
				$html .= '<a href="#" class="btn-prev">' . apply_filters('adap_testimonials_prev_btn', '&larr; ' . __('Previous', 'adap_sc')) . '</a>' . "\n";
				$html .= '<a href="#" class="btn-next">' . apply_filters('adap_testimonials_next_btn', __('Next', 'adap_sc') . ' &rarr;') . '</a>' . "\n";
				$html .= '</div><!--/.pagination-->' . "\n";
			}
			$html .= $args['after'] . "\n";
		}

		// Allow child themes/plugins to filter here.
		$html = apply_filters('adap_testimonials_html', $html, $query, $args);

		if ($args['echo'] != true) {
			return $html;
		}

		// Should only run is "echo" is set to true.
		echo do_shortcode($html);

		do_action('adap_testimonials_after', $args); // Only if "echo" is set to true.
	} // End Adap_testimonials()
}

if (!function_exists('adap_testimonials_shortcode')) {
	/**
	 * The shortcode function.
	 * @since  1.0.0
	 * @param  array $atts    Shortcode attributes.
	 * @param  string $content If the shortcode is a wrapper, this is the content being wrapped.
	 * @return string          Output using the template tag.
	 */
	function adap_testimonials_shortcode($atts, $content = null)
	{
		$args = (array)$atts;

		$defaults = array(
			'limit' => 5,
			'orderby' => 'menu_order',
			'order' => 'DESC',
			'id' => 0,
			'display_author' => true,
			'display_avatar' => true,
			'display_url' => true,
			'effect' => 'fade', // Options: 'fade', 'none'
			'pagination' => false,
			'echo' => true,
			'size' => 50,
			'category' => ''
		);

		$args = shortcode_atts($defaults, $atts);

		// Make sure we return and don't echo.
		$args['echo'] = false;

		// Fix integers.
		if (isset($args['limit'])) $args['limit'] = intval($args['limit']);
		if (isset($args['id'])) $args['id'] = intval($args['id']);
		if (isset($args['size']) && (0 < intval($args['size']))) $args['size'] = intval($args['size']);
//		if (isset($args['category']) && is_numeric($args['category'])) $args['category'] = intval($args['category']);
		// Fix booleans.
		foreach (array('display_author', 'display_url', 'pagination', 'display_avatar') as $k => $v) {
			if (isset($args[$v]) && ('true' == $args[$v])) {
				$args[$v] = true;
			} else {
				$args[$v] = false;
			}
		}

		return adap_testimonials($args);
	} // End Adap_testimonials_shortcode()
}

add_shortcode('adap_testimonials', 'adap_testimonials_shortcode');

if (!function_exists('adap_testimonials_content_default_filters')) {
	/**
	 * Adds default filters to the "Adap_testimonials_content" filter point.
	 * @since  1.3.0
	 * @return void
	 */
	function Adap_testimonials_content_default_filters()
	{
		add_filter('adap_testimonials_content', 'do_shortcode');
	} // End Adap_testimonials_content_default_filters()

	add_action('adap_testimonials_before', 'adap_testimonials_content_default_filters');
}
?>
