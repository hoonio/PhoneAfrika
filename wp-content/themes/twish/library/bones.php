<?php
/* Welcome to Bones :)
This is the core Bones file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

ob_start();

/*********************
LAUNCH BONES
Let's fire off all the functions
and tools. I put it up here so it's
right up top and clean.
 *********************/

// we're firing all out initial functions at the start
add_action('after_setup_theme', 'bones_ahoy', 16);

function bones_ahoy()
{

	// launching operation cleanup
	add_action('init', 'bones_head_cleanup');
	// remove WP version from RSS
	add_filter('the_generator', 'bones_rss_version');
	// remove pesky injected css for recent comments widget
	add_filter('wp_head', 'bones_remove_wp_widget_recent_comments_style', 1);
	// clean up comment styles in the head
	add_action('wp_head', 'bones_remove_recent_comments_style', 1);
	// clean up gallery output in wp
	add_filter('gallery_style', 'bones_gallery_style');

	// enqueue base scripts and styles
	add_action('wp_enqueue_scripts', 'bones_scripts_and_styles', 900);
	add_action('wp_enqueue_scripts', 'adap_theme_css', 902);

	// ie conditional wrapper

	// launching this stuff after theme setup
	bones_theme_support();

	// adding sidebars to Wordpress (these are created in functions.php)
	add_action('widgets_init', 'bones_register_sidebars');

	// cleaning up random code around images
	add_filter('the_content', 'bones_filter_ptags_on_images');
	// cleaning up excerpt
	add_filter('excerpt_more', 'bones_excerpt_more');

	// add "active" class to current menu item
	add_filter('nav_menu_css_class', 'active_nav_class', 10, 2);


} /* end bones ahoy */

/**
 * If there's a manual excerpt, shove a button link to the
 * post afterwards
 * @param $output
 * @return string
 */
function peach_excerpt_read_more_link($output)
{
	global $post;
	if (has_excerpt()) {
		return $output . bones_excerpt_more('');
	} else {
		return $output;
	}
}

add_filter('get_the_excerpt', 'peach_excerpt_read_more_link');

/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
 *********************/

function bones_head_cleanup()
{
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action('wp_head', 'rsd_link');
	// windows live writer
	remove_action('wp_head', 'wlwmanifest_link');
	// index link
	remove_action('wp_head', 'index_rel_link');
	// previous link
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	// start link
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	// links for adjacent posts
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	// WP version
	remove_action('wp_head', 'wp_generator');
	// remove WP version from css
	add_filter('style_loader_src', 'bones_remove_wp_ver_css_js', 9999);
	// remove Wp version from scripts
	add_filter('script_loader_src', 'bones_remove_wp_ver_css_js', 9999);

} /* end bones head cleanup */

// remove WP version from RSS
function bones_rss_version()
{
	return '';
}

// remove WP version from scripts
function bones_remove_wp_ver_css_js($src)
{
	if (strpos($src, 'ver='))
		$src = remove_query_arg('ver', $src);
	return $src;
}

// remove injected CSS for recent comments widget
function bones_remove_wp_widget_recent_comments_style()
{
	if (has_filter('wp_head', 'wp_widget_recent_comments_style')) {
		remove_filter('wp_head', 'wp_widget_recent_comments_style');
	}
}

// remove injected CSS from recent comments widget
function bones_remove_recent_comments_style()
{
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
	}
}

// remove injected CSS from gallery
function bones_gallery_style($css)
{
	return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


/*********************
SCRIPTS & ENQUEUEING
 *********************/

// loading modernizr and jquery, and reply script
function bones_scripts_and_styles()
{
	global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
	if (!is_admin()) {

		//Twitter Bootstrap registration
		wp_register_style('bootstrap', get_template_directory_uri() . '/library/css/bootstrap.css',
			array(), '2.3.2');
		wp_register_style('bootstrap-responsive', get_template_directory_uri() . '/library/css/bootstrap-responsive.css',
			array('bootstrap'), '2.3.2');
		wp_register_style('bootstrap-docs', get_template_directory_uri() . '/library/css/docs.css',
			array(), '');
		wp_register_script('bootstrap-js', get_template_directory_uri() . '/library/js/bootstrap.min.js', array('jquery'), '', true);

		wp_register_script('bootstrap-hover-dropdown-js', get_template_directory_uri() . '/library/js/bootstrap-hover-dropdown.js', array('bootstrap-js'), '', true);

		// register main stylesheet
		wp_register_style('bones-stylesheet', get_template_directory_uri() . '/library/css/style.css', array(), '', 'all');

		// comment reply script for threaded comments
		if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
			wp_enqueue_script('comment-reply');
		}

		// modernizr (without media query polyfill)
		wp_register_script('bones-modernizr', get_template_directory_uri() . '/library/js/libs/modernizr.custom.min.js', array(), '2.5.3', false);
		//adding scripts file in the footer

		wp_register_script('bones-js', get_template_directory_uri() . '/library/js/scripts.js', array('jquery'), '', true);

		wp_register_style('fonts-css', get_template_directory_uri() . '/library/css/fonts.css', array('bootstrap', 'bootstrap-responsive', 'bootstrap-docs', 'peach-css'));
		wp_register_style('google-raleway', '//fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,700,600,800,900');

		wp_register_style('peach-css', get_stylesheet_directory_uri() . '/style.css',
			array('bootstrap', 'bootstrap-responsive', 'bootstrap-docs'));

		//fallback Raleway import
		wp_enqueue_style('google-raleway');
		// enqueue styles and scripts
		wp_enqueue_script('bones-modernizr');
		wp_enqueue_style('bones-stylesheet');
		wp_enqueue_style('bones-ie-only');

		//Bootstrap
		wp_enqueue_style('bootstrap');
		wp_enqueue_style('bootstrap-responsive');
		wp_enqueue_style('bootstrap-docs');

		wp_enqueue_script('bootstrap-js');
		wp_enqueue_script('bootstrap-hover-dropdown-js');

		wp_enqueue_script('fitvids', get_template_directory_uri() . '/library/js/libs/jquery.fitvids.js', array('jquery'), '', true);

		wp_enqueue_script('jquery-placeholder', get_template_directory_uri() . '/library/js/libs/jquery.placeholder.min.js', array('jquery'), '', true);
		wp_enqueue_script('throttled-resize',
			get_template_directory_uri() . '/library/js/libs/jquery.throttledresize.js', array('jquery'), '', true);
		wp_enqueue_script('debounced-resize',
			get_template_directory_uri() . '/library/js/libs/jquery.debouncedresize.js', array('jquery'), '', true);


		$wp_styles->add_data('bones-ie-only', 'conditional', 'lt IE 9'); // add conditional wrapper around ie stylesheet

		/*
		I recommend using a plugin to call jQuery
		using the google cdn. That way it stays cached
		and your site will load faster.
		*/
		wp_enqueue_script('jquery');
		wp_enqueue_script('bones-js');

	}
}

function adap_theme_css()
{
	wp_enqueue_style('peach-css');
	wp_enqueue_style('fonts-css');
}

/*********************
THEME SUPPORT
 *********************/

// Adding WP 3+ Functions & Theme Support
function bones_theme_support()
{

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support('post-thumbnails');

	// default thumb size
	set_post_thumbnail_size(125, 125, true);

	// wp custom background (thx to @bransonwerner for update)
//    add_theme_support('custom-background',
//        array(
//            'default-image' => '', // background image default
//            'default-color' => '', // background color default (dont add the #)
//            'wp-head-callback' => '_custom_background_cb',
//            'admin-head-callback' => '',
//            'admin-preview-callback' => ''
//        )
//    );

	// rss thingy
	add_theme_support('automatic-feed-links');

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

	// adding post format support
	add_theme_support('post-formats',
		array(
//            'aside',
			// title less blurb
			'gallery', // gallery of images
//            'link',
			// quick link to other site
			'image', // an image
			'quote', // a quick quote
//            'status',
			// a Facebook like status update
			'video', // video
//            'audio', // audio
//            'chat' // chat transcript
		)
	);

	// wp menus
	add_theme_support('menus');

	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => __('The Main Menu', 'adap'), // main nav in header
			'footer-links' => __('Footer Links', 'adap') // secondary nav in footer
		)
	);
} /* end bones theme support */


/*********************
MENUS & NAVIGATION
 *********************/

// the main menu
function bones_main_nav()
{
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => false, // remove nav container
		'container_class' => 'menu clearfix', // class of container (should you choose to use it)
		'menu' => __('The Main Menu', 'adap'), // nav name
		'menu_class' => 'nav', // adding custom nav class
		'theme_location' => 'main-nav', // where it's located in the theme
		'before' => '', // before the menu
		'after' => '', // after the menu
		'link_before' => '', // before each link
		'link_after' => '', // after each link
		'depth' => 0, // limit the depth of the nav
		'fallback_cb' => 'bones_main_nav_fallback', // fallback function
		'walker' => new bones_main_nav_walker // custom walker (see below)
	));
} /* end bones main nav */

// add an "active" class to the current menu item
function active_nav_class($classes, $item)
{
	if ($item->current) {
		$classes[] = "active";
	}
	return $classes;
}

// custom walker for main nav
class bones_main_nav_walker extends Walker_Nav_Menu
{

	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl(&$output, $depth = 0, $args = array())
	{
		$indent = str_repeat("\t", $depth);
		// Change to also add "dropdown-menu" class
		$output .= "\n$indent<ul class=\"sub-menu dropdown-menu\">\n";
	}

	/**
	 * @see Walker::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function end_lvl(&$output, $depth = 0, $args = array())
	{
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
	{

		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$class_names = $value = '';

		$classes = empty($item->classes) ? array() : (array)$item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$classes[] = 'menu-depth-' . $depth;

		// Add the dropdown class for parent li elements so the Bootstrap dropdown works
		if (!empty($item->has_children)) {
			if ($depth > 0) {
				$classes[] = 'dropdown-submenu';
			} else {
				$classes[] = 'dropdown';
			}
		}

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . '>';

		$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
//        $attributes .= ! empty( $item->has_children)? ' data-toggle="dropdown"' : "";
		$attributes .= !empty($item->has_children) && $depth == 0 ? ' data-hover="dropdown"' : ""; // Only set data-hover on the root-level parent items
		$attributes .= !empty($item->has_children) ? ' class="dropdown-toggle" aria-haspopup="true"' : "";

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		if (!empty($item->has_children) && $depth == 0) {
			$item_output .= '<b class="caret"></b>';
		}
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	/**
	 * @see Walker::end_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Page data object. Not used.
	 * @param int $depth Depth of page. Not Used.
	 */
	function end_el(&$output, $item, $depth = 0, $args = array())
	{
		$output .= "</li>\n";
	}

	// Add a has_children property that's set to 1 for parent items
	function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
	{
		// check, whether there are children for the given ID and append it to the element with a (new) ID
		$element->has_children = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);

		return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}


}


// the footer menu (should you choose to use one)
function bones_footer_links()
{
	// display the wp3 menu if available
	wp_nav_menu(array(
		'container' => '', // remove nav container
		'container_class' => 'footer-links clearfix', // class of container (should you choose to use it)
		'menu' => __('Footer Links', 'adap'), // nav name
		'menu_class' => 'nav footer-nav clearfix', // adding custom nav class
		'theme_location' => 'footer-links', // where it's located in the theme
		'before' => '', // before the menu
		'after' => '', // after the menu
		'link_before' => '', // before each link
		'link_after' => '', // after each link
		'depth' => 1, // limit the depth of the nav
		'fallback_cb' => 'bones_footer_links_fallback' // fallback function
	));
} /* end bones footer link */

// this is the fallback for header menu
function bones_main_nav_fallback()
{
	echo '<ul id="menu-header" class="nav fallback-nav">';
	echo get_main_nav_fallback_home_li();
	wp_list_pages(array(
		'walker' => new main_nav_fallback_walker,
		'title_li' => ''
	));
	echo '</ul>';
}

function get_main_nav_fallback_home_li()
{
	ob_start();
	?>
	<li>
		<a href="<?php echo home_url(); ?>"><?php echo __('Home', 'adap'); ?></a>
	</li>
	<?php
	$ret_val = ob_get_contents();
	ob_end_clean();
	return $ret_val;
}

/**
 * Extend the default page walker class to append class names for pages that
 * are parents.
 * @uses Walker_Page
 */
class main_nav_fallback_walker extends Walker_Page
{

	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl(&$output, $depth = 0, $args = array())
	{
		$indent = str_repeat("\t", $depth);
		// Change to also add "dropdown-menu" class
		$output .= "\n$indent<ul class=\"sub-menu dropdown-menu\">\n";
	}

	/**
	 * @see Walker::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function end_lvl(&$output, $depth = 0, $args = array())
	{
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	/**
	 * This is effectively a wrapper for the default method, dynamically adding
	 * and removing the class filter when the current item has children.
	 * @param $output
	 * @param $object
	 * @param $depth
	 * @param $args
	 * @param int $current_object_id
	 */
	function start_el(&$output, $object, $depth = 0, $args = Array(), $current_object_id = 0)
	{
		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$class_names = $value = '';

		$classes = array();
		$classes[] = 'menu-item-' . $object->ID;

		// Add the dropdown class for parent li elements so the Bootstrap dropdown works
		if (!empty($args['has_children'])) {
			if ($depth > 0) {
				$classes[] = 'dropdown-submenu';
			} else {
				$classes[] = 'dropdown';
			}
		}

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $object, $args));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $object->ID, $object, $args);
		$id = $id ? ' id="' . esc_attr($id) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . '>';

		$attributes = ' href="' . get_permalink($object->ID) . '"';
		$attributes .= !empty($args['has_children']) && $depth == 0 ? ' data-hover="dropdown"' : ""; // Only set data-hover on the root-level parent items
		$attributes .= !empty($args['has_children']) ? ' class="dropdown-toggle"' : "";

		$item_output = '<a' . $attributes . '>';
		$item_output .= apply_filters('the_title', $object->post_title, $object->ID);
		if (!empty($args['has_children']) && $depth == 0) {
			$item_output .= '<b class="caret"></b>';
		}
		$item_output .= '</a>';

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $object, $depth, $args);
	}

	/**
	 * @see Walker::end_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Page data object. Not used.
	 * @param int $depth Depth of page. Not Used.
	 */
	function end_el(&$output, $item, $depth = 0, $args = array())
	{
		$output .= "</li>\n";
	}
}


// Do some filtering to wp_page_menu to add attributes needed for fallback menu
function add_bootstrap_ids_and_classes($ulclass)
{
	$ret_string = preg_replace('/<ul>/', '<ul id="menu-header" class="nav">', $ulclass, 1);
	$ret_string = preg_replace("/<ul class='children'>/", '<ul class="sub-menu dropdown-menu">', $ret_string, -1);
	return $ret_string;
}

add_filter('wp_page_menu', 'add_bootstrap_ids_and_classes');


// this is the fallback for footer menu
function bones_footer_links_fallback()
{
	/* you can put a default here if you like */
}

/*********************
RELATED POSTS FUNCTION
 *********************/

// Related Posts Function (call using bones_related_posts(); )
function bones_related_posts()
{
	echo '<ul id="bones-related-posts">';
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {
		foreach ($tags as $tag) {
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts($args);
		if ($related_posts) {
			foreach ($related_posts as $post) : setup_postdata($post); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>"
											title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach;
		} else {
			?>
			<?php echo '<li class="no_related_post">' . __('No Related Posts Yet!', 'adap') . '</li>'; ?>
		<?php
		}
	}
	wp_reset_query();
	echo '</ul>';
} /* end bones related posts function */

/*********************
PAGE NAVI
 *********************/

// Numeric Page Navi (built into the theme by default)
function bones_page_navi($before = '', $after = '', $prev_text = '&laquo;', $next_text = '&raquo;')
{
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ($numposts <= $posts_per_page) {
		return;
	}
	if (empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show - 1;
	$half_page_start = floor($pages_to_show_minus_1 / 2);
	$half_page_end = ceil($pages_to_show_minus_1 / 2);
	$start_page = $paged - $half_page_start;
	if ($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if (($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if ($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if ($start_page <= 0) {
		$start_page = 1;
	}
	echo $before . '<div class="pagination"><ul>' . "";
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$first_page_text = __("First", 'adap');
		echo '<li class="bpn-first-page-link"><a href="' . get_pagenum_link() . '" title="' . $first_page_text . '">' . $first_page_text . '</a></li>';
	}

	$previous_posts_link = get_previous_posts_link($prev_text);
	// If there is no previous posts link, then the li should have the class "disabled"
	$previous_posts_li = $previous_posts_link == '' ? '<li class="bpn-prev-link disabled">' : '<li class="bpn-prev-link">';
	// If there is no previous posts link, then it should be a normal link with a '#' URL
	$previous_posts_link = $previous_posts_link == '' ? '<a href="#">' . $prev_text . '</a>' : $previous_posts_link;
	echo $previous_posts_li;
	echo $previous_posts_link;
	// Close the previous_posts_li
	echo '</li>';

	for ($i = $start_page; $i <= $end_page; $i++) {
		if ($i == $paged) {
			echo '<li class="bpn-current disabled"><a class="numbered-pagination-link" href="#">' . $i . '</a></li>';
		} else {
			echo '<li><a class="numbered-pagination-link" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
		}
	}

	$next_posts_link = get_next_posts_link($next_text);
	// If there is no next posts link, then the li should have the class "disabled"
	$next_posts_li = $next_posts_link == '' ? '<li class="bpn-next-link disabled">' : '<li class="bpn-next-link">';
	// If there is no next posts link, then it should be a normal link with a '#' URL
	$next_posts_link = $next_posts_link == '' ? '<a href="#">' . $next_text . '</a>' : $next_posts_link;
	echo $next_posts_li;
	echo $next_posts_link;
	// Close the next_posts_li
	echo '</li>';

	if ($end_page < $max_page) {
		$last_page_text = __("Last", 'adap');
		echo '<li class="bpn-last-page-link"><a href="' . get_pagenum_link($max_page) . '" title="' . $last_page_text . '">' . $last_page_text . '</a></li>';
	}
	echo '</ul></div>' . $after . "";
} /* end page navi */

/*********************
RANDOM CLEANUP ITEMS
 *********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function bones_filter_ptags_on_images($content)
{
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function bones_excerpt_more($more)
{
	global $post;
	// edit here if you like
	return '...  <br><a class="excerpt-read-more btn" href="' . get_permalink($post->ID) . '" title="' . __('Read', 'adap') . ' ' . get_the_title($post->ID) . '">' . __('Read More', 'adap') . '</a>';
}

/*
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 */
function bones_get_the_author_posts_link($class = '')
{
	global $authordata;
	if (!is_object($authordata))
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author" class="%4$s">%3$s</a>',
		get_author_posts_url($authordata->ID, $authordata->user_nicename),
		esc_attr(sprintf(__('Posts by %s', 'adap'), get_the_author())), // No further l10n needed, core will take care of this one
		get_the_author(),
		$class
	);
	return $link;
}

?>