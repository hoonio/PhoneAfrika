<footer class="article-footer">
	<ul class="byline vcard footer-byline">
		<li class="byline-item byline-author byline-footer-item"><?php echo __('Author:', 'adap'); ?> <?php echo bones_get_the_author_posts_link(); ?></li>
		<li class="byline-item byline-tags byline-footer-item"><?php the_tags('<span class="tags-title">' . __('Tags:', 'adap') . '</span> ', ', ', ''); ?> </li>
	</ul>
</footer>