<?php

function register_taxonomy_builder( $singular_title, $plural_title, $associate_wih_post_types = array(), $args_overrides = array(), $prefix = "" ) {
	
	$slug = $prefix . str_replace( '-', '_', sanitize_key( $singular_title ));
	
	add_action( 'init', function()  use( &$singular_title, &$plural_title, &$args_overrides, &$slug) {
		
		register_taxonomy( $slug, array_merge( array(
		'labels' => array(
			'name' => __( $plural_title ),
			'singular_name' => __( $singular_title ),
			'search_items' => __( 'Search '.$plural_title ),
			'all_items' => __( 'All '.$plural_title ),
			'parent_item' => __( 'Parent '.$singular_title ),
			'parent_item_colon' => __( 'Parent '.$singular_title.':' ),
			'edit_item' => __( 'Edit '.$singular_title ),
			'update_item' => __( 'Update '.$singular_title ),
			'add_new_item' => __( 'Add New '.$singular_title ),
			'new_item_name' => __( 'New '.$singular_title.' Name' ),
			'menu_name' => __( $singular_title ),
		),
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => false,
		'show_admin_column' => true,
		'hierarchical' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => $slug ),
	), (array) $args_overrides));
	});
}

?>