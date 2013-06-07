<?php

/* ======================================================================
    Functions.php
    For modifying and expanding core WordPress functionality.
    Remove the "#" before a function to activate it.
    Add a "#" before a function to deactivate it.
 * ====================================================================== */

require_once('functions/load-js.php'); // Load external JS files
require_once('functions/search-form-shortcode.php'); // Shortcode for the WordPress search form
require_once('functions/button-shortcode.php'); // Shortcode to add donate buttons (and more)
require_once('functions/flexslider-slideshow.php'); // Shortcode for flexslider slideshows
require_once('functions/image-url-default.php'); // Overrides default image-URL behavior
require_once('functions/disable-inline-styles.php'); // Removes inline styles and other coding junk added by the WYSIWYG editor
require_once('functions/remove-header-junk.php'); // Removes unneccessary junk WordPress adds to the header
require_once('functions/remove-trackbacks-from-comments.php'); // Remove trackbacks from WordPress comments
require_once('functions/petfinder-api.php'); // Add PetFinder listings to the site
#require_once('functions/shoporific.php'); // A simple PayPal shopping cart

?>
