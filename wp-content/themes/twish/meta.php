<?php

if (get_post_type(get_the_ID()) == 'attachment') {
	?>
	<ul class="byline vcard">
		<li class="byline-item byline-datetime"><a href="<?php echo get_permalink(); ?>">
				<time class="updated"
					  datetime="<?php echo get_the_time('Y-m-d'); ?>"><?php echo get_the_time(get_option('date_format')); ?></time>
			</a></li>
		<li class="byline-item byline-comments"><a href="<?php comments_link(); ?>"
												   class="entypo-comment"><?php echo number_format_i18n(get_comments_number()); ?></a>
		</li>
		<li class="byline-item byline-author"><span
				class="author"><?php echo bones_get_the_author_posts_link('entypo-user'); ?></span></li>
	</ul>
<?php
} else {
	?>
	<ul class="byline vcard">
		<li class="byline-item byline-datetime"><a href="<?php echo get_permalink(); ?>">
				<time class="updated"
					  datetime="<?php echo get_the_time('Y-m-d'); ?>"><?php echo get_the_time(get_option('date_format')); ?></time>
			</a></li>
		<li class="byline-item right-side-byline-items-parent">
			<ul class="right-side-byline-items">
				<li class="byline-item byline-author"><span
						class="author"><?php echo bones_get_the_author_posts_link('entypo-user'); ?></span></li>
				<?php if (count(get_the_category()) > 0) { ?>
					<li class="byline-item byline-categories">
						<div class="categories entypo-docs"><?php echo adap_get_categories_meta_markup(); ?></div>
					</li>
				<?php } ?>
				<li class="byline-item byline-comments"><a href="<?php comments_link(); ?>"
														   class="entypo-comment"><?php echo number_format_i18n(get_comments_number()); ?></a>
				</li>
			</ul>
		</li>
	</ul>
<?php
}

?>
