<?php

/* ======================================================================
    Functions.php
    For modifying and expanding core WordPress functionality.
    Remove the "#" before a function to activate it.
    Add a "#" before a function to deactivate it.
 * ====================================================================== */

// Load theme JS
function load_theme_js() {
	// Feature Test (in header)
	wp_register_script('feature-test', get_template_directory_uri() . '/js/feature-test.min.03302014.js', false, null, false);
	wp_enqueue_script('feature-test');

	// Theme scripts (in footer)
	wp_register_script('pne-js', get_template_directory_uri() . '/js/pne.min.05302014.js', false, null, true);
	wp_enqueue_script('pne-js');
}
add_action('wp_enqueue_scripts', 'load_theme_js');



// Add redirect to Our Dogs page
function load_our_dogs_redirect( $query ) {
	$scripts = '<script>stickyFooter.init()</script>';
	if (is_page('our-dogs')) {
		$redirect = get_option('home') . '/our-dogs-list/';
		$scripts = $scripts . '<script>setTimeout(\'window.location="' . $redirect . '"\', 500)</script>';
	}
	echo $scripts;
}
add_action('wp_footer', 'load_our_dogs_redirect', 30);



// WP Search Form Shortcode
function pne_wpsearch() {
    $form =
    	'<form method="get" class="no-space-bottom" id="searchform" action="' . home_url( '/' ) . '" >
            <label class="screen-reader" for="s">Search this site:</label>
            <input type="text" class="input-search" placeholder="Search this site..." value="' . get_search_query() . '" name="s" id="s">
            <button type="submit" class="btn-search" id="searchsubmit"><i class="icon-search"></i><span class="screen-reader">Search</span></button>
        </form>';
    return $form;
}
add_shortcode( 'searchform', 'pne_wpsearch' );



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

?>