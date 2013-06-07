<?php

/* ======================================================================
 * Button-Shortcode.php
 * A PHP script and shortcode for the CSS buttons.
 * Script by Chris Ferdinandi - http://gomakethings.com
 *
 * Add a button in the content editor using the following pattern:
 * [btn url="http://wherever.com"]Click Me[/btn]
 * ====================================================================== */

function css_btn($atts) {  
    extract(shortcode_atts(array(  
        "link" => 'http://www.pawsnewengland.com/donate/',
        "label" => 'Donate'
    ), $atts));  
    return '<p><a class="btn btn-large" href="'.$link.'">' . $label . '</a></p>';  
}
add_shortcode("btn", "css_btn");

?>
