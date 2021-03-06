<?php

if( ! class_exists( 'WP_List_Table' ) )
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class Jetpack_Omnisearch_Grunion extends WP_List_Table {
	static $instance;
	var $post_type = 'feedback';

	function __construct() {
		self::$instance = $this;
		add_filter( 'omnisearch_results', array( $this, 'search'), 12, 2 );
	}

	function search( $results, $search_term ) {
		parent::__construct();

		$this->post_type_obj = get_post_type_object( $this->post_type );

		$search_url = esc_url( admin_url( sprintf( 'edit.php?post_type=%s&s=%s', urlencode( $this->post_type_obj->name ), urlencode( $search_term ) ) ) );
		$search_link = sprintf( ' <a href="%s" class="add-new-h2">%s</a>', $search_url, esc_html( $this->post_type_obj->labels->search_items ) );
		$html = '<h2>' . esc_html( $this->post_type_obj->labels->name ) . $search_link .'</h2>';

		$this->prepare_items( $search_term );

		ob_start();
		$this->display();
		$html .= ob_get_clean();

		$results[ $this->post_type_obj->labels->name ] = $html;
		return $results;
	}

	function get_columns() {
		$columns = array(
			'feedback_from' => __('From', 'jetpack'),
			'feedback_message' => __('Message', 'jetpack'),
			'feedback_date' => __('Date', 'jetpack'),
		);
		return $columns;
	}

	function prepare_items( $search_term = '' ) {
		$this->_column_headers = array( $this->get_columns(), array(), array() );
		$num_results = apply_filters( 'omnisearch_num_results', 5 );
		$this->items = get_posts( array(
			's' => $search_term,
			'post_type' => $this->post_type,
			'posts_per_page' => $num_results,
		) );
	}

	function column_default( $post, $column_name ) {
		switch ( $column_name ) {
			case 'feedback_from':
			case 'feedback_message':
			case 'feedback_date':
				ob_start();
				grunion_manage_post_columns( $column_name, $post->ID );
				return ob_get_clean();
			default:
				return '<pre>' . print_r( $post, true ) . '</pre>';
		}
	}
}
