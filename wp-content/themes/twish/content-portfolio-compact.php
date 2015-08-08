<?php $curr_post = adap_curr_post(); ?>

<article  <?php post_class('clearfix portfolio-compact-layout portfolio-item-layout'); ?>
		 role="article"
		 itemscope
		 itemtype="schema.org/BlogPosting">
	<section class="entry-content clearfix" itemprop="articleBody">

		<div class="row-fluid">
			<div class="span8 portfolio-nav-wrapper">
				<?php do_action('adap_sc_portfolio_item_nav'); ?>
			</div>
		</div>

		<div class="row-fluid portfolio-item-content-wrapper">

			<div class="span8 portfolio-featured-media-wrapper">
				<header class="article-header">
					<?php echo $curr_post['featured']; ?>
				</header>
			</div>


			<div class="span4 portfolio-details-content-wrapper ">
				<div class="portfolio-item-details-wrapper">
					<?php do_action('adap_sc_portfolio_item_details', $curr_post); ?>
				</div>
				<div class="portfolio-content-wrapper">
					<?php echo $curr_post['preview_content']; ?>
				</div>
			</div>

		</div>
	</section>
	<!-- end article section -->

	<footer class="article-footer">
		<p class="clearfix"><?php the_tags('<span class="tags">' . __('Tags:', 'adap') . '</span> ', ', ', ''); ?></p>

	</footer>
	<!-- end article footer -->

	<?php comments_template(); ?>

</article> <!-- end article -->
