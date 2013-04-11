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
	    <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' |'; } ?> <?php bloginfo('name'); ?></title>

	    <!-- Add a description on the homepage -->
	    <?php if (is_home ()) : ?><meta name="description" content="<?php bloginfo('description'); ?>"><?php endif; ?>

        <!-- Preferred page URL for search engines -->
	    <link rel="canonical" href="<?php the_permalink() ?>">
	
	    <!-- Mobile Screen Resizing -->
	    <meta name="viewport" content="width=device-width, initial-scale=1">


	    <!-- Stylesheet -->
	    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/style.min.04102013.css">

        <!-- HTML5 Shim for IE 6-8 -->
	    <!--[if lt IE 9]>    
		    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	    <![endif]-->


	    <!-- Favicon -->
	    <link rel="shortcut icon" type="image/ico" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon.ico">

	    <!-- Apple Touch Icons -->
	    <link rel="apple-touch-icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/apple-touch-icon.png">
	    <link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('stylesheet_directory'); ?>/img/apple-touch-icon-72.png">
	    <link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('stylesheet_directory'); ?>/img/apple-touch-icon-114.png">
	    <link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('stylesheet_directory'); ?>/img/apple-touch-icon-144.png">

        <!-- MS Homescreen Icons -->
        <meta name="msapplication-TileColor" content="#0088cc">
        <meta name="msapplication-TileImage" content="<?php bloginfo('stylesheet_directory'); ?>/img/ms-touch-icon.png">

	    <!-- Feeds & Pings -->
	    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="http://feeds.feedburner.com/pawsne">
	    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	
	    <?php wp_head(); ?>

    </head>

    <body>

        <!-- Old Browser Warning for IE 6-7 -->
        <!--[if lt IE 8]>
            <div class="container">
                <span class="text-small text-muted">Did you know that your web browser is a bit old? Some of the content on this site might not work right as a result. <a href="http://whatbrowser.org">Upgrade your browser</a> for a faster, better, and safer web experience.</span>
            </div>
        <![endif]-->

        <div class="nav-bg">
            <nav class="nav-wrap container">
                <a class="logo" href="<?php echo get_option('home'); ?>/"><i class="icon-logo"></i> PAWS New England</a>
                <a class="btn nav-toggle" href="#nav-menu">
                    <i class="icon-bar"></i>
                    <i class="icon-bar"></i>
                    <i class="icon-bar"></i>
                    <span class="screen-reader">Menu Toggle</span>
                </a>
                <div class="nav-collapse" id="nav-menu">
                    <ul class="nav group">
                        <li><a href="<?php echo get_option('home'); ?>/">Home</a></li>
                        <li class="dropdown">
                            <a href="<?php echo get_option('home'); ?>/about/">About</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a href="<?php echo get_option('home'); ?>/about/">Our Story</a></li>
                                    <li><a href="<?php echo get_option('home'); ?>/hbo/">HBO Special</a></li>
                                    <li><a href="<?php echo get_option('home'); ?>/contact/">Contact</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="<?php echo get_option('home'); ?>/adopt/">Adopt</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a href="<?php echo get_option('home'); ?>/adopt/">The Process</a></li>
                                    <li><a href="<?php echo get_option('home'); ?>/our-dogs/">Our Dogs</a></li>
                                    <li><a href="<?php echo get_option('home'); ?>/adoption-form/">Adoption Form</a></li>
                                    <li><a href="<?php echo get_option('home'); ?>/resources/">Resources</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="<?php echo get_option('home'); ?>/help/">How to Help</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a href="<?php echo get_option('home'); ?>/donate/">Donate</a></li>
                                    <li><a href="<?php echo get_option('home'); ?>/volunteer/">Volunteer</a></li>
                                    <li><a href="<?php echo get_option('home'); ?>/paws-harness-program/">Buy a Harness</a></li>
                                    <li><a href="<?php echo get_option('home'); ?>/paws-partners/">Support Our Partners</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="<?php echo get_option('home'); ?>/news/">Blog</a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <?php if ( is_page('store') || $post->post_parent == '921' ) : ?>
            <!-- Shop Navigation -->
            <div class="cart-bg">
                <div class="container text-right">
                    <a class="collapse-toggle" href="#cart"><i class="icon-cart"></i> Cart (<?php echo checkout_cart_count(); ?>)</a>
                </div>
                <div class="collapse <?php echo checkout_cart_active(); ?>" id="cart">
                    <div class="container space-top">
                        <?php echo checkout_cart(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>


	    <section class="container space-bottom-big">
