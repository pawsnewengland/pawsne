<?php

/* ======================================================================

    Load jQuery v1.0
    Load CDN-hosted jQuery, with local fallback, by Travis Smith.
    https://gist.github.com/wpsmith/4083811
    
 * ====================================================================== */

function load_cdn_jquery() {

    // Setup jQuery from Google CDN 
    $url = 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '') . '://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js';

    // Setup jQuery from WordPress
    $wpurl = get_bloginfo( 'wpurl') . '/wp-includes/js/jquery/jquery.js';

    // Deregister WordPress default jQuery
    wp_deregister_script( 'jquery' );

    // Check transient, if false, set URI to WordPress URI
    delete_transient( 'google_jquery' );
    if ( 'false' == ( $google = get_transient( 'google_jquery' ) ) ) {
        $url = $wpurl;
    }
    
    // Transient failed
    elseif ( false === $google ) {
    
        // Ping Google
        $resp = wp_remote_head( $url );

        // Use Google jQuery
        if ( ! is_wp_error( $resp ) && 200 == $resp['response']['code'] ) {
            // Set transient for 5 minutes
            set_transient( 'google_jquery', 'true', 60 * 5 );
        } 

        // Use WordPress jQuery
        else {
            // Set transient for 5 minutes
            set_transient( 'google_jquery', 'false', 60 * 5 );

            // Use WordPress URI
            $url = $wpurl;
        }
        
    }

    // Register surefire jQuery
    wp_register_script( 'jquery', $url, array(), null, true );

    // Enqueue jQuery
    wp_enqueue_script( 'jquery' );

}
add_action('wp_enqueue_scripts', 'load_cdn_jquery');

?>
