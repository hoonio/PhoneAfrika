<?php

class AdapSearchbarSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		ob_start();

		get_search_form();

		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Searchbar',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array()
		);
	}
}

new AdapSearchbarSC('searchbar');

