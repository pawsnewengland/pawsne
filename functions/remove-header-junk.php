<?php

/* ======================================================================
 * Remove-Header-Junk.php
 * Removes unneccessary junk WordPress adds to the header.
 * Script by ThemeLab.
 * http://www.themelab.com/2010/07/11/remove-code-wordpress-header/
 * ====================================================================== */

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');

?>
