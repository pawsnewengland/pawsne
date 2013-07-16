<?php

/* ======================================================================

    Load JavaScript v1.0
    Load external JavaScript files in WordPress.
    Learn more: http://codex.wordpress.org/Function_Reference/wp_register_script
    
 * ====================================================================== */


/* ======================================================================
    LOAD JQUERY
    Load jQuery from Google CDN, with local version as a fallback.
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





/* ======================================================================
    LOAD THEME SCRIPTS
    Load theme-specific javascript.
* ====================================================================== */

function load_theme_js() {

    // Register and load theme JS
	wp_register_script('pne-js', get_template_directory_uri() . '/js/pne.min.07162013.js', false, null, true);
	wp_enqueue_script('pne-js');

}
add_action('wp_enqueue_scripts', 'load_theme_js');

?>
