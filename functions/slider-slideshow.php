<?php

/* ======================================================================
    Slider v3.3

    Script by Brad Birdsall.
    http://swipejs.com/

    Forked by Chris Ferdinandi.
    http://gomakethings.com

    Code contributed by Ron Ilan.
    https://github.com/bradbirdsall/Swipe/pull/277#issuecomment-26032132
 * ====================================================================== */

// Create slider shortcode
function slider_slideshow() {

	global $post;
	$post_id = $post->ID;

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
	$slideshow = '<div class="row">
                    <div class="grid-half">
	                   <p class="no-space-bottom" id="slide-nav-' . $post_id . '"></p>
                    </div>
                    <div class="grid-half text-right">
	                   <p class="space-bottom-small" id="slide-count-' . $post_id . '"></p>
                    </div>
                  </div>
				  <div class="slider" data-slider="' . $post_id . '">
                    <div class="slides">';

	$i = 0;

	foreach ( $attachments as $attachment ) {
	    // Get image
        $flex_img = wp_get_attachment_image( $attachment->ID, $size, false );
		// Insert image into list item
		$slideshow .= '<div>' . $flex_img . '</div>';
	}

    // End slideshow wrapper
	$slideshow .=   '</div>
                  </div>';

	return apply_filters( 'slideshow_shortcode', $slideshow );

}
add_shortcode( 'slideshow', 'slider_slideshow' );

// Add script to footer
function slider_add_init_script( $query ) {
	$script = "
		<script>
			(function() {

				'use strict';

				if ( 'querySelector' in document && 'addEventListener' in window && Array.prototype.forEach ) {

			        // Slider Variable
			        var sliders = document.querySelectorAll('.slider');

			        // If a Slider exists
			        if (sliders) {

			        	[].forEach.call(sliders, function (slider) {

			        		var sliderID = slider.getAttribute('data-slider');

			        		// Activate Slider
			        		window[sliderID] = Swipe(slider, {
			        		    // Configure your options
			        		    continuous: true,
			        		    callback: function(index, elem) {
			        		        // Update with new position on slide change
			        		        countSlides();
			        		    }
			        		});


			        		// Function to display slide count
			        		var countSlides = function () {
			        		    // Variables
			        		    var slideTotal = window[sliderID].getNumSlides();
			        		    var slideCurrent = window[sliderID].getPos();
			        		    var slideCount = document.querySelector('#slide-count-' + sliderID);
			        		    // Content
			        		    if (slideCount) {
			        		        slideCount.innerHTML = slideCurrent + ' of ' + slideTotal;
			        		    }
			        		}
			        		// Run slide count function on load
			        		countSlides();


			        		// Create Previous & Next Buttons
			        		var slideNav = document.querySelector('#slide-nav-' + sliderID)
			        		if (slideNav) {
			        		    slideNav.innerHTML = '<a id=\"slide-nav-prev-' + sliderID + '\" href=\"#\">Previous</a> | <a id=\"slide-nav-next-' + sliderID + '\" href=\"#\">Next</a>';
			        		}

			        		// Toggle Previous & Next Buttons
			        		var btnNext = document.querySelector('#slide-nav-next-' + sliderID);
			        		var btnPrev = document.querySelector('#slide-nav-prev-' + sliderID);
			        		if (btnNext) {
			        		    btnNext.addEventListener('click', function(e) { e.preventDefault(); window[sliderID].next(); }, false);
			        		}
			        		if (btnPrev) {
			        		    btnPrev.addEventListener('click', function(e) { e.preventDefault(); window[sliderID].prev(); }, false);
			        		}


			        		// Toggle Left & Right Keypress
			        		window.addEventListener('keydown', function (e) {
			        		    if (e.keyCode == 37) {
			        		        window[sliderID].prev();
			        		    }
			        		    if (e.keyCode == 39) {
			        		        window[sliderID].next();
			        		    }
			        		}, false);

			        	});

			        }

			    }

			})();
		</script>";
	echo $script;
}
add_action('wp_footer', 'slider_add_init_script', 30);

?>