<?php

function register_post_type_builder( $singular_title, $plural_title, $args_overrides = array(), $prefix = "" ) {
	
	$post_type = $prefix . str_replace( '-', '_', sanitize_key( $singular_title ));
	
	if(array_key_exists('icon', $args_overrides)){
		
		add_action( 'admin_head', function() use( &$post_type, &$args_overrides ) { ?><style type="text/css">
			#menu-posts-<?php echo $post_type; ?> .wp-menu-image {
				background: url(<?php echo $args_overrides['icon']; ?>) no-repeat 6px -17px !important;
			}
			#menu-posts-<?php echo $post_type; ?>:hover .wp-menu-image,
			#menu-posts-<?php echo $post_type; ?>.wp-has-current-submenu .wp-menu-image {
				background-position: 6px 7px !important;
			}
		</style><?php });
	}
	
	add_action( 'init', function()  use( &$singular_title, &$plural_title, &$args_overrides, &$prefix) {
		
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