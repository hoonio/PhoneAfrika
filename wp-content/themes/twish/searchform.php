<form class="form-search" role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">

    <span class="input-wrap search-input-wrap">
    <input placeholder="<?php echo esc_attr__('Search', 'adap'); ?>"
		   class="search-query" type="text" value="" name="s" id="s"/>
    </span>
	<input class="btn" type="submit" id="searchsubmit" value="Go"/>
</form>