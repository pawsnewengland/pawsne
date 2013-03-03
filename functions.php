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
	wp_register_script('pne-js', get_template_directory_uri() . '/js/pne-min-03032013.js', false, null, true);
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
 * PetFinder-API.php
 * Add PetFinder listings to the site.
 * Script by Chris Ferdinandi - http://gomakethings.com
 * Adapted from the Petfinder Listings plugin - http://wordpress.org/extend/plugins/petfinder-listings/
 * ====================================================================== */

function petf_shelter_list( $atts ) {

    extract( shortcode_atts( array(
        'shelter_id' => 'RI77',
        'api_key' => '1369e3e2548d4db98adab733c2fbb7ac',
        'breed' => '',
        'count' => 150,
        'animal' => '',
        'include_info' => 'yes',
        'css_class' => 'pets',
        'contact' => '',
        'include_mixes' => 'no',
        'status' => 'A'
    ), $atts ) );

	$xml = simplexml_load_file( "http://api.petfinder.com/shelter.getPets?key=" . $api_key . "&count=" . intval($count) . "&id=" . $shelter_id . "&status=" . $status . "&output=full" );
	
    
    if( $xml->header->status->code == "100"){
        $output_buffer = "";
        if( count( $xml->pets->pet ) > 0 ){
            $output_buffer .= "<p><a class='btn collapse-toggle' href='#sort-options'><i class='icon-filter'></i> Filter Results +</a></p>
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

                $theme_url = get_template_directory_uri();

                // Output to Display
                $output_buffer .=   "<div class='grid-img text-center space-bottom pf "
                                        . $pet_age . " " . $pet_sex . " " . $pet_size;
                                        foreach( $pet->options->option as $pet_option ) {
                                            $output_buffer .= " " . $pet_option;
                                        }
                $output_buffer .=   "'>
                                        <a class='modal' data-target='#modal-" . $pet->id . "' target='_blank' href='" . $pet_url . "'>";
                                            if(count($pet->media->photos) > 0){
                                                $output_buffer .= "<img class='space-bottom-small pf-img' alt='Photo of " . $pet_name . "' src='" . $pet->media->photos->photo . "'>";
                                            }
                                            else {
                                                $output_buffer .= "<img class='space-bottom-small pf-img' alt='Photo of " . $pet_name . "' src='" . $theme_url . "/img/nophoto.jpg'>";
                                            }
                $output_buffer .=           "<h3 class='no-space-top space-bottom-small'>" . $pet_name . "</h3>
                                        </a>
                                        <div class='modal-menu' id='modal-" . $pet->id . "'>
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
                                                            foreach( $pet->options->option as $option ){
                                                                switch($option){
                                                                    case "noCats":
                                                                        $icons .= "<span class='pf-icon'>Cats</span>";
                                                                        break;
                                                                    case "noDogs":
                                                                        $icons .= "<span class='pf-icon'>Dogs</span>";
                                                                        break;
                                                                    case "noKids":
                                                                        $icons .= "<span class='pf-icon'>Kids</span>";
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
                                                            if($icons != ""){
                                                                $output_buffer .= "<br>No " . $icons;
                                                            }
                                                            if($special != ""){
                                                                $output_buffer .= "<br>" . $special;
                                                            }
                                                            if($icons == "" && $special == ""){
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
                                                        "<button class='btn modal-close'>Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>" . 
                                        $pet_size . ", " . $pet_age . ", " . $pet_sex;
                                        $icons = "";
                                        foreach( $pet->options->option as $option ){
                                            switch($option){
                                                case "noCats":
                                                    $icons .= "<span class='pf-icon'>Cats</span>";
                                                    break;
                                                case "noDogs":
                                                    $icons .= "<span class='pf-icon'>Dogs</span>";
                                                    break;
                                                case "noKids":
                                                    $icons .= "<span class='pf-icon'>Kids</span>";
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
                                        if($icons != ""){
                                            $output_buffer .= "<br>No " . $icons;
                                        }
                                        if($special != ""){
                                            $output_buffer .= "<br>" . $special;
                                        }
                $output_buffer .=   "</div>";
            }
            $output_buffer .= "</div>";
        }else{
            $output_buffer .= "We don't have any dogs available for adoption at this time. Sorry! Please check back soon.";
        }
    }else{
        $output_buffer = "Petfinder is down for the moment. Please check back shortly.";
    }

    return $output_buffer;
    
}

add_shortcode('shelter_list','petf_shelter_list');


// Don't delete this line or you'll break WordPress ?>
