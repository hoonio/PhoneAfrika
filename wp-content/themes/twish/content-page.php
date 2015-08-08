<article  <?php post_class('clearfix'); ?> role="article" itemscope
		 itemtype="http://schema.org/BlogPosting">

	<section class="entry-content clearfix" itemprop="articleBody">
		<?php the_content(); ?>
	</section>
	<!-- end article section -->

	<footer class="article-footer">
		<p class="clearfix"><?php the_tags('<span class="tags">' . __('Tags:', 'adap') . '</span> ', ', ', ''); ?></p>

	</footer>
	<!-- end article footer -->

	<?php comments_template(); ?>

</article> <!-- end article -->
