<?php

/* ======================================================================

    Load JavaScript v1.0
    Load theme JavaScript file in WordPress.
    Learn more: http://codex.wordpress.org/Function_Reference/wp_register_script

 * ====================================================================== */

function load_theme_js() {
	// Feature Test (in header)
	wp_register_script('feature-test', get_template_directory_uri() . '/js/feature-test.js', false, null, false);
	wp_enqueue_script('feature-test');

	// Theme scripts (in footer)
	wp_register_script('pne-js', get_template_directory_uri() . '/js/pne.js', false, null, true);
	wp_enqueue_script('pne-js');
}
add_action('wp_enqueue_scripts', 'load_theme_js');

?>
