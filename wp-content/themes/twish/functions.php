<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

require_once('plugins/plugin-registration.php');

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bones.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once('library/bones.php'); // if you remove this, bones will break
/*
2. library/custom-post-type.php
	- an example custom post type
	- example custom taxonomy (like categories)
	- example custom taxonomy (like tags)
*/
require_once('library/custom-post-type.php'); // you can disable this if you like
require_once('library/post-formats.php'); // you can disable this if you like

add_action('admin_menu', 'twish_doc_page');

function twish_doc_page()
{
	add_theme_page('Twish Doc', 'Twish Doc', 'read', 'twish-doc', 'twish_doc_page_render');
}

function twish_doc_page_render()
{
	?>
	<h1><a target="_blank" href="http://wpadaptive.com/doc/twish/_gh_pages/">Twish Live Online Documentation</a></h1>
<?php
}

class TwishAdminMenu
{

	function TwishAdminMenu()
	{
		add_action('admin_bar_menu', array($this, "admin_links"), 200);
	}

	/**
	 * Add's new global menu, if $href is false menu is added but registred as submenuable
	 *
	 * $name String
	 * $id String
	 * $href Bool/String
	 *
	 * @return void
	 * @author Janez Troha
	 * @author Aaron Ware
	 **/

	function add_root_menu($name, $id, $href = FALSE)
	{
		global $wp_admin_bar;
		if (!is_super_admin() || !is_admin_bar_showing())
			return;

		$wp_admin_bar->add_menu(array(
			'id' => $id,
			'meta' => array(),
			'title' => $name,
			'href' => $href));
	}

	/**
	 * Add's new submenu where additinal $meta specifies class, id, target or onclick parameters
	 *
	 * $name String
	 * $link String
	 * $root_menu String
	 * $id String
	 * $meta Array
	 *
	 * @return void
	 * @author Janez Troha
	 **/
	function add_sub_menu($name, $link, $root_menu, $id, $meta = FALSE)
	{
		global $wp_admin_bar;
		if (!is_super_admin() || !is_admin_bar_showing())
			return;

		$wp_admin_bar->add_menu(array(
			'parent' => $root_menu,
			'id' => $id,
			'title' => $name,
			'href' => $link,
			'meta' => $meta
		));
	}

	function admin_links()
	{
		$this->add_root_menu("Twish", "twish-admin");
		$this->add_sub_menu("Options", admin_url('admin.php?page=options-framework'), "twish-admin", "twish-options");
		$this->add_sub_menu("Documentation", "http://wpadaptive.com/doc/twish/_gh_pages/", "twish-admin", "twish-doc");
		$this->add_sub_menu("Install Plugins", admin_url('admin.php?page=install-required-plugins'), "twish-admin", "twish-plugins");

	}

}

add_action("init", "FacebookMenuInit");
function FacebookMenuInit()
{
	global $FacebookMenu;
	$FacebookMenu = new TwishAdminMenu();
}

/*
3. library/admin.php
	- removing some default WordPress dashboard widgets
	- an example custom dashboard widget
	- adding custom login css
	- changing text in footer of admin
*/
// require_once('library/admin.php'); // this comes turned off by default
/*
4. library/translation/translation.php
	- adding support for other languages
*/
// require_once('library/translation/translation.php'); // this comes turned off by default

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size('bones-thumb-600', 600, 150, true);
add_image_size('bones-thumb-300', 300, 100, true);

//portfolio image sizes.
add_image_size('portfolio-one-column', 1170, 854, true);
add_image_size('portfolio-two-column', 570, 416, true);
add_image_size('portfolio-three-column', 370, 270, true);
add_image_size('portfolio-four-column', 270, 197, true);

add_image_size('portfolio-compact', 770, 513, true);

//blog sizes
add_image_size('blog-large', 770, 270, true);
add_image_size('blog-full-width', 1170, 270, true);
add_image_size('blog-medium', 740, 540, true);
add_image_size('blog-grid', 370, 270, true);


/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* SET CONTENT_WIDTH ******************/
if (!isset($content_width)) {
	$content_width = 1170;
}


/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars()
{
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __('Sidebar 1', 'adap'),
		'description' => __('The first (primary) sidebar.', 'adap'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'footer1',
		'name' => __('Footer 1', 'adap'),
		'description' => __('Footer Column', 'adap'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'footer2',
		'name' => __('Footer 2', 'adap'),
		'description' => __('Footer Column', 'adap'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'footer3',
		'name' => __('Footer 3', 'adap'),
		'description' => __('Footer Column', 'adap'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	register_sidebar(array(
		'id' => 'footer4',
		'name' => __('Footer 4', 'adap'),
		'description' => __('Footer Column', 'adap'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));


	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __('Sidebar 2', 'adap'),
		'description' => __('The second (secondary) sidebar.', 'adap'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment; ?>
	<div <?php comment_class('media'); ?>>

	<a class="pull-left avatar-link">
		<?php
		/*
			this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
			echo get_avatar($comment,$size='32',$default='<path_to_url>' );
		*/
		?>
		<?php echo get_avatar($comment, 70); ?>

		<?php // The "s" or size parameter sent to gravatar should be twice the image size (to accommodate retina displays) ?>
	</a>

	<div class="media-body">
	<header class="comment-author">
		<?php printf(__('<cite class="fn comment-citation">%s</cite>', 'adap'), get_comment_author_link()) ?>
		<time datetime="<?php echo comment_time('Y-m-d'); ?>"><a
				href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>"><?php comment_time(__('F jS, Y', 'adap')); ?> </a>
		</time>
		<?php edit_comment_link(__('Edit', 'adap'), ' &mdash; ', '') ?> &mdash;
		<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</header>
	<?php if ($comment->comment_approved == '0') : ?>
	<div class="alert alert-info">
		<p><?php _e('Your comment is awaiting moderation.', 'adap') ?></p>
	</div>
<?php endif; ?>
	<div class="comment_content clearfix">
		<?php comment_text() ?>
	</div>


	<!-- </div></div> is added by the bones_comments_end callback below -->
<?php
} // don't remove this bracket!


function bones_comments_end($comment, $args, $depth)
{
	?>
	</div>
	</div>
<?php
}

/*
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 */

if (!function_exists('of_get_option')) {
	function of_get_option($name, $default = false)
	{

		$optionsframework_settings = get_option('optionsframework');

		// Gets the unique option id
		$option_name = $optionsframework_settings['id'];

		if (get_option($option_name)) {
			$options = get_option($option_name);
		}

		if (isset($options[$name])) {
			return $options[$name];
		} else {
			return $default;
		}
	}
}

/*
 * Enqueue custom styles for the theme options
 */
add_action('admin_enqueue_scripts', 'optionsframework_custom_css');

function optionsframework_custom_css($hook)
{

	// Only load the CSS on the theme options page
	if (strpos($hook, 'options-framework') === false)
		return;

	wp_register_style('optionsframework_custom_css', get_template_directory_uri() . '/inc/options-framework/admin.css');
	wp_enqueue_style('optionsframework_custom_css');
}


/*
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 */

add_action('admin_enqueue_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts($hook)
{
	// Only load the JS on the theme options page
	if (strpos($hook, 'options-framework') === false)
		return;

	wp_register_script('jquery-waypoints', get_template_directory_uri() . '/library/js/waypoints.min.js', array('jquery'));

	wp_register_script('options-panel-custom', get_template_directory_uri() . '/inc/options-framework/custom.js', array('jquery-waypoints', 'jquery', 'underscore'), true);

	wp_enqueue_script('jquery-waypoints');
	wp_enqueue_script('options-panel-custom');
	global $adap_skin_colors;
	wp_localize_script('options-panel-custom', 'adap_theme_skins', $adap_skin_colors);


}

function progressive_color_option_type($option_name, $value, $val)
{
	$default_color = '';
	if (isset($value['std'])) {
		if ($val != $value['std'])
			$default_color = ' data-default-color="' . $value['std'] . '" ';
	}

	$output = '<input width="300px" height="25px" name="' . esc_attr($option_name . '[' . $value['id'] . ']') . '" id="' . esc_attr($value['id']) . '" class="of-progressive-color"  type="text" value="' . esc_attr($val) . '"' . $default_color . ' />';


	return $output;
}

add_filter('optionsframework_progressive_color', 'progressive_color_option_type', 10, 3);

function sanitize_progressive_color( $input, $option ){
	return $input;
}
add_filter( 'of_sanitize_progressive_color', 'sanitize_progressive_color', 10, 2 );


add_action('init', 'adap_import_post_options');
function adap_import_post_options()
{
	require_once('options-posts.php'); // Register w/ Developer Custom Fields
	if (!class_exists('cmb_Meta_Box')) {
		require_once('inc/post-options/init.php'); // Register w/ Developer Custom Fields
	}
}

global $adap_skin_colors;
if (!isset($adap_skin_colors)) {
	require_once(get_template_directory() . '/skins.php');
}

require_once('classes/theme.options.php');

add_action('init', 'adap_composer_settings');
function adap_composer_settings()
{
	if (!get_option('wpb_js_content_types')) {
		update_option('wpb_js_content_types', array('post', 'page', 'portfolio'));
	}
}

function adap_add_morelink_class($link, $text)
{
	return '...  <br><a class="excerpt-read-more btn" href="' . get_permalink($post->ID) . '" title="' . __('Read', 'adap') . ' ' . get_the_title($post->ID) . '">' . __('Read More', 'adap') . '</a>';
}

add_action('the_content_more_link', 'adap_add_morelink_class', 10, 2);


function adap_add_post_footer_meta($content)
{

	// Add meta-footer partial template on single post content
	ob_start();

	?>
	<?php
	if (get_post_format() == 'quote' || get_post_format() == 'image') {
		get_template_part('meta');
	}


	if (is_single() && get_post_type() == 'post') {
		?>

		<hr class="post-divider post-meta-footer-divider">
		<?php get_template_part('meta', 'footer'); ?>
	<?php

	}

	$ret_val = ob_get_contents();
	ob_end_clean();
	$content .= $ret_val;
	return $content;

}

add_filter('the_content', 'adap_add_post_footer_meta', 19);

function adap_add_post_nav($content)
{

	// Add meta-footer partial template on single post content
	if (is_single() && get_post_type() == 'post') {
		ob_start();
		?>

		<?php get_template_part('nav', 'post'); ?>
		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		$content .= $ret_val;
	}
	return $content;

}

add_filter('the_content', 'adap_add_post_nav', 99);


add_action('init', 'adap_add_infinite_scroll');
function adap_add_infinite_scroll()
{
	add_theme_support('infinite-scroll', array(
		'container' => 'content',
		'footer_widgets' => false,
		'footer' => false
	));
}

function adap_get_categories_meta_markup()
{

	$categories = get_the_category();

	if (count($categories) <= 2) {
		return get_the_category_list(', ');
	}

	ob_start();
	?>

	<?php

	// Show the first three categories
	$initial_list = '';
	for ($i = 0; $i < 2; $i++) {
		$initial_list .= '<a href="' . get_category_link($categories[$i]->term_id) . '" >' . $categories[$i]->name . '</a>';
		if ($i < 1) {
			$initial_list .= ', ';
		}
	}
	echo $initial_list;

	// Add the rest to a Bootstrap dropdown
	?>,
	<div class="btn-group more-categories-btn-group">
		<a class="more-link" data-toggle="dropdown" href="#"><i class="entypo-dot-3"></i></a>
		<ul class="dropdown-menu pull-right" role="menu">

			<?php for ($i = 2; $i < count($categories); $i++) { ?>
				<li role="menuitem"><a tabindex="-1"
									   href="<?php echo get_category_link($categories[$i]->term_id); ?>"><?php echo $categories[$i]->name; ?></a>
				</li>
			<?php } ?>

		</ul>
	</div>


	<?php
	$ret_val = ob_get_contents();
	ob_end_clean();

	return $ret_val;
}


function adap_body_classes()
{

	$classes = array();
	$classes[] = AdapThemeOptions::get_stretched_or_boxed_class();
	$classes[] = AdapThemeOptions::get_page_shadow_class();
	$classes[] = AdapThemeOptions::get_skin_class();
	$classes[] = AdapThemeOptions::get_sticky_header_class();
	$classes[] = AdapThemeOptions::get_translucent_sticky_header_class();
	return implode(' ', $classes);

}

function adap_html_class($additional_classes = '')
{
	echo apply_filters('adap_html_class', $additional_classes);
}

add_filter('adap_html_class', 'test_html_class');
function test_html_class($classes)
{
	return $classes . ' test-class';
}

add_filter('adap_html_class', 'adap_site_background_cover_class');
function adap_site_background_cover_class($classes)
{
	return $classes . ' ' . AdapThemeOptions::get_background_cover_class();
}


if (!function_exists('adap_html2rgb')) {
	function adap_html2rgb($color)
	{
		if ($color[0] == '#')
			$color = substr($color, 1);
		if (strlen($color) == 6)
			list($r, $g, $b) = array($color[0] . $color[1],
				$color[2] . $color[3],
				$color[4] . $color[5]);
		elseif (strlen($color) == 3)
			list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]); else
			return false;
		$r = hexdec($r);
		$g = hexdec($g);
		$b = hexdec($b);
		return array($r, $g, $b);
	}
}

?>