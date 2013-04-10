<?php // Don't delete this line or you'll break WordPress


/* ======================================================================
 * External-JS-File.php
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





/* ======================================================================
 * Flexslider.php
 * An image slider shortcode.
 * Function code by DevPress - http://devpress.com/plugins/slideshow
 * CSS and script by by WooThemes - https://github.com/cferdinandi/FlexSlider
 * Rebounded by Chris Ferdinandi - http://gomakethings.com
 * ====================================================================== */

function flexslider_slideshow() {

	global $post;

	// Set up the defaults for the slideshow shortcode.
	$defaults = array(
		'order' => 'ASC',
		'orderby' => 'menu_order ID',
		'id' => $post->ID,
		'size' => 'large',
		'include' => '',
		'exclude' => '',
		'numberposts' => -1,
	);
	$attr = shortcode_atts( $defaults, $attr );

	// Allow users to overwrite the default args.
	extract( apply_filters( 'slideshow_shortcode_args', $attr ) );

	// Arguments for get_children().
	$children = array(
		'post_parent' => intval( $id ),
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'order' => $order,
		'orderby' => $orderby,
		'exclude' => absint( $exclude ),
		'include' => absint( $include ),
		'numberposts' => intval( $numberposts ),
	);

	// Get image attachments. If none, return.
	$attachments = get_children( $children );

	if ( empty( $attachments ) )
		return '';

	// If is feed, leave the default WP settings. We're only worried about on-site presentation.
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link( $id, $size, true ) . "\n";
		return $output;
	}

    // Slideshow wrapper
	$slideshow = '<div class="flexslider">
                    <ul class="slides">';

	$i = 0;

	foreach ( $attachments as $attachment ) {
	    // Get image
        $flex_img = wp_get_attachment_image( $attachment->ID, $size, false );
		// Insert image into list item
		$slideshow .= '<li>' . $flex_img . '</li>';
	}

    // End slideshow wrapper
	$slideshow .=   '</ul>
                  </div>';

	return apply_filters( 'slideshow_shortcode', $slideshow );

}

add_shortcode( 'slideshow', 'flexslider_slideshow' );





/* ======================================================================
 * Image-URL-Default.php
 * Overrides default image-URL behavior
 * http://wordpress.org/support/topic/insert-image-default-to-no-link
 * ====================================================================== */

update_option('image_default_link_type','none');





/* ======================================================================
 * Disable-Inline-Styles.php
 * Removes inline styles and other coding junk added by the WYSIWYG editor.
 * Script by Chris Ferdinandi - http://gomakethings.com
 * ====================================================================== */

add_filter( 'the_content', 'clean_post_content' );
function clean_post_content($content) {

    // Remove inline styling
    $content = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $content);

    // Remove font tag
    $content = preg_replace('/<font[^>]+>/', '', $content);

    // Remove empty tags
    $post_cleaners = array('<p></p>' => '', '<p> </p>' => '', '<p>&nbsp;</p>' => '', '<span></span>' => '', '<span> </span>' => '', '<span>&nbsp;</span>' => '', '<span>' => '', '</span>' => '', '<font>' => '', '</font>' => '');
    $content = strtr($content, $post_cleaners);

    return $content;
}





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





/* ======================================================================
 * Remove-Trackbacks-From-Comments.php
 * A simple function to remove trackbacks from WordPress comments.
 * Script by Weblog Tools Collection.
 * http://weblogtoolscollection.com/archives/2008/03/08/managing-trackbacks-and-pingbacks-in-your-wordpress-theme/
 * ====================================================================== */

add_filter('comments_array', 'filterTrackbacks', 0);
add_filter('the_posts', 'filterPostComments', 0);
//Updates the comment number for posts with trackbacks
function filterPostComments($posts) {
    foreach ($posts as $key => $p) {
        if ($p->comment_count <= 0) { return $posts; }
        $comments = get_approved_comments((int)$p->ID);
        $comments = array_filter($comments, "stripTrackback");
        $posts[$key]->comment_count = sizeof($comments);
    }
    return $posts;
}
//Updates the count for comments and trackbacks
function filterTrackbacks($comms) {
global $comments, $trackbacks;
    $comments = array_filter($comms,"stripTrackback");
    return $comments;
}
//Strips out trackbacks/pingbacks
function stripTrackback($var) {
    if ($var->comment_type == 'trackback' || $var->comment_type == 'pingback') { return false; }
    return true;
}





/* ======================================================================
 * Shop-o-Rific.php
 * A simple PayPal shopping cart plugin for WordPress.
 * Script by Chris Ferdinandi - http://gomakethings.com
 * ====================================================================== */

// VARIABLES

// PayPal Account
$paypal_account = 'paypal@pawsnewengland.com';

// Define image directory
$img_directory = get_template_directory_uri() . '/img/';

// Get current page URL
$url_current  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
$url_current .= ( $_SERVER["SERVER_PORT"] !== 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
$url_current .= $_SERVER["REQUEST_URI"];

// Remove URL metadata
$url_clean = array_shift( explode('?', $url_current) );

// Define "Cart Updated" URL
$url_update = $url_clean . '?cart-updated';

// Define "Checkout Success" URL
$url_success = $url_clean . '?checkout-success';

// Checkout Cart Active Class
function checkout_cart_active() {

    // Variables
    $checkout_cart_active = '';
    global $url_current, $url_update, $url_success;
    
    if ( $url_current == $url_update || $url_current == $url_success ) {
        $checkout_cart_active = 'active';
    }

    return $checkout_cart_active;
    
}





// FUNCTIONS

// Start browsing session (for data storage)
if(!isset($_SESSION)) {
	session_start();
}



// "Add to Cart" Button
function add_to_cart($atts) {

    // Set and get product variables
    extract(shortcode_atts(array(  
        'label' => 'Add to Cart',
        'product' => '',
        'price' => 0,
        'options' => '',
        'sold' => ''
    ), $atts));

    // If options exist...
    $option_form = '';
    if ( $options != '' ) {

        // Options Variables
        $option_title = array_shift(explode('=', $options));
        $option_variables = strstr( $options, '=' );
        $option_variables = str_replace( '=', '', $option_variables);
        $option_variables = explode( '|', $option_variables);

        // Create form element for each product option
        $option_form_items = '';
        foreach ($option_variables as $variable) {
            $option_form_items .= '<option value="' . $variable . '">' . $variable . '</option>';
        }

        // Drop options into a form select element
        $option_form = '
            <legend>' . $option_title . '</legend>
            <p class="no-space">
                <select name="product_option" class="input-inline">
                    ' . $option_form_items . '
                </select>
            </p>
        ';
    }

    // "Add to Cart" Form/Button
    if ( $sold == '' ) {
        $add_to_cart = '
            <form action="" method="post">
                <input type="hidden" name="product_id" value="' . $product . '">
                <input type="hidden" name="product_price" value="' . $price . '">
                <input type="hidden" name="product_url" value="' . $url_current . '">
                ' . $option_form . '
                <input type="hidden" name="add-to-cart" value="add-to-cart">
                <p><button type="submit" class="btn">' . $label . '</button></p>
            </form>
        ';
    }

    // If item is sold out, disable "Add to Cart" button
    else {
        $add_to_cart = $option_form . '<p><button type="submit" class="btn btn-disabled">' . $sold . '</button></p>';
    }

    // Show "Add to Cart" Button
    return $add_to_cart;
    
}
add_shortcode("add_to_cart", "add_to_cart");



// "Add to Cart" Action
if ($_POST['add-to-cart'] ) {

    // Set product variables
    $prod_name = $_POST['product_id'];
    $prod_price = $_POST['product_price'];
    $prod_option = $_POST['product_option'];
    $prod_url = $url_current;

    // If product options exist
    if ($prod_option != '') {
        // Append selected options to product name
        $prod_name = $prod_name . ' ' . $prod_option;
    }

    // Cleanup product name and set as ID
    $prod_name = stripslashes($prod_name);
    $prod_name_cleanup = array('&' => 'and', '%' => 'Percent');
    $prod_name = strtr($prod_name, $prod_name_cleanup);
    $prod_id_cleanup = array(' ' => '_', '\'' => '', '"' => '');
    $prod_id = strtr($prod_name, $prod_id_cleanup);

    // If shopping cart session doesn't exist, create one
    if ( !isset($_SESSION['shopping_cart']) ) {
        $_SESSION['shopping_cart'] = array();
    }

    // If product isn't stored in session, add it
    if ( !isset($_SESSION['shopping_cart'][$prod_id]) ) {
        $_SESSION['shopping_cart'][$prod_id] = array(
            'product_id' => $prod_id,
            'product_name' => $prod_name,
            'product_price' => $prod_price,
            'product_quantity' => 1,
            'product_url' => $url_clean
        );
    }

    // If product is already stored in session, update quantity by one
    else {
        $_SESSION['shopping_cart'][$prod_id]['product_quantity'] = $_SESSION['shopping_cart'][$prod_id]['product_quantity']+1;
    }

    // Redirect page to prevent duplicate "add to cart" on page refresh
    header('Location:' . $url_update);
    exit();
     
}



// Checkout Cart
function checkout_cart() {  

    // Checkout Cart Variables
    $checkout_cart = '';
    $checkout_cart_count = 0;
    $checkout_cart_subtotal = 0;
    global $paypal_account, $url_current, $url_success, $img_directory;

    // If shopping cart session exists...
    if ( isset($_SESSION['shopping_cart']) ) {
    
        // For each item in shopping cart...
	    foreach($_SESSION['shopping_cart'] as $item) {

	        // Define shopping cart variables
            $item_id = $item['product_id'];
            $item_name = $item['product_name'];
            $item_price = $item['product_price'];
            $item_quantity = $item['product_quantity'];
            $item_url = $item['product_url'];
            $item_total_cost = $item_price * $item_quantity;
            $checkout_cart_subtotal += $item_total_cost;

            // Remove from Cart Button
            $remove_from_cart = '<a class="close close-cart" href="?action=remove-from-cart&id=' . $item_id . '">x <span class="screen-reader">remove from cart</span></a>';

            // Item Quantity Form Element
            $item_quantity_form = '<input type="text" name="' . $item_id . '" value="' . $item_quantity . '" class="input-condensed text-center input-inline" style="width: 4em;">';

            // Add quantity to count of items in cart
            $checkout_cart_count += $item_quantity;

            // Create table row for product in cart
            $checkout_cart_content .= '
                <tr>
                    <td class="text-left">
                        <a href="' . $item_url . '">' . $item_name . '</a><br>
                        <span class="text-muted text-small">$' . $item_price . '</span>
                    </td>
                    <td style="width: 4em;">' . $item_quantity_form . '</td>
                    <td>$' . $item_total_cost . '</td>
                    <td>' . $remove_from_cart . '</td>
                </tr>
            ';

            // Create table row for product for purchase summary
            $checkout_cart_complete .= '
                <tr>
                    <td class="text-left">
                        <a href="' . $item_url . '">' . $item_name . '</a><br>
                        <span class="text-muted text-small">$' . $item_price . '</span>
                    </td>
                    <td style="width: 4em;">' . $item_quantity . '</td>
                    <td>$' . $item_total_cost . '</td>
                </tr>
            ';
	    }

        // Product shipping variables
        $checkout_cart_shipping = 5;
        if ($checkout_cart_subtotal > 20) {
            $checkout_cart_shipping = 10;
        }
        if ($checkout_cart_subtotal > 50) {
            $checkout_cart_shipping = 20;
        }

        // Cart total variable
        $checkout_cart_total = $checkout_cart_subtotal + $checkout_cart_shipping;

        // Checkout cart form
        $checkout_cart = '
            <form action="" method="post">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th class="text-left">Item</th>
                            <th style="width: 4em;">#</th>
                            <th>Price</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>' . $checkout_cart_content . '
                    </tbody>
                </table>

                <p class="no-space-bottom text-right">Subtotal: $' . $checkout_cart_subtotal . '</p>
                <p class="space-bottom-small text-right">Shipping: $' . $checkout_cart_shipping . '</p>
                <p class="text-tall text-right">Total: $' . $checkout_cart_total . '</p>
                <p class="text-right">
                    <button type="submit" name="submit" value="update-cart" class="btn btn-muted">Update</button>
                    <button type="submit" name="submit" value="cart-checkout" class="btn">Checkout</button>
                </p>
            </form>
            <p class="text-right"><img src="' . $img_directory . 'paypal.jpg" height="53" width="200" alt="Secure payments by PayPal. Pay with Visa, Mastercard, Discover or American Express."></p>
        ';

    }

    // If checkout complete
    if ( $url_current == $url_success && isset($_SESSION['shopping_cart']) ) {

        // Success message and purchase summary    
        $checkout_cart = '
            <p>Thanks for your purchase! Your order will ship in the next three days. You should also receive an invoice confirmation by mail. If you have any questions, please contact <a href="mailto:' . $paypal_account . '">' . $paypal_account . '</a>.</p>
            <h3>Order Summary</h3>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th class="text-left">Item</th>
                        <th style="width: 4em;">#</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>' . $checkout_cart_complete . '
                </tbody>
            </table>

            <p class="no-space-bottom text-right">Subtotal: $' . $checkout_cart_subtotal . '</p>
            <p class="space-bottom-small text-right">Shipping: $' . $checkout_cart_shipping . '</p>
            <p class="text-tall text-right">Total: $' . $checkout_cart_total . '</p>
        ';

        // Empty cart
        unset($_SESSION['shopping_cart']);
        
    }

    // If cart is empty
    elseif ( $checkout_cart_count == 0 ) {
        $checkout_cart = '<p>Your shopping cart is empty.</p>';
    }

   // Display checkout cart
    return $checkout_cart;
    
}
add_shortcode("checkout_cart", "checkout_cart");



// "Remove from Cart" Action
if (stripos($url_current, '?action=remove-from-cart') !== false) {

    // If product ID exists in shopping cart...
    if ( isset($_GET['id']) ) {

        // Define product variable
        $prod_id = $_GET['id'];

        // Remove product from shopping cart
        unset($_SESSION['shopping_cart'][$prod_id]);

    }

    // Redirect page to prevent duplicate "remove from cart" on refresh
    header('Location:' . $url_update);
    exit();

}



// "Update Cart" Action
if ($_POST['submit'] === 'update-cart' ) {

    // For each item in the cart...
    foreach($_SESSION['shopping_cart'] as $item) {

        // Set shopping cart variables
        $item_id = $item['product_id'];
        $item_quantity = $item['product_quantity'];

        $new_item_quantity = $_POST[$item_id];

        // If quantity is set to at least one item...
        if ( $new_item_quantity > 0 ) {
            // Update product quantity
            $_SESSION['shopping_cart'][$item_id]['product_quantity'] = $new_item_quantity;
        }

        // If quantity is set to zero...
        else {
            // Remove item from shopping cart
            unset($_SESSION['shopping_cart'][$item_id]);
        }

    }

    // Redirect page to prevent form resubmission on page refresh
    header('Location:' . $url_update);
    exit();

}



// "Checkout" Action
if ($_POST['submit'] === 'cart-checkout' ) {  

    // PayPal Variables
    $paypal_items = '';
    $count = 0;

    // For each item in shopping cart...
    foreach($_SESSION['shopping_cart'] as $item) {

        // Define shopping cart variables
        $item_name = $item['product_name'];
        $item_price = $item['product_price'];
        $item_quantity = $item['product_quantity'];
        $item_total_cost = $item_price * $item_quantity;
        $checkout_cart_subtotal += $item_total_cost;
        $count = $count+1;

        // Define PayPal variables
        $paypal_item_name = '&item_name_' . $count . '=' . $item_name;
        $paypal_item_price = '&amount_' . $count . '=' . $item_price;
        $paypal_item_quantity = '&quantity_' . $count . '=' . $item_quantity;
        $paypal_item_shipping = '&shipping_' . $count . '=0';

        // Paypal Data for each item
        $paypal_items .= $paypal_item_name . $paypal_item_price . $paypal_item_quantity . $paypal_item_shipping;

    }

    // Product shipping variables
    $checkout_cart_shipping = 5;
    if ($checkout_cart_subtotal > 20) {
        $checkout_cart_shipping = 10;
    }
    if ($checkout_cart_subtotal > 50) {
        $checkout_cart_shipping = 20;
    }
    
    // Paypal Checkout URL
    $paypal_data = 'https://www.paypal.com/cgi-bin/webscr?cmd=_cart&business=' . $paypal_account . $paypal_items . '&shipping_1=' . $checkout_cart_shipping . '&upload=1&no_note=1&rm=1&no_shipping=2&return=' . $url_success . '&cancel_return=' . $url_update;

    // Redirect to PayPal for checkout
    header('Location: ' . $paypal_data);
    exit();

}



// Number Items in Cart
function checkout_cart_count() {

    // Variables
    $checkout_cart_count = 0;
    global $url_current, $url_success;

    // If shopping cart session exists...
    if ( isset($_SESSION['shopping_cart']) ) {
        // For each item...
        foreach($_SESSION['shopping_cart'] as $item) {
            $item_quantity = $item['product_quantity'];
            // Add item quantity to count
            $checkout_cart_count += $item_quantity;
        }
    }

    // If checkout is complete, set items in cart to zero
    if ( $url_current == $url_success ) {
        $checkout_cart_count = 0;
    }

    // Display number of items in cart
    return $checkout_cart_count;
}





/* ======================================================================
 * PetFinder-API.php
 * Add PetFinder listings to the site.
 * Script by Chris Ferdinandi - http://gomakethings.com
 * Adapted from the Petfinder Listings plugin - http://wordpress.org/extend/plugins/petfinder-listings/
 * ====================================================================== */

function petf_shelter_list() {

    // API Attributes & Variables
    $api_key = '1369e3e2548d4db98adab733c2fbb7ac';
    $count = '150';
    $shelter_id = 'RI77';
    $url = "http://api.petfinder.com/shelter.getPets?key=" . $api_key . "&count=" . $count . "&id=" . $shelter_id . "&status=A&output=full";
    $img_directory = get_template_directory_uri() . '/img/';

    // Request shelter data
    $xml = @simplexml_load_file( $url );
    // If data not available
    if ($xml === false) {}


    if( $xml->header->status->code == "100"){
        $output_buffer = "";
        if( count( $xml->pets->pet ) > 0 ){
            $output_buffer .= "<div class='hide-no-js'><p>Your perfect companion could be just a click away. Use the filters to narrow your search, and click on a dog to learn more.</p></div>
                              <div class='hide-js'><p>Your perfect companion could be just a click away. Click on a dog to learn more.</p></div>
                              <p><a class='btn collapse-toggle' href='#sort-options'><i class='icon-filter'></i> Filter Results +</a></p>
                              <div class='collapse hide-no-js' id='sort-options'>
                                  <form>
                                    <div class='row'>
                                        <div class='grid-img space-bottom-small'>
                                            <h3>Age</h3>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.Puppy' checked>
                                                Puppies
                                            </label>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.Young' checked>
                                                Young
                                            </label>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.Adult' checked>
                                                Adult
                                            </label>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.Senior' checked>
                                                Senior
                                            </label>
                                        </div>
                                        <div class='grid-img space-bottom-small'>
                                            <h3>Size</h3>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.Small' checked>
                                                Small
                                            </label>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.Medium' checked>
                                                Medium
                                            </label>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.Large' checked>
                                                Large
                                            </label>
                                        </div>
                                        <div class='grid-img space-bottom-small'>
                                            <h3>Gender</h3>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.Male' checked>
                                                Male
                                            </label>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.Female' checked>
                                                Female
                                            </label>
                                        </div>
                                        <div class='grid-img space-bottom-small'>
                                            <h3>Special Requirements</h3>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.noDogs' checked>
                                                No Other Dogs
                                            </label>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.noCats' checked>
                                                No Cats
                                            </label>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.noKids' checked>
                                                No Kids
                                            </label>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.specialNeeds' checked>
                                                Special Needs
                                            </label>
                                        </div>
                                    </div>
                                    <h3>Breeds</h3>
                                    <label>
                                        <input type='checkbox' class='pf-toggle-all' data-target='.pf-breeds' checked>
                                        Select/Unselect All
                                    </label>
                                    <div class='row'>";
                                    // Get a list of breeds
                                    foreach( $xml->pets->pet as $pet ) {
                                        foreach( $pet->breeds->breed as $this_breed ) {
                                            $breed_list .= $this_breed . ",";
                                        }
                                    }
                                    
                                    // Comma separated string of breeds
                                    //$breed_list = implode(',',array_unique(explode(',', $breed_list)));
                                    
                                    // Breeds as an array
                                    $breed_list = array_filter(array_unique(explode(',', $breed_list)));
                                    asort($breed_list);

                                    // Split breed list in half
                                    $breed_count = count($breed_list);
                                    $breed_list1 = array_slice($breed_list, 0, $breed_count / 2);
                                    $breed_list2 = array_slice($breed_list, $breed_count / 2);

                                    // Display breed filters
                                    foreach( $breed_list1 as $breed ) {
                                        $breed_concat_values = array('(' => '', ')' => '', '  ' => '-', ' ' => '-');
                                        $breed_concat = strtr($breed, $breed_concat_values);
                                        $output_buffer .= "<div class='grid-3'>
                                                            <label>
                                                                <input type='checkbox' class='pf-breeds' data-target='." . $breed_concat . "' checked>" .
                                                                $breed . "
                                                            </label>
                                                          </div>";
                                    }
                                    foreach( $breed_list2 as $breed ) {
                                        $breed_concat_values = array('(' => '', ')' => '', '  ' => '-', ' ' => '-');
                                        $breed_concat = strtr($breed, $breed_concat_values);
                                        $output_buffer .= "<div class='grid-3'>
                                                            <label>
                                                                <input type='checkbox' class='pf-breeds' data-target='." . $breed_concat . "' checked>" .
                                                                $breed . "
                                                            </label>
                                                          </div>";
                                    }
            $output_buffer .=       "</div>
                                </form>
                            </div>
                            <div class='row'>";

            foreach( $xml->pets->pet as $pet ) {

                // Variables
                $pet_name = $pet->name;
                $pet_name = array_shift(explode('-', $pet_name));
                $pet_name = array_shift(explode('(', $pet_name));
                $pet_name = strtolower($pet_name);
                $pet_name = ucwords($pet_name);
                $pet_url = "http://www.petfinder.com/petdetail/" . $pet->id;

                switch ($pet->size){
                    case "L":
	                    $pet_size = "Large";
	                    break;
                    case "M":
	                    $pet_size = "Medium";
	                    break;
                    case "S":
	                    $pet_size = "Small";
	                    break;
                    default:
	                    $pet_size = "Not known";
	                    break;
                }

                switch ($pet->age){
                    case "Baby":
	                    $pet_age = "Puppy";
	                    break;
                    case "Young":
	                    $pet_age = "Young";
	                    break;
                    case "Adult":
	                    $pet_age = "Adult";
	                    break;
                    case "Senior":
	                    $pet_age = "Senior";
	                    break;
                    default:
	                    $pet_age = "Not known";
	                    break;
                }

                $pet_sex = (($pet->sex == "M") ? "Male" : "Female");



                // Output to Display
                $output_buffer .=   "<div class='grid-img text-center space-bottom pf "
                                        . $pet_age . " " . $pet_sex . " " . $pet_size;
                                        foreach( $pet->options->option as $pet_option ) {
                                            $output_buffer .= " " . $pet_option;
                                        }
                                        foreach( $pet->breeds->breed as $this_breed ) {
                                            //$breed_concat = array(' ' => '-');
                                            $breed_concat = array('(' => '', ')' => '', ' ' => '-');
                                            $breed_class = strtr($this_breed, $breed_concat);
                                            $output_buffer .= " " . $breed_class;
                                        }
                $output_buffer .=   "'>
                                        <a class='modal-toggle' data-target='#modal-" . $pet->id . "' target='_blank' href='" . $pet_url . "'>";
                                            if(count($pet->media->photos) > 0){
                                                $output_buffer .= "<img class='space-bottom-small pf-img' alt='Photo of " . $pet_name . "' src='" . $pet->media->photos->photo . "'>";
                                            }
                                            else {
                                                $output_buffer .= "<img class='space-bottom-small pf-img' alt='No photo available yet for " . $pet_name . "' src='" . $img_directory . "nophoto.jpg'>";
                                            }
                $output_buffer .=           "<h3 class='no-space-top space-bottom-small'>" . $pet_name . "</h3>
                                        </a>
                                        <div class='modal text-left' id='modal-" . $pet->id . "'>
                                            <div class='container'>
                                                <div class='group'>
                                                    <a class='close modal-close h2' href='#'>×</a>
                                                </div>
                                                <div class='row'>
                                                    <div class='grid-2'>
                                                        <p>
                                                            <strong>Size:</strong> ". $pet_size . "<br>
                                                            <strong>Age:</strong> " . $pet_age ."<br>
                                                            <strong>Gender:</strong> " . $pet_sex ."
                                                        </p>
                                                        <p>
                                                        <strong>Breed(s)</strong>";
                                                        foreach( $pet->breeds->breed as $this_breed ) {
                                                            $output_buffer .= "<br>" . $this_breed;
                                                        }
                $output_buffer .=                       "</p>
                                                        <p>
                                                            <strong>Special Requirements</strong>";
                                                            $noCats = "";
                                                            $noDogs = "";
                                                            $noKids = "";
                                                            $special = "";
                                                            foreach( $pet->options->option as $option ){
                                                                switch($option){
                                                                    case "noCats":
                                                                        $noCats = "Cats";
                                                                        break;
                                                                    case "noDogs":
                                                                        $noDogs .= "Dogs";
                                                                        break;
                                                                    case "noKids":
                                                                        $noKids .= "Kids";
                                                                        break;
                                                                    case "specialNeeds":
                                                                        $special .= "Special Needs";
                                                                    case "altered":
                                                                        $output_buffer .= "";
                                                                        break;
                                                                    case "hasShots":
                                                                        $output_buffer .= "";
                                                                        break;
                                                                    case "housebroken":
                                                                        $output_buffer .= "";
                                                                        break;
                                                                }
                                                            }
                                                            if($noCats != "" && $noDogs != "" && $noKids != ""){
                                                                $output_buffer .= "<br>No " . $noCats . "/" . $noDogs . "/" . $noKids;
                                                            }
                                                            else if ($noCats != "" && $noDogs != "") {
                                                                $output_buffer .= "<br>No " . $noCats . "/" . $noDogs;
                                                            }
                                                            else if ($noCats != "" && $noKids != "") {
                                                                $output_buffer .= "<br>No " . $noCats . "/" . $noKids;
                                                            }
                                                            else if ($noDogs != "" && $noKids != "") {
                                                                $output_buffer .= "<br>No " . $noDogs . "/" . $noKids;
                                                            }
                                                            else if ($noCats != "") {
                                                                $output_buffer .= "<br>No " . $noCats;
                                                            }
                                                            else if ($noDogs != "") {
                                                                $output_buffer .= "<br>No " . $noDogs;
                                                            }
                                                            else if ($noKids != "") {
                                                                $output_buffer .= "<br>No " . $noKids;
                                                            }
                                                            if($special != ""){
                                                                $output_buffer .= "<br>" . $special;
                                                            }
                                                            if($noCats == "" && $noDogs == "" && $noKids == "" && $special == ""){
                                                                $output_buffer .= "<br>None";
                                                            }
                $output_buffer .=                       "</p>
                                                        <p>
                                                            <a class='btn' href='http://www.pawsnewengland.com/adoption-form/'>Fill Out an Adoption Form</a><br>
                                                            <a target='_blank' href='" . $pet_url . "'>Or see more photos on PetFinder...</a>
                                                        </p>
                                                    </div>
                                                    <div class='grid-4'>
                                                        <h3 class='no-space-top'>About " . $pet_name . "</h3>" .
                                                        $pet->description .
                                                        "<p><button class='btn modal-close'>Close</button></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>" . 
                                        $pet_size . ", " . $pet_age . ", " . $pet_sex;
                                        $noCats = "";
                                        $noDogs = "";
                                        $noKids = "";
                                        $special = "";
                                        foreach( $pet->options->option as $option ){
                                            switch($option){
                                                case "noCats":
                                                    $noCats = "Cats";
                                                    break;
                                                case "noDogs":
                                                    $noDogs .= "Dogs";
                                                    break;
                                                case "noKids":
                                                    $noKids .= "Kids";
                                                    break;
                                                case "specialNeeds":
                                                    $special .= "Special Needs";
                                                case "altered":
                                                    $output_buffer .= "";
                                                    break;
                                                case "hasShots":
                                                    $output_buffer .= "";
                                                    break;
                                                case "housebroken":
                                                    $output_buffer .= "";
                                                    break;
                                            }
                                        }
                                        if($noCats != "" && $noDogs != "" && $noKids != ""){
                                            $output_buffer .= "<br>No " . $noCats . "/" . $noDogs . "/" . $noKids;
                                        }
                                        else if ($noCats != "" && $noDogs != "") {
                                            $output_buffer .= "<br>No " . $noCats . "/" . $noDogs;
                                        }
                                        else if ($noCats != "" && $noKids != "") {
                                            $output_buffer .= "<br>No " . $noCats . "/" . $noKids;
                                        }
                                        else if ($noDogs != "" && $noKids != "") {
                                            $output_buffer .= "<br>No " . $noDogs . "/" . $noKids;
                                        }
                                        else if ($noCats != "") {
                                            $output_buffer .= "<br>No " . $noCats;
                                        }
                                        else if ($noDogs != "") {
                                            $output_buffer .= "<br>No " . $noDogs;
                                        }
                                        else if ($noKids != "") {
                                            $output_buffer .= "<br>No " . $noKids;
                                        }
                                        if($special != ""){
                                            $output_buffer .= "<br>" . $special;
                                        }
                $output_buffer .=   "</div>";
            }
            $output_buffer .= "</div>";
        }else{
            $output_buffer .= "<p class='text-tall text-center'>We don't have any dogs available for adoption at this time. Sorry! Please check back soon.</p>";
        }
    }else{
        $output_buffer = "<p class='text-tall text-center'>Sorry, our pet list is down at the moment.</p>
                         <p class='text-center'><a class='btn btn-large' target='_blank' href='http://www.petfinder.com/pet-search?shelterid=RI77'>View our dogs on Petfinder</a></p>";
    }


    // Remove inline styling
    $output_buffer = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $output_buffer);

    // Remove font tag
    $output_buffer = preg_replace('/<font[^>]+>/', '', $output_buffer);

    // Remove empty tags
    $petlist_cleaners = array('<p></p>' => '', '<p> </p>' => '', '<p>&nbsp;</p>' => '', '<span></span>' => '', '<span> </span>' => '', '<span>&nbsp;</span>' => '', '<span>' => '', '</span>' => '', '<font>' => '', '</font>' => '');
    $output_buffer = strtr($output_buffer, $petlist_cleaners);


    return $output_buffer;
    
}

add_shortcode('shelter_list','petf_shelter_list');


// Don't delete this line or you'll break WordPress ?>
