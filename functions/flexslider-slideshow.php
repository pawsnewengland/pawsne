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
	$slideshow = '<div class="slider">
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
                  </div>
                  <div class="row">
                    <div class="grid-half">
	                   <p class="slide-nav no-space-bottom"></p>
                    </div>
                    <div class="grid-half text-right">
	                   <p class="slide-count"></p>
                    </div>
                  </div>';

	return apply_filters( 'slideshow_shortcode', $slideshow );

}
add_shortcode( 'slideshow', 'slider_slideshow' );

// Add script to footer
function slider_add_init_script( $query ) {
	$script = "
		<script>
			if ( 'querySelector' in document && 'addEventListener' in window && Array.prototype.forEach ) {

		        // Slider Variable
		        var slider = document.querySelector('.slider');

		        // If a Slider exists
		        if (slider) {

		            // Activate Slider
		            window.mySwipe = Swipe(slider, {
		                // Configure your options
		                // startSlide: 1,
		                // speed: 400,
		                // auto: 3000,
		                continuous: true,
		                // disableScroll: false,
		                // stopPropagation: false,
		                callback: function(index, elem) {
		                    // Update with new position on slide change
		                    countSlides();
		                },
		                // transitionEnd: function(index, elem) {}
		            });


		            // Function to display slide count
		            var countSlides = function () {
		                // Variables
		                var slideTotal = mySwipe.getNumSlides();
		                var slideCurrent = mySwipe.getPos();
		                var slideCount = document.querySelector('.slide-count');
		                // Content
		                if (slideCount) {
		                    slideCount.innerHTML = slideCurrent + ' of ' + slideTotal;
		                }
		            }
		            // Run slide count function on load
		            countSlides();


		            // Create Previous & Next Buttons
		            var slideNav = document.querySelector('.slide-nav')
		            if (slideNav) {
		                slideNav.innerHTML = '<a class=\"slide-nav-prev\" href=\"#\">Previous</a> | <a class=\"slide-nav-next\" href=\"#\">Next</a>';
		            }

		            // Toggle Previous & Next Buttons
		            var btnNext = document.querySelector('.slide-nav-next');
		            var btnPrev = document.querySelector('.slide-nav-prev');
		            if (btnNext) {
		                btnNext.addEventListener('click', function(e) { e.preventDefault(); mySwipe.next(); }, false);
		            }
		            if (btnPrev) {
		                btnPrev.addEventListener('click', function(e) { e.preventDefault(); mySwipe.prev(); }, false);
		            }


		            // Toggle Left & Right Keypress
		            window.addEventListener('keydown', function (e) {
		                if (e.keyCode == 37) {
		                    mySwipe.prev();
		                }
		                if (e.keyCode == 39) {
		                    mySwipe.next();
		                }
		            }, false);

		        }

		    }
		</script>";
	echo $script;
}
add_action('wp_footer', 'slider_add_init_script', 30);

?>
