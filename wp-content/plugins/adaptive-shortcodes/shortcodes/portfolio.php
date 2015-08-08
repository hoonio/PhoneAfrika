<?php

class AdapPortfolioSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		wp_enqueue_script('adap-isotope', AdapCommon::get_base_url() . '/js/lib/isotope/jquery.isotope.min.js', array('jquery'), false, true);
		wp_enqueue_script('adap-portfolio', AdapCommon::get_base_url() . '/js/adap-portfolio.js', array('adap-isotope'), false, true);

		ob_start();

		$atts = $this->getPreparedAtts($atts, $content);

		$atts = shortcode_atts(array(
			'items' => '10',
			'paginate' => 'yes',
			'categories' => '', //comma delimited ID (int) value
			'post_type' => 'portfolio',
			'taxonomy' => 'portfolio_category',
			'display' => 'content', //as opposed to "excerpt"
			'columns' => '4',
			'show_all_text' => 'Show All',
			'show_title' => true,
			'show_excerpt' => true,
			'show_pagination' => true,
			'show_item_categories' => true,
			'show_filters' => true,
			'filter_display' => 'text',
			'link_behavior' => 'lightbox',
			'order' => 'DESC',
			'orderby' => 'date',
			'generate_thumbnail' => 'true',
			'exclude' => ''

		), $atts);

		extract($atts);

		$this->do_query($atts);
		?>

		<?php if (have_posts()) : ?>
		<?php

		$categories = $this->getCurrentCategories($categories, $taxonomy);

		switch ($columns) {
			case 3:
				$column_class = 'one-third span4';
				$img_size = 'portfolio-three-column';
				break;
			case 2:
				$column_class = 'one-half span6';
				$img_size = 'portfolio-two-column';
				break;
			case 1:
				$column_class = 'whole span12';
				$img_size = 'portfolio-one-column';
				break;
			default:
				$column_class = 'one-fourth span3';
				$img_size = 'portfolio-four-column';
				break;
		}

		if ($generate_thumbnail == 'false') {
			$img_size = 'full';
		}

		$pp_gallery_string = sprintf('rel="prettyPhoto[%s]"', uniqid('gallery-'));
		$show_icon = $filter_display != 'icon' ? 'false' : 'true';

		$filter_icon_class = 'show-icon-' . $show_icon;

		?>

		<div class="adap-portfolio">
			<?php if ($show_filters != 'false') { ?>
				<ul class="filters <?php echo $filter_icon_class; ?>">
					<li><a title="<?php echo $show_all_text ?>" href="#" class="filter-link active"
						   data-filter="*">
							<?php
							if ($show_icon != 'false') {
								?>
								<i class="portfolio-category-icon icon-asterisk"></i>
							<?php
							} else {
								echo $show_all_text;
							}

							?></a></li>
					<?php
					foreach ($categories as $cat) {
						$this->printFilterMarkup($cat, $show_icon);
					}
					?>
				</ul>
			<?php } ?>

			<div class="portfolio-thumbs">
				<?php

				//make the_content() respect <!--more--> tags
				//by setting the global "$more" value.
				global $more;
				$orig_more = $more;
				$more = 0;

				//we remove this handler before we process the content
				//so we don't get an infinite loop
				remove_shortcode($this->sc_handle);
				add_shortcode($this->sc_handle, array($this, 'nested_portfolio_shortcode_handler'));
				?>


				<?php while (have_posts()) : the_post(); ?>
					<?php
					global $post;
					$pid = $post->ID;

					$a_class = '';
					$permalink = get_permalink();
					$href = $permalink;


					$external_link = get_post_meta($pid, '_adap_sc_external_link_override', true);
					$external_link = trim($external_link);

					if ($external_link && $external_link != '') {
						$href = $external_link;
					}
					?>
					<div
						class="portfolio-item <?php echo $column_class; ?> <?php $this->printCategoryClasses($pid, $taxonomy) ?>">
						<div class="thumbnail">

							<div class="portfolio-image-preview">
								<div class="image-overlay">
									<div class="image-overlay-inner">

										<?php
										if (has_post_thumbnail()) {
											wp_enqueue_script('prettyphoto');
											wp_enqueue_style('prettyphoto');
											$lb_href = wp_get_attachment_image_src(get_post_thumbnail_id($pid), 'large');
											$lb_href = $lb_href[0];

											$custom_link = get_post_meta($pid, '_adap_sc_link_override', true);
											$custom_link = trim($custom_link);

											if ($custom_link && $custom_link != '') {
												$lb_href = $custom_link;
											}

											if ($lb_href) {
												?>
												<a title="<?php the_title(); ?>"
												   class="prettyphoto portfolio-lightbox-link"
												   href="<?php echo $lb_href; ?>" <?php echo $pp_gallery_string; ?>><i
														class="entypo-eye"></i> </a>
											<?php
											}
										} ?>

										<a title="<?php the_title(); ?>"
										   href="<?php echo $href ?>" <?php echo $a_class; ?>><i
												class="entypo-link"></i></a>

									</div>
								</div>
								<div class="image-wrapper invisible">
									<?php
									echo get_the_post_thumbnail($pid, $img_size);
									?>
								</div>
							</div>

							<?php if ($show_title != 'false') { ?>
								<h3 class="portfolio-preview-title"><a href="<?php echo $permalink; ?>"><?php the_title(); ?></a></h3>
							<?php } ?>

							<?php
							if ($show_item_categories !== 'false') {
								echo '<div class="portfolio-categories">';
								echo get_the_term_list($pid, $taxonomy, '', ', ', '');
								echo '</div>';
							}
							?>

							<?php if ($show_excerpt != 'false') { ?>
								<div class="portfolio-item-excerpt">
									<?php
									echo get_the_excerpt();
									?>
								</div>
							<?php } ?>

						</div>
					</div>


				<?php endwhile; ?>
				<?php
				//replace the portfolio handling
				remove_shortcode($this->sc_handle);
				$this->register_shortcode();

				$more = $orig_more;
				?>
			</div>
			<!--End Thumbnails--></div>

		<?php if ($show_pagination != 'false') { ?>
			<?php if (function_exists('bones_page_navi')) { ?>
				<div class="portfolio-pagination-links">
					<?php bones_page_navi(); ?>
				</div>
			<?php } else { ?>
				<nav class="wp-prev-next">
					<ul class="clearfix">
						<li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', 'adap_sc')) ?></li>
						<li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', 'adap_sc')) ?></li>
					</ul>
				</nav>
			<?php } ?>
		<?php } ?>


	<?php else : ?>

		<article id="post-not-found" class="hentry clearfix">
			<header class="article-header">
				<h1><?php _e("Oops, Post Not Found!", 'adap_sc'); ?></h1>
			</header>
			<section class="entry-content">
				<p><?php _e("Uh Oh. Something is missing. Try double checking things.", 'adap_sc'); ?></p>
			</section>
		</article>

	<?php endif; ?>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();

		wp_reset_query();
		return $ret_val;
	}

	function nested_portfolio_shortcode_handler()
	{
		return '';
	}

	function getCurrentCategories($categories_att, $taxonomy)
	{
		$current_cats = is_array($categories_att) ? $categories_att : array_filter(explode(',', $categories_att));
		$cats = array();
		foreach ($current_cats as $c_slug) {
			$cats[] = get_term_by('slug', $c_slug, $taxonomy);
		}

		return $cats;
	}

	function printFilterMarkup($category, $show_icon = 'true')
	{
		$name = $category->name;
		$dname = $category->slug;
		$d_filter = '.' . $dname . '_filter';
		?>
		<li>
			<a title="<?php echo $name; ?>" href="#" class="filter-link" data-filter="<?php echo $d_filter; ?>">
				<?php
				if ($show_icon != 'false') {
					_adap_category_icon($category);
				} else {
					echo $name;
				}
				?>
			</a>
		</li>
	<?php
	}

	function printCategoryClasses($pid, $tax)
	{
		$classes = '';
		$icats = get_the_terms($pid, $tax);

		if (is_array($icats) || is_object($icats)) {
			foreach ($icats as $c) {
				$classes .= $c->slug . '_filter ';
			}
		}

		echo $classes;
	}

	function configureParams()
	{
		$cats = get_terms('portfolio_category', array('hide_empty' => false));
		$cat_vals = array('None' => '');
		foreach ($cats as $c) {
			$cat_vals[$c->name] = $c->slug;
		}

		$pitems = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'portfolio'
		));
		$post_vals = array();
		foreach ($pitems as $item) {
			$post_vals[$item->post_name] = $item->ID;
		}

		$this->params = array(
			'name' => 'Portfolio',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => 'Items',
					'param_name' => 'items',
					'value' => '10',
					'description' => 'The number of items to show on a given page. Set to -1 to show all.'
				),
				AdapAutoVCShortcode::$order_param,
				AdapAutoVCShortcode::$orderby_param,
				array(
					'type' => 'dropdown',
					'heading' => 'Number of Columns',
					'param_name' => 'columns',
					'sch_default' => 4,
					'value' => array('Four' => 4, 'Three' => 3, 'Two' => 2, 'One' => 1),
				),
				AdapAutoVCShortcode::bool_param('generate_thumbnail', 'Generate thumbnail matching column size'),
				AdapAutoVCShortcode::bool_param('show_title', 'Display Title'),
				AdapAutoVCShortcode::bool_param('show_excerpt', 'Display Excerpt'),
				AdapAutoVCShortcode::bool_param('show_filters', 'Display Filters'),
				array(
					'type' => 'dropdown',
					'heading' => 'Filter Displays',
					'param_name' => 'filter_display',
					'sch_default' => 'text',
					'value' => array('Text' => 'text', 'Icons' => 'icon'),
					'dependency' => array('element' => "show_filters", 'value' => array('true'))
				),
				AdapAutoVCShortcode::bool_param('show_pagination', 'Display Pagination'),
				AdapAutoVCShortcode::bool_param('show_item_categories', 'Display portfolios\' associated categories.'),
				array(
					'type' => 'dropdown',
					'heading' => 'Link Behavior',
					'param_name' => 'link_behavior',
					'sch_default' => 'lightbox',
					'value' => array(
						'Link to Lightbox of the Featured Image' => 'lightbox',
						'Link to Portfolio Item Page' => 'detail_page'),
				),
				array(
					'type' => 'textfield',
					'heading' => 'Show All Text',
					'param_name' => 'show_all_text',
					'value' => 'Show All',
					'description' => 'Defines the display text for the "Show All" filter'
				),
				array(
					'type' => 'dropdown',
					'heading' => 'Paginate',
					'param_name' => 'paginate',
					'value' => array('Paginate' => 'yes', 'Don\'t Paginate' => 'no'),
				),
				array(
					"type" => "checkbox",
					"heading" => __("Categories", 'adap_sc'),
					"param_name" => "categories",
					"value" => $cat_vals,
					"description" => __("If you want to narrow output, select category names here. Note: Only selected categories will be included.", 'adap_sc')
				),
				array(
					"type" => "checkbox",
					"heading" => __("Exclude Portfolio Items", 'adap_sc'),
					"param_name" => "exclude",
					"sch_default" => '',
					"value" => $post_vals,
					"description" => __("Exclude the selected items from the portfolio", 'adap_sc')
				)
			));
	}

	function do_query($params)
	{
		if ($params['paginate'] == 'false' || $params['paginate'] == 'no')
			$params['items'] = false;

		if (!empty($params['categories']) && is_string($params['categories'])) {
			$cat_terms = explode(',', $params['categories']);
		}
		if (isset($params['exclude']) && is_string($params['exclude'])) {
			$params['exclude'] = explode(',', $params['exclude']);
		}

		$page = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
		if (!$page) $page = 1;
		if (isset($cat_terms[0]) &&
			!empty($cat_terms[0]) &&
			!is_null($cat_terms[0]) &&
			$cat_terms[0] != "null" &&
			!empty($params['taxonomy'])
		) {
			$query = array(
				'orderby' => $params['orderby'],
				'order' => $params['order'],
				'paged' => $page,
				'posts_per_page' => $params['items'],
				'post__not_in ' => $params['exclude'],
				'tax_query' => array(array('taxonomy' => $params['taxonomy'],
					'field' => 'slug',
					'terms' => $cat_terms,
					'operator' => 'IN')));
		} else {
			$query = array(
				'orderby' => $params['orderby'],
				'order' => $params['order'],
				'paged' => $page,
				'posts_per_page' => $params['items'],
				'post__not_in ' => $params['exclude'],
				'post_type' => $params['post_type']);
		}

		$query['post__not_in'] = $params['exclude'];

		query_posts($query);
	}
}


add_action('init', 'register_portfolio_item');

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
* CUSTOM POST TYPES
* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

function register_portfolio_item()
{
// "Portfolio Item" Custom Post Type
	$labels = array(
		'name' => _x('Portfolio Items', 'post type general name', 'adap_sc'),
		'singular_name' => _x('Portfolio Item', 'post type singular name', 'adap_sc'),
		'add_new' => _x('Add New', 'slide', 'adap_sc'),
		'add_new_item' => __('Add New Portfolio Item', 'adap_sc'),
		'edit_item' => __('Edit Portfolio Item', 'adap_sc'),
		'new_item' => __('New Portfolio Item', 'adap_sc'),
		'view_item' => __('View Portfolio Item', 'adap_sc'),
		'search_items' => __('Search Portfolio Items', 'adap_sc'),
		'not_found' => __('No portfolio items found', 'adap_sc'),
		'not_found_in_trash' => __('No portfolio items found in Trash', 'adap_sc'),
		'parent_item_colon' => ''
	);


	$slug = 'items';

//try and get the portfolio slug from the theme options
	if (function_exists('of_get_option')) {
		$opt_slug = of_get_option('portfolio_slug');
		if ($opt_slug && $opt_slug != '') {
			$slug = $opt_slug;
		}
	}

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'has_archive' => true,
		'rewrite' => array('slug' => $slug, 'with_front' => false),
		'supports' => array('title', 'excerpt', 'editor', 'thumbnail', 'comments'),
		'taxonomies' => array('post_tag')
	);

	register_post_type('portfolio', $args);

	register_taxonomy(
		'portfolio_category',
		'portfolio',
		array(
			'hierarchical' => true,
			'label' => 'Portfolio Categories',
			'singular_label' => 'Portfolio Categories',
			'show_ui' => true,
			'rewrite' => true,
			'query_var' => true,
		));


}

//Register the Portfolio Item Options
add_filter('cmb_meta_boxes', 'adap_portfolio_metaboxes');

function adap_portfolio_metaboxes($meta_boxes)
{
	global $icon_listing;
	global $entypo_listing;
	global $icon_type_listing;

	$cmb_icon_listing = array();
	$cmb_entypo_listing = array();
	$cmb_icon_type_listing = array(array('name' => 'None', 'value' => 'none'));

	foreach ($icon_listing as $name => $value) {
		$cmb_icon_listing[] = array('name' => $name, 'value' => $value);
	}
	foreach ($entypo_listing as $name => $value) {
		$cmb_entypo_listing[] = array('name' => $name, 'value' => $value);
	}
	foreach ($icon_type_listing as $name => $value) {
		$cmb_icon_type_listing[] = array('name' => $name, 'value' => $value);
	}


	$prefix = '_adap_sc_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'adap_portfolio_options_metabox',
		'title' => 'Portfolio Item Options',
		'pages' => array('portfolio'), // post type
		'context' => 'normal',
		'priority' => 'low',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Layout',
				'desc' => 'The layout of the portfolio item page',
				'id' => $prefix . 'layout',
				'type' => 'select',
				'options' => array(
					array('name' => 'Full Width', 'value' => 'full-width'),
					array('name' => 'Compact', 'value' => 'compact'),
					array('name' => 'Plain Content', 'value' => 'plain')
				)
			),
			array(
				'name' => 'Resize image to match layout?',
				'id' => $prefix . 'resize_detail_image',
				'type' => 'checkbox'
			),
			array(
				'name' => 'Post Format',
				'desc' => 'The featured media format for the portfolio item detail page',
				'id' => $prefix . 'format',
				'type' => 'select',
				'options' => array(
					array('name' => 'Standard (Featured Image)', 'value' => 'standard'),
					array('name' => 'Video', 'value' => 'video'),
					array('name' => 'Gallery', 'value' => 'gallery')
				)
			),
			array(
				'name' => 'Custom Video URL Link Override',
				'desc' => 'If specified, this field will override the linking behavior of the portfolio this item appears in. If you place a video URL here, it will appear in a lightbox.',
				'id' => $prefix . 'link_override',
				'type' => 'text'
			),
			array(
				'name' => 'External URL Link Override',
				'desc' => 'If specified, this field will override the linking behavior of the portfolio this item appears in. The external page will be navigated to. If Custom Video URL Link Override is set, it will be applied instead of this URL',
				'id' => $prefix . 'external_link_override',
				'type' => 'text'
			),
			array(
				'name' => 'Post Navigation Portfolio Link URL',
				'desc' => 'The URL for the Portfolio link in the portfolio item\'s navigation section',
				'id' => $prefix . 'link_portfolio',
				'type' => 'text'
			),
			array(
				'name' => 'Portfolio Item Details Link Text',
				'desc' => 'The text for the portfolio item details link',
				'id' => $prefix . 'icon_link_text',
				'type' => 'text'
			),
			array(
				'name' => 'Portfolio Item Details URL',
				'desc' => 'The URL for the portfolio item details link',
				'id' => $prefix . 'icon_link_url',
				'type' => 'text'
			),
			array(
				'name' => 'Link Icon Set',
				'desc' => 'The icon set to draw the link icon from',
				'id' => $prefix . 'icon_link_type',
				'type' => 'select',
				'options' => $cmb_icon_type_listing
			),
			array(
				'name' => 'Entypo Icon',
				'desc' => 'The icon to use if using the Entypo set',
				'id' => $prefix . 'icon_link_entypo',
				'type' => 'select',
				'options' => $cmb_entypo_listing
			),
			array(
				'name' => 'Fontawesome Icon',
				'desc' => 'The icon to use if using the Fontawesome set',
				'id' => $prefix . 'icon_link_fontawesome',
				'type' => 'select',
				'options' => $cmb_icon_listing
			),
			array(
				'name' => 'Portfolio Categories Header Text',
				'desc' => 'The text to display above the portfolio category listing',
				'id' => $prefix . 'categories_header',
				'type' => 'text'
			),

		),
	);

	return $meta_boxes;
}

new AdapPortfolioSC('portfolio');