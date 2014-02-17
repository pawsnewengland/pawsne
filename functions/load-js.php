<?php

/* ======================================================================

	Load JavaScript v1.0
	Load theme JavaScript file in WordPress.
	Learn more: http://codex.wordpress.org/Function_Reference/wp_register_script

 * ====================================================================== */

// Load theme JS
function load_theme_js() {
	// Feature Test (in header)
	wp_register_script('feature-test', get_template_directory_uri() . '/js/feature-test.min.11222013.js', false, null, false);
	wp_enqueue_script('feature-test');

	// Theme scripts (in footer)
	wp_register_script('pne-js', get_template_directory_uri() . '/js/pne.min.02162014.js', false, null, true);
	wp_enqueue_script('pne-js');
}
add_action('wp_enqueue_scripts', 'load_theme_js');


// Add redirect to Our Dogs page
function load_our_dogs_redirect( $query ) {
	$redirect = get_option('home') . '/our-dogs-list/';
	$timeout = 'setTimeout(\'window.location="' . $redirect . '"\', 500)';
	$script = '
		<script>
			' . $timeout . ';
		</script>';

	if (is_page('our-dogs')) {
		echo $script;
	}
}
add_action('wp_footer', 'load_our_dogs_redirect', 30);

?>