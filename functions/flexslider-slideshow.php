<?php

/* ======================================================================
 * Flexslider-Slideshow.php
 * An image slider shortcode.
 * Function code by DevPress - http://devpress.com/plugins/slideshow
 * CSS and script by by WooThemes - https://github.com/cferdinandi/FlexSlider
 * Rebounded by Chris Ferdinandi - http://gomakethings.com
 * ====================================================================== */

function flexslider_slideshow() {

	global $post;

	// Set up the defaults for the slideshow shortcode.
	$defaults = array(
		'order' => 'ASC',
		'orderby' => 'menu_order ID',
		'id' => $post->ID,
		'size' => 'large',
		'include' => '',
		'exclude' => '',
		'numberposts' => -1,
	);
	$attr = shortcode_atts( $defaults, $attr );

	// Allow users to overwrite the default args.
	extract( apply_filters( 'slideshow_shortcode_args', $attr ) );

	// Arguments for get_children().
	$children = array(
		'post_parent' => intval( $id ),
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'order' => $order,
		'orderby' => $orderby,
		'exclude' => absint( $exclude ),
		'include' => absint( $include ),
		'numberposts' => intval( $numberposts ),
	);

	// Get image attachments. If none, return.
	$attachments = get_children( $children );

	if ( empty( $attachments ) )
		return '';

	// If is feed, leave the default WP settings. We're only worried about on-site presentation.
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link( $id, $size, true ) . "\n";
		return $output;
	}

    // Slideshow wrapper
	$slideshow = '<div class="flexslider">
                    <ul class="slides">';

	$i = 0;

	foreach ( $attachments as $attachment ) {
	    // Get image
        $flex_img = wp_get_attachment_image( $attachment->ID, $size, false );
		// Insert image into list item
		$slideshow .= '<li>' . $flex_img . '</li>';
	}

    // End slideshow wrapper
	$slideshow .=   '</ul>
                  </div>';

	return apply_filters( 'slideshow_shortcode', $slideshow );

}

add_shortcode( 'slideshow', 'flexslider_slideshow' );

?>
