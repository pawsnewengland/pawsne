<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
	
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/images/PAWS.ico" />

<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/style.css" type="text/css" media="screen" />

<!-- DON'T TOUCH THIS -->	<!--<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />-->


	<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/style-ie6.css" />
	<![endif]-->


	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!-- JQUERY SCRIPT -->
<!--
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.easing.1.2.js"></script>
	<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.anythingslider.js" type="text/javascript" charset="utf-8"></script>

    <script type="text/javascript">
    
        function formatText(index, panel) {
		  return index + "";
	    }
    
        $(function () {
        
            $('.anythingSlider').anythingSlider({
                easing: "easeInOutExpo",        // Anything other than "linear" or "swing" requires the easing plugin
                autoPlay: true,                 // This turns off the entire FUNCTIONALY, not just if it starts running or not.
                delay: 9000,                    // How long between slide transitions in AutoPlay mode
                startStopped: false,            // If autoPlay is on, this can force it to start stopped
                animationTime: 600,             // How long the slide transition takes
                hashTags: true,                 // Should links change the hashtag in the URL?
                buildNavigation: true,          // If true, builds and list of anchor links to link to each slide
        		pauseOnHover: true,             // If true, and autoPlay is enabled, the show will pause on hover
        		startText: "Go",             // Start text
		        stopText: "Stop",               // Stop text
		        navigationFormatter: formatText       // Details at the top of the file on this use (advanced use)
            });
            
            $("#slide-jump").click(function(){
                $('.anythingSlider').anythingSlider(6);
            });
            
        });
    </script>
-->

<!-- END JQUERY SCRIPT -->

	
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

<a href="<?php echo get_option('home'); ?>/"><h1 id="logo"><?php bloginfo('name'); ?></h1></a>

<div class="clear"></div>

</div>


<div id="menu-bar">

<ul id="nav">
	<li class="home"><a href="<?php echo get_option('home'); ?>/contact/">Contact</a></li>
	<li class="home"><a href="<?php echo get_option('home'); ?>/resources/">Resources</a></li>
	<li class="home"><a href="<?php echo get_option('home'); ?>/news/">News</a></li>
	<li class="home"><a href="<?php echo get_option('home'); ?>/adopt/">Adopt</a></li>
	<li class="home"><a href="<?php echo get_option('home'); ?>/about/">About Us</a></li>
	<li class="home"><a href="<?php echo get_option('home'); ?>/">Home</a></li>
</ul>

<div class="clear"></div>

</div>

</div>