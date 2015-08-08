<?php $curr_post = adap_curr_post(); ?>

<article <?php post_class('clearfix'); ?> role="article">

	<div class="post-featured-content">
		<?php echo $curr_post['featured']; ?>
	</div>

	<div class="post-text-content">

		<header class="article-header">

			<?php get_template_part('meta'); ?>
			<h1 class="post-title h2"><a href="<?php the_permalink() ?>" rel="bookmark"
										 title="<?php the_title_attribute(); ?>"><?php echo $curr_post['title']; ?></a>
			</h1>

		</header>
		<!-- end article header -->

		<div class="entry-content clearfix">
			<?php echo $curr_post['preview_content']; ?>
			<?php
			if (is_single()) {
				wp_link_pages(array('before' => '<div class="page-links">' . __('Pages:', 'adap'), 'after' => '</div>'));
			}
			?>
		</div>
		<div class="clear"></div>
	</div>
	<!-- end article section -->


	<hr class="post-divider end-post-divider">

	<!-- end article footer -->

	<?php comments_template(); // uncomment if you want to use them ?>

</article>
<!-- end article -->

