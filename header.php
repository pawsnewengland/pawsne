<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
	
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/paws-favicon.ico" />
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

	<!--[if IE]
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/style-ie6.css" />
	[endif]-->


	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<?php wp_head(); ?>

</head>

<?php
	$page = $_SERVER['REQUEST_URI'];
	$page = str_replace("/","",$page);
	$page = str_replace(".php","",$page);
	$page = $page ? $page : 'default'
?>

<body id="<?php echo $page ?>">

<div id="page-wrap">

<div id="header">

<div id="logo">

<a href="<?php echo get_option('home'); ?>/"><h1><img src="<?php bloginfo('stylesheet_directory'); ?>/images/PAWS-Logo.png" alt="PAWS New England"></h1></a>

<div class="clear"></div>

</div>


<div id="menu-bar">

<ul id="nav">
	<li class="contact"><a href="<?php echo get_option('home'); ?>/contact/">Contact</a></li>
	<li class="resources"><a href="<?php echo get_option('home'); ?>/resources/">Resources</a></li>
	<li class="news"><a href="<?php echo get_option('home'); ?>/news/">News</a></li>
	<li class="help"><a href="<?php echo get_option('home'); ?>/help/">Get Involved</a></li>
	<li class="donate"><a href="<?php echo get_option('home'); ?>/donate/">Donate</a></li>
	<li class="adopt"><a href="<?php echo get_option('home'); ?>/adopt/">Adopt</a></li>
	<li class="about"><a href="<?php echo get_option('home'); ?>/about/">Our Story</a></li>
</ul>

<div class="clear"></div>

</div>

</div>