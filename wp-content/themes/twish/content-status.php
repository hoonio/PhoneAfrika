<?php $curr_post = adap_curr_post(); ?>

<article  <?php post_class('clearfix'); ?> role="article">

	<?php get_template_part('meta'); ?>

	<header class="article-header">
		<?php echo get_avatar(get_the_author_meta('ID')); ?>
		<h1 class="post-title h2"><?php the_author(); ?></h1>
	</header>
	<!-- end article header -->

	<div class="entry-content clearfix">
		<?php echo $curr_post['preview_content']; ?>
	</div>

	<hr class="post-divider end-post-divider">

	<?php comments_template(); // uncomment if you want to use them ?>

</article>
<!-- end article -->
