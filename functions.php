<?php

/* ======================================================================
	Functions.php
	For modifying and expanding core WordPress functionality.
	Remove the "#" before a function to activate it.
	Add a "#" before a function to deactivate it.
 * ====================================================================== */

// Load theme JS
function load_theme_js() {
	// Theme scripts (in footer)
	wp_register_script('paws-js', get_template_directory_uri() . '/dist/js/paws.min.08052014.js', false, null, true);
	wp_enqueue_script('paws-js');
}
add_action('wp_enqueue_scripts', 'load_theme_js');



// Init scripts
function load_our_dogs_redirect( $query ) {
	$redirectInit = '';
	$loadCSS = '<noscript><link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700"></noscript>';
	$inits =
		'astro.init();' .
		'drop.init();' .
		'fluidvids.init();' .
		'stickyFooter.init();' .
		"if ( 'querySelector' in document && 'addEventListener' in window ) { document.documentElement.className += (document.documentElement.className ? ' ' : '') + 'js'; }";
	if ( is_page('our-dogs') ) {
		$redirect = get_option('home') . '/our-dogs-list/';
		$redirectInit = '<script>setTimeout(\'window.location="' . $redirect . '"\', 500)</script>';
	}
	if ( is_page('hbo') ) {
		$inits =
			$inits .
			'houdini.init();' .
			'modals.init({ callbackAfterOpen: function ( toggle, modalID ) { document.querySelector(modalID).style.top = 0; } });';
	}
	if ( is_page('owen-fund') ) {
		$inits =
			$inits .
			'modals.init({ callbackAfterOpen: function ( toggle, modalID ) { document.querySelector(modalID).style.top = 0; } });';
	}
	if ( is_page('our-dogs-list') ) {
		$inits =
			$inits .
			'houdini.init();' .
			'petfinderSort.init();' .
			'rightHeight.init();' .
			'petfinderToggleImage.init();' .
			'formSaver.savePetName();';
	}
	if ( is_page('adoption-form') ) {
		$inits =
			$inits .
			'formSaver.init();';
	}
	if ( is_page('donate') || is_page('foster') ) {
		$inits =
			$inits .
			'smoothScroll.init();';
	}
	echo $loadCSS . '<script>' . $inits . '</script>' . $redirectInit;
}
add_action('wp_footer', 'load_our_dogs_redirect', 30);



// // WP Search Form Shortcode
// function pne_wpsearch() {
// 	$form =
// 		'<form method="get" class="no-space-bottom" id="searchform" action="' . home_url( '/' ) . '" >
// 			<label class="screen-reader" for="s">Search this site:</label>
// 			<input type="text" class="input-search" placeholder="Search this site..." value="' . get_search_query() . '" name="s" id="s">
// 			<button type="submit" class="btn-search" id="searchsubmit"><i class="icon icon-search"></i><span class="icon-text-fallback">Search</span></button>
// 		</form>';
// 	return $form;
// }
// add_shortcode( 'searchform', 'pne_wpsearch' );



// Make the `wp_title` function more useful
function paws_pretty_wp_title( $title, $sep ) {

	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name
	$title .= get_bloginfo( 'name' );

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'kraken' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'paws_pretty_wp_title', 10, 2 );



// Deactivate jQuery and Contact Form 7 styles/scripts
function paws_deactivate_cf7_scripts() {
	add_filter( 'wpcf7_load_js', '__return_false' );
	add_filter( 'wpcf7_load_css', '__return_false' );
}
add_action('init', 'paws_deactivate_cf7_scripts');



// If page has a contact form, load Contact Form 7 scripts and styles
function paws_activate_cf7_scripts() {
	if ( is_page('adoption-form') || is_page('foster') || is_page('contact') || is_page('volunteer') ) {
		add_filter( 'wpcf7_load_js', '__return_true' );
		add_filter( 'wpcf7_load_css', '__return_true' );
	}
}
add_action('pre_get_posts', 'paws_activate_cf7_scripts');

?>