<?php $curr_post = adap_curr_post(); ?>
<article  <?php post_class('clearfix'); ?> role="article">

	<?php get_template_part('meta'); ?>

	<div class="aside">
		<h1 class="post-title h2"><a href="<?php the_permalink() ?>" rel="bookmark"
									 title="<?php the_title_attribute(); ?>"><?php echo $curr_post['title']; ?></a>
		</h1>

		<div class="entry-content clearfix">
			<?php echo $curr_post['preview_content']; ?>
		</div>
	</div>

	<?php comments_template(); // uncomment if you want to use them ?>

</article>
<!-- end article -->

<hr class="post-divider end-post-divider">