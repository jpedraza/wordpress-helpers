<?php

require 'wp-load.php';

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

<h3>Plugins</h3>
<?php $plugins = get_option('active_plugins'); if( count( $plugins ) ): ?>
<ul>
	<?php foreach($plugins as $plugin): //$plugin_data = get_plugin_data( $plugin ); ?>
	<li><?php echo $plugin; ?></li>
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
<style>
/* Apply a natural box layout model to all elements: http://paulirish.com/2012/box-sizing-border-box-ftw/ */
* {
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
}
.chromeframe {
	position: absolute;
	top: 0;
}
/* Ok, this is where the fun starts.
-------------------------------------------------------------------------------*/

/* A Linux- and Windows-friendly sans-serif font stack: http://prospects.mhurrell.co.uk/post/updating-the-helvetica-font-stack */
body {
	padding: 15px 100px;
	font: 13px Helmet, Freesans, sans-serif;
}
/* Using local fonts? Check out Font Squirrel's webfont generator: http://www.fontsquirrel.com/tools/webfont-generator */

/* We like off-black for text. */
body, select, input, textarea {
	color: #333;
}
a {
	color: #03f;
}
a:hover {
	color: #69f;
}

/* Custom text-selection colors (remove any text shadows: http://twitter.com/miketaylr/status/12228805301) */
::-moz-selection {
background: #fcd700;
color: #fff;
text-shadow: none;
}
::selection {
	background: #fcd700;
	color: #fff;
	text-shadow: none;
}
/*	j.mp/webkit-tap-highlight-color */
a:link {
	-webkit-tap-highlight-color: #fcd700;
}
ins {
	background-color: #fcd700;
	color: #000;
	text-decoration: none;
}
mark {
	background-color: #fcd700;
	color: #000;
	font-style: italic;
	font-weight: bold;
}

/* Mozilla dosen't style place holders by default */
input:-moz-placeholder {
color:#a9a9a9;
}
textarea:-moz-placeholder {
color:#a9a9a9;
}

/* Print styles!
-------------------------------------------------------------------------------*/
@media print {
}

/* Media queries!
-------------------------------------------------------------------------------*/

@media screen and (max-width: 480px) {
}
</style>
</head>
<body>
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
</body>
</html>
