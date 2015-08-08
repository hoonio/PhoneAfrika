<?php $curr_post = adap_curr_post(); ?>

<article  <?php post_class('clearfix portfolio-full-width-layout portfolio-item-layout'); ?>
		 role="article"
		 itemscope
		 itemtype="schema.org/BlogPosting">
	<section class="entry-content clearfix" itemprop="articleBody">
		<?php do_action('adap_sc_portfolio_item_nav'); ?>
		<header class="article-header">


			<?php echo $curr_post['featured']; ?>

		</header>

		<div class="row-fluid portfolio-item-content-wrapper">

			<div class="span5">
				<?php do_action('adap_sc_portfolio_item_details', $curr_post); ?>
			</div>

			<div class="span7 portfolio-item-content">
				<?php echo $curr_post['preview_content']; ?>
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
