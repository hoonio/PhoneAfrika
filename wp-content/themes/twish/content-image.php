<?php $curr_post = adap_curr_post(); ?>


<article  <?php post_class('clearfix'); ?> role="article">

	<div class="entry-content clearfix">
		<?php echo $curr_post['preview_content']; ?>

	</div>


	<hr class="post-divider end-post-divider">


	<?php comments_template(); // uncomment if you want to use them ?>

</article>
<!-- end article -->

