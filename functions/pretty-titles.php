<?php

/* ======================================================================
    Pretty Title v1.0
    Create pretty <title> elements.
 * ====================================================================== */

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