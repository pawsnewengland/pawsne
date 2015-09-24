<!DOCTYPE html>
<!-- Conditional class for older versions of IE -->
<!--[if lt IE 9 & !IEMobile]><html class="ie" lang="en" id="top"><![endif]-->
<!--[if gt IE 8 | IEMobile]><!--><html lang="en" id="top"><!--<![endif]-->

	<head>
		<!-- Meta Info -->
		<meta charset="<?php bloginfo('charset'); ?>">

		<!-- Force latest available IE rendering engine and Chrome Frame (if installed) -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<!-- Smart Titles -->
		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<!-- Add a description on the homepage -->
		<?php if (is_home ()) : ?><meta name="description" content="<?php bloginfo('description'); ?>"><?php endif; ?>

		<!-- Mobile Screen Resizing -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Icons: place in the root directory -->
		<!-- https://github.com/audreyr/favicon-cheat-sheet -->
		<link rel="shortcut icon" type="image/ico" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/favicon.ico">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('stylesheet_directory'); ?>/dist/img/apple-touch-icon-144.png">
		<meta name="msapplication-TileColor" content="#6aa120">
		<meta name="msapplication-TileImage" content="<?php bloginfo('stylesheet_directory'); ?>/dist/img/ms-touch-icon.png">

		<!-- Feeds & Pings -->
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="http://feeds.feedburner.com/pawsne">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<!-- HTML5 Shim for IE 6-8 -->
		<!--[if lt IE 9]>
			<script src="<?php bloginfo('stylesheet_directory'); ?>/dist/js/html5.min.js"></script>
		<![endif]-->

		<!-- Browser Detects -->
		<script src="<?php bloginfo('stylesheet_directory'); ?>/dist/js/detects.min.08072014.js"></script>

		<!-- Stylesheet -->
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/dist/css/pawsne.min.08072014.css">
		<script>
			var loadCSS = function (e,t,n){"use strict";var i=window.document.createElement("link");var o=t||window.document.getElementsByTagName("script")[0];i.rel="stylesheet";i.href=e;i.media="only x";o.parentNode.insertBefore(i,o);setTimeout(function(){i.media=n||"all"})};
			loadCSS( "http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700" );
		</script>

		<?php wp_head(); ?>

	</head>

	<body>

		<!-- Old Browser Warning for IE 6-7 -->
		<!--[if lt IE 9]>
			<div class="container">
				<span class="text-small text-muted">Did you know that your web browser is a bit old? Some of the content on this site might not work right as a result. <a href="http://whatbrowser.org">Upgrade your browser</a> for a faster, better, and safer web experience.</span>
			</div>
		<![endif]-->

		<div data-sticky-wrap>

			<!-- Skip link for better accessibility -->
			<a class="screen-reader" href="#main">Skip to main content</a>

			<?php get_template_part( 'nav-main', 'Site Navigation' ); ?>

			<section class="container space-bottom-big" id="main">