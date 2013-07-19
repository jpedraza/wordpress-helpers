<?php

function register_post_type_builder( $singular_title, $plural_title, $args_overrides = array(), $prefix = "" ) {
	add_action( 'init', function()  use( &$singular_title, &$plural_title, &$args_overrides, &$prefix) {
		echo "<!-- prefix: " . $prefix . " -->";
		register_post_type( $prefix . str_replace( '-', '_', sanitize_key( $singular_title )), array_merge( array(
		'labels' => array(
			'name' => $plural_title,
			'singular_name' => $singular_title,
			'add_new' => 'Add New',
			'add_new_item' => 'Add New ' . $singular_title,
			'edit_item' => 'Edit ' . $singular_title,
			'new_item' => 'New ' . $singular_title,
			'all_items' => 'All ' . $plural_title,
			'view_item' => 'View ' . $singular_title,
			'search_items' => 'Search ' . $plural_title,
			'not_found' =>  'No ' . strtolower( $plural_title ) . ' found',
			'not_found_in_trash' => 'No ' . strtolower( $plural_title ) . ' found in Trash', 
			'parent_item_colon' => '',
			'menu_name' => $plural_title
		),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array( 'slug' => str_replace( '-', '_', sanitize_key( $plural_title ) ) ),
		'capability_type' => 'post',
		'menu_icon' => '',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	), (array) $args_overrides));
	});
}

?>