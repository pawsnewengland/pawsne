<?php

/* ======================================================================
 * Load-JS.php
 * Load external JavaScript files in WordPress.
 * Remove jQuery if you're not using it.
 * Learn more: http://codex.wordpress.org/Function_Reference/wp_register_script
 * ====================================================================== */

function my_scripts_method() {

    // Replace built-in jQuery with CDN-hosted version
	wp_deregister_script('jquery');
	wp_register_script('jquery', 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '') . '://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js', false, null, true);
	wp_enqueue_script('jquery');

    // Register and load Kraken.js
	wp_register_script('pne-js', get_template_directory_uri() . '/js/pne.min.03272013.js', false, null, true);
	wp_enqueue_script('pne-js');

}
add_action('wp_enqueue_scripts', 'my_scripts_method');

?>
