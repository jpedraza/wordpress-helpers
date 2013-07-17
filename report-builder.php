<?php

require 'wp-load.php';

require 'wp-admin/includes/plugin.php';

$report_title = get_bloginfo() . ' Report';

$base_prefix = $wpdb->base_prefix;

function site_report() { ?>
	<?php $theme = wp_get_theme(); $templates = $theme->get_page_templates()?>

<h3>Templates</h3>
<ul>
	<?php foreach($templates as $template_name => $template_file_name): ?>
	<li><?php echo $template_file_name . " : " . $template_name; ?></li>
	<?php endforeach; ?>
</ul>

<h3>Taxonomies</h3>
<?php $taxonomies = get_taxonomies(array(), 'output'); ?>
<ul>
	<?php foreach($taxonomies as $taxonomy): ?>
	<li><?php echo $taxonomy->label; ?></li>
	<?php endforeach; ?>
</ul>

<h3>Active Plugins <small><a href='#show-details'>Show Details</a></small></h3>
<?php $plugins = get_option('active_plugins'); if( count( $plugins ) ): ?>
<ul>
	<?php foreach($plugins as $plugin):
	$plugin_data = (object)get_plugin_data( plugin_dir_path( __FILE__ ) . 'wp-content/plugins/' . $plugin ); ?>
	<li><?php //echo '<pre>' . print_r( $plugin_data, 1 ) . '</pre>'; ?>
		<h4><?php echo $plugin_data->Name; ?></h4>
		<div class="hide"><?php echo "<p>$plugin</p>"; ?></div>
		</li>
	<?php endforeach; ?>
</ul>
<?php else: ?>
<p>No Plugins</p>
<?php endif; ?>


<pre><?php print_r( $site_details ); ?></pre>
	
<?php } ?><!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $report_title; ?></title>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
</head>
<body>
<div class='container'>
<h1><?php echo $report_title; ?></h1>
<?php $sites = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$base_prefix}blogs ORDER BY blog_id" ) ); ?>
<?php if( !count( $sites )): ?>
<p>Not a multi-site installation.</p>
<?php site_report(); ?>
<?php else: ?>
<p>This is a multi-site installation.</p>
<?php foreach($sites as $site): 
switch_to_blog( $site->blog_id ); //$site_details = get_blog_details( $site->blog_id ); ?>
<h2><?php echo get_bloginfo(); //$site_details->blogname; ?></h2>
<?php //$templates = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$base_prefix}{$site->blog_id}_postmeta WHERE meta_key = '_wp_page_template' group by meta_value " ) );?>
<?php site_report(); ?>
<?php endforeach; ?>
<?php endif; ?>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>$(function(){ $('a[href="#show-details"]').click(function(){ $('.hide', $(this).hide().closest('h3').next() ).show(); }) })</script>
</body>
</html>