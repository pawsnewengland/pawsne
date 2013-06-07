<?php

/* ======================================================================
 * Disable-Inline-Styles.php
 * Removes inline styles and other coding junk added by the WYSIWYG editor.
 * Script by Chris Ferdinandi - http://gomakethings.com
 * ====================================================================== */

add_filter( 'the_content', 'clean_post_content' );
function clean_post_content($content) {

    if ( is_single() || is_home() ) {

        // Remove inline styling
        $content = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $content);

        // Remove font tag
        $content = preg_replace('/<font[^>]+>/', '', $content);

        // Remove empty tags
        $post_cleaners = array('<p></p>' => '', '<p> </p>' => '', '<p>&nbsp;</p>' => '', '<span></span>' => '', '<span> </span>' => '', '<span>&nbsp;</span>' => '', '<span>' => '', '</span>' => '', '<font>' => '', '</font>' => '');
        $content = strtr($content, $post_cleaners);

    }

    return $content;
}

?>
