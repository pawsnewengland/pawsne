<?php

/* ======================================================================
 * Search-Form-Shortcode.php
 * A PHP script and shortcode for the WordPress search form.
 * Script by Elliot Jay Stocks.
 * http://viewportindustries.com/products/starkers/
 *
 * Add a search form anywhere on your site by adding <?php echo pne_wpsearch(); ?> to a template file.
 * You can also use the [searchform] shortcode in the WordPress content editor.
 * The `.screen-reader` class hides the search form label if you're using the Kraken CSS boilerplate.
 * Add additional classes and styling as needed.
 * ====================================================================== */

function pne_wpsearch() {
    $form = '<form method="get" class="no-space-bottom" id="searchform" action="' . home_url( '/' ) . '" >
            <label class="screen-reader" for="s">Search this site:</label>
            <input type="text" class="input-search" placeholder="Search this site..." value="' . get_search_query() . '" name="s" id="s">
            <button type="submit" class="btn-search" id="searchsubmit"><i class="icon-search"></i><span class="screen-reader">Search</span></button>
        </form>';
    return $form;
}
add_shortcode( 'searchform', 'pne_wpsearch' );

?>
