<nav class="nav-single next-prev-nav">
	<h3 class="h4 assistive-text post-nav-title"><?php _e('Post Navigation', 'adap'); ?></h3>
	<span
		class="nav-previous"><?php previous_post_link('%link', '<span class="meta-nav">' . _x('', 'Previous post link', 'adap') . '</span> %title'); ?></span>
	<span
		class="nav-next"><?php next_post_link('%link', '%title <span class="meta-nav">' . _x('', 'Next post link', 'adap') . '</span>'); ?></span>
</nav>
