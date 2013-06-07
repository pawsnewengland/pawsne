<?php

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

?>
