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
	wp_register_script('pne-js', get_template_directory_uri() . '/js/pne.js', false, null, true);
	wp_enqueue_script('pne-js');

}
add_action('wp_enqueue_scripts', 'my_scripts_method');





/* ======================================================================
 * Search-Form-Shortcode.php
 * A PHP script and shortcode for the WordPress search form.
 * Script by Elliot Jay Stocks.
 * http://viewportindustries.com/products/starkers/
 *
 * Add a search form anywhere on your site by adding <?php echo kraken_wpsearch(); ?> to a template file.
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
                              <div class='collapse' id='sort-options'>
                                  <form>
                                    <div class='row'>
                                        <div class='grid-img space-bottom-small'>
                                            <h3 class='no-space-top'>Age</h3>
                                            <label>
                                                <input type='checkbox' class='pf-sort' data-target='.Baby' checked>
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
                                            <h3 class='no-space-top'>Size</h3>
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
                                            <h3 class='no-space-top'>Gender</h3>
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
                                            <h3 class='no-space-top'>Home Without...</h3>
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
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class='row'>";
            foreach( $xml->pets->pet as $pet ) {

                // Variables
                $pet_name = $pet->name;
                $pet_name = array_shift(explode(' ', $pet_name));
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

                $pet_sex = (($pet->sex == "M") ? "Male" : "Female");

                // Output to Display
                $output_buffer .=   "<div class='grid-img text-center space-bottom pf "
                                        . $pet->age . " " . $pet_sex . " " . $pet_size;
                                        foreach( $pet->options->option as $pet_option ) {
                                            $output_buffer .= " " . $pet_option;
                                        }
                                        foreach( $pet->breeds->breed as $this_breed ) {
                                            $breed_clean = array(' ' => '-');
                                            $breed_class = strtr($this_breed, $breed_clean);
                                            $output_buffer .= " " . $breed_class;
                                            $breed_list .= $this_breed;
                                        }

                $output_buffer .=   "'>
                                        <a target='_blank' href='" . $pet_url . "'>
                                            <img class='space-bottom-small pf-img' alt='Photo of " . $pet_name . "' src='" . $pet->media->photos->photo . "'>
                                            <h3 class='no-space-top space-bottom-small'>" . $pet_name . "</h3>
                                        </a>" . 
                                        $pet_size . ", " . $pet->age . ", " . $pet_sex;
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





/* ======================================================================
 * HTML-Minify.php
 * A simple PHP function to minify the HTML output from your WordPress site.
 * Script by Damn's Virtual Studio.
 * http://www.intert3chmedia.net/2011/12/minify-html-javascript-css-without.html
 * ====================================================================== */

#class WP_HTML_Compression {
#    // Settings: Change to false to exclude from minification
#    protected $compress_css = true;
#    protected $compress_js = true;
#    protected $info_comment = true;
#    protected $remove_comments = true;

#    // Variables
#    protected $html;
#    public function __construct($html) {
#	    if (!empty($html)) {
#		    $this->parseHTML($html);
#	    }
#    }
#    public function __toString() {
#	    return $this->html;
#    }
#    protected function bottomComment($raw, $compressed) {
#	    $raw = strlen($raw);
#	    $compressed = strlen($compressed);		
#	    $savings = ($raw-$compressed) / $raw * 100;		
#	    $savings = round($savings, 2);		
#	    return '<!--HTML compressed, size saved '.$savings.'%. From '.$raw.' bytes, now '.$compressed.' bytes-->';
#    }
#    protected function minifyHTML($html) {
#	    $pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
#	    preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
#	    $overriding = false;
#	    $raw_tag = false;
#	    // Variable reused for output
#	    $html = '';
#	    foreach ($matches as $token) {
#		    $tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;
#		    $content = $token[0];
#		    if (is_null($tag)) {
#			    if ( !empty($token['script']) ) {
#				    $strip = $this->compress_js;
#			    }
#			    else if ( !empty($token['style']) ) {
#				    $strip = $this->compress_css;
#			    }
#			    else if ($content == '<!--wp-html-compression no compression-->') {
#				    $overriding = !$overriding;
#				    // Don't print the comment
#				    continue;
#			    }
#			    else if ($this->remove_comments) {
#				    if (!$overriding && $raw_tag != 'textarea') {
#					    // Remove any HTML comments, except MSIE conditional comments
#					    $content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
#				    }
#			    }
#		    }
#		    else {
#			    if ($tag == 'pre' || $tag == 'textarea') {
#				    $raw_tag = $tag;
#			    }
#			    else if ($tag == '/pre' || $tag == '/textarea') {
#				    $raw_tag = false;
#			    }
#			    else {
#				    if ($raw_tag || $overriding) {
#					    $strip = false;
#				    }
#				    else {
#					    $strip = true;
#					    // Remove any empty attributes, except:
#					    // action, alt, content, src
#					    $content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);
#					    // Remove any space before the end of self-closing XHTML tags
#					    // JavaScript excluded
#					    $content = str_replace(' />', '/>', $content);
#				    }
#			    }
#		    }
#		    if ($strip) {
#			    $content = $this->removeWhiteSpace($content);
#		    }
#		    $html .= $content;
#	    }
#	    return $html;
#    }
#    public function parseHTML($html) {
#	    $this->html = $this->minifyHTML($html);
#	    if ($this->info_comment) {
#		    $this->html .= "\n" . $this->bottomComment($html, $this->html);
#	    }
#    }
#    protected function removeWhiteSpace($str) {
#	    $str = str_replace("\t", ' ', $str);
#	    $str = str_replace("\n",  '', $str);
#	    $str = str_replace("\r",  '', $str);
#	    while (stristr($str, '  ')) {
#		    $str = str_replace('  ', ' ', $str);
#	    }
#	    return $str;
#    }
#}
#function wp_html_compression_finish($html) {
#    return new WP_HTML_Compression($html);
#}
#function wp_html_compression_start() {
#    ob_start('wp_html_compression_finish');
#}
#add_action('get_header', 'wp_html_compression_start');





// Don't delete this line or you'll break WordPress ?>
