<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="<?php bloginfo('charset'); ?>" />


	<!-- MOBILE SCREEN RESIZING -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<!-- END MOBILE SCREEN RESIZING -->

	
	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
	
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->


	<!-- ICONS -->
	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/favicon.ico" />
	<!-- END ICONS -->

	
	<!-- STYLESHEETS -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/tablet.css" media="only screen and (min-width: 641px) and (max-width: 960px)" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/iphone.css" media="only screen and (max-width: 640px)" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/iphone.css" media="only screen and (max-device-width: 640px)" />
	<!-- END STYLESHEETS -->


	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="http://feeds.feedburner.com/GoMakeThings" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php wp_head(); ?>


<!-- START GOOGLE ANALYTICS -->



<!-- END GOOGLE ANALYTICS -->


<!-- DYNAMIC NAVIGATION JQUERY -->

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script>
	 // DOM ready
	 $(function() {

	   // To make dropdown actually work
      $("#top-bar-2 select").change(function() {
        window.location = $(this).find("option:selected").val();
      });
	 
	 });
	</script>


</head>

<?php
	$page = $_SERVER['REQUEST_URI'];
	$page = str_replace("/","",$page);
	$page = str_replace(".php","",$page);
	$page = $page ? $page : 'default'
?>

<body id="<?php echo $page ?>">

		<div id="top-bar-bg">
		<div id="top-bar">

			<div id="top-bar-1"><h1 id="logo"><a href="<?php echo get_option('home'); ?>/"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/ThePAW.png"> <?php bloginfo('name'); ?></a></h1></div>
			
			<div id="top-bar-2">
	
			<ul id="main-nav">
				<li class="home"><a href="<?php echo get_option('home'); ?>/">Home</a></li>
				<li class="about"><a href="<?php echo get_option('home'); ?>/about/">About</a></li>
				<li class="resources"><a href="<?php echo get_option('home'); ?>/resources/">Resources</a></li>
				<li class="blog"><a href="<?php echo get_option('home'); ?>/blog/">Blog</a></li>
				<li class="contact"><a href="<?php echo get_option('home'); ?>/contact/">Contact</a></li>
			</ul>

			<select id="drop-nav">
   				<option value="" selected="selected">Go to...</option>
				<option value="<?php echo get_option('home'); ?>/">Home</option>
				<option value="<?php echo get_option('home'); ?>/about/">About</option>
				<option value="<?php echo get_option('home'); ?>/adopt/">Adopt</option>
				<option value="<?php echo get_option('home'); ?>/donate/">Donate</option>
				<option value="<?php echo get_option('home'); ?>/volunteer/">Volunteer</option>
				<option value="<?php echo get_option('home'); ?>/resources/">Resources</option>
				<option value="<?php echo get_option('home'); ?>/blog/">Blog</option>
				<option value="<?php echo get_option('home'); ?>/contact/">Contact</option>
			</select>

			<div class="clear"></div>
			</div>

		</div>
		<div class="clear"></div>
		</div>


	<div id="page-wrap">