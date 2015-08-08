<?php

function adap_sc_portfolio_item_details($curr_post)
{
	?>
	<div class="portfolio-item-details">
		<h1 class="post-title h5 extra-bold">
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<?php echo $curr_post['title']; ?>
			</a>
		</h1>
		<?php
		$icon_link_text = get_post_meta(get_the_ID(), '_adap_sc_icon_link_text', true);
		$icon_link_url = get_post_meta(get_the_ID(), '_adap_sc_icon_link_url', true);

		$icon_class = null;

		$icon_type = get_post_meta(get_the_ID(), '_adap_sc_icon_link_type', true);
		$entypo_icon = get_post_meta(get_the_ID(), '_adap_sc_icon_link_entypo', true);
		$fontawesome_icon = get_post_meta(get_the_ID(), '_adap_sc_icon_link_fontawesome', true);
		$icon_class = _adap_sc_get_icon_class($icon_type, $fontawesome_icon, $entypo_icon);


		?>
		<a class="portfolio-item-details-link" href="<?php echo $icon_link_url ?>" target="_blank">
			<i class="<?php echo $icon_class; ?>"></i><?php echo $icon_link_text ?></a>

		<?php
		$cat_header = get_post_meta(get_the_ID(), '_adap_sc_categories_header', true);
		?>
		<h2 class="h5 post-categories-heading"><?php echo $cat_header; ?></h2>

		<?php do_action('adap_sc_portfolio_item_categories'); ?>
	</div>
<?php
}

add_action('adap_sc_portfolio_item_details', 'adap_sc_portfolio_item_details');

/**
 * call in loop
 */
function adap_sc_portfolio_item_categories()
{


	$cats = wp_get_post_terms(get_the_ID(), array('portfolio_category'),
		array(
			'hide_empty' => 0
		));
	?>
	<ul class="portfolio-item-skills">
		<?php
		foreach ($cats as $category) {
			$name = $category->name;
			$icon_type = adap_sc_get_portfolio_cat_option('icon_type', $category->slug);
			$entypo_icon = adap_sc_get_portfolio_cat_option('entypo_icon', $category->slug);
			$fontawesome_icon = adap_sc_get_portfolio_cat_option('fontawesome_icon', $category->slug);

			$icon_class = _adap_sc_get_icon_class($icon_type, $fontawesome_icon, $entypo_icon);

			?>
			<li>
				<?php if ($icon_class !== null): ?>
					<?php _adap_category_icon($category); ?>
				<?php endif; ?>
				<?php echo $name; ?>
			</li>
		<?php

		}
		?>
	</ul>
<?php
}

add_action('adap_sc_portfolio_item_categories', 'adap_sc_portfolio_item_categories');

function _adap_category_icon($category)
{
	$icon_type = adap_sc_get_portfolio_cat_option('icon_type', $category->slug);
	$entypo_icon = adap_sc_get_portfolio_cat_option('entypo_icon', $category->slug);
	$fontawesome_icon = adap_sc_get_portfolio_cat_option('fontawesome_icon', $category->slug);

	$icon_class = _adap_sc_get_icon_class($icon_type, $fontawesome_icon, $entypo_icon);

	if (!$icon_class) {
		//default icon
		$icon_class = 'entypo-address';
	}
	?>
	<i class="portfolio-category-icon <?php echo $icon_class; ?>"></i>
<?php
}

function _adap_sc_get_icon_class($icon_type, $fontawesome_icon, $entypo_icon)
{
	$icon_class = null;
	if ($icon_type != null && $icon_type != 'none') {
		$icon = $icon_type == 'fontawesome' ? $fontawesome_icon : $entypo_icon;
		if ($icon_type == 'fontawesome') {
			$icon_class = 'icon' . '-' . $icon;
		} else {
			$icon_class = 'entypo' . '-' . $icon;
		}
	}

	return $icon_class;
}