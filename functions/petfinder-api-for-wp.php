<?php

/* ======================================================================

    Petfinder API for WordPress v2.0
    A collection of functions to help you display Petfinder listings
    on your WordPress site, by Chris Ferdinandi.
    http://gomakethings.com

    Thanks Bridget Wessel's Petfinder Listings Plugin for getting me started.
    http://wordpress.org/extend/plugins/petfinder-listings/

    Free to use under the MIT License.
    http://gomakethings.com/mit/
    
 * ====================================================================== */


/* =============================================================
    YOUR SHELTER INFO
    Get your shelter info from Petfinder.
 * ============================================================= */

function get_petfinder_data() {

    // Your Account Info
    $api_key = '1369e3e2548d4db98adab733c2fbb7ac'; // Change to your API key
    $shelter_id = 'RI77'; // Change to your shelter ID
    $count = '150'; // Number of animals to return. Set to higher than total # of animals in your shelter.

    // Create the request URL
    $request_url = "http://api.petfinder.com/shelter.getPets?key=" . $api_key . "&count=" . $count . "&id=" . $shelter_id . "&status=A&output=full";

    // Request shelter data from Petfinder
    $petfinder_data = @simplexml_load_file( $request_url );

    return $petfinder_data;

}





/* =============================================================
    CONVERSIONS
    Functions to convert default Petfinder return values into
    human-readable and/or custom descriptions.
 * ============================================================= */

// Convert Pet Size
function get_pet_size($pet_size) {
    if ($pet_size == 'S') return 'Small';
    if ($pet_size == 'M') return 'Medium';
    if ($pet_size == 'L') return 'Large';
    if ($pet_size == 'XL') return 'Extra Large';
    return 'Not Known';
}

// Convert Pet Age
function get_pet_age($pet_age) {
    if ($pet_age == 'Baby') return 'Puppy';
    if ($pet_age == 'Young') return 'Young';
    if ($pet_age == 'Adult') return 'Adult';
    if ($pet_age == 'Senior') return 'Senior';
    return 'Not Known';
}

// Convert Pet Gender
function get_pet_gender($pet_gender) {
    if ($pet_gender == 'M') return 'Male';
    if ($pet_gender == 'F') return 'Female';
    return 'Not Known';
}

// Convert Special Needs & Options
function get_pet_option($pet_option) {
    if ($pet_option == 'specialNeeds') return 'Special Needs';
    if ($pet_option == 'noDogs') return 'No Dogs';
    if ($pet_option == 'noCats') return 'No Cats';
    if ($pet_option == 'noKids') return 'No Kids';
    if ($pet_option == 'noClaws') return '';
    if ($pet_option == 'hasShots') return '';
    if ($pet_option == 'housebroken') return '';
    if ($pet_option == 'altered') return '';
    return 'Not Known';
}





/* =============================================================
    PET PHOTO SETTINGS
    Set size and number of pet photos.
 * ============================================================= */

function get_pet_photos($pet) {

    // Define Variables
    $pet_photos = '';

    // Photo Sizes
    $pet_photo_large = 'x'; // original, up to 500x500
    $pet_photo_medium = 'pn'; // up to 320x250
    $pet_photo_thumbnail_small = 't'; // scaled to 50px tall
    $pet_photo_thumbnail_medium = 'pnt'; // scaled to 60px wide
    $pet_photo_thumbnail_large = 'fpm'; // scaled to 95px wide

    // Set Photo Options
    $pet_photo_size = $pet_photo_large; // change as desired
    $pet_photo_limit_number = true; // limit number of photos to just first photo? true = yes

    // If pet has photos
    if( count($pet->media->photos) > 0 ) {

        // For each photo, get photos that match the set size
        foreach ( $pet->media->photos->photo as $photo ) {
            foreach( $photo->attributes() as $key => $value ) {
                if ( $key == 'size' ) {
                    if ( $value == $pet_photo_size ) {

                        // If limit set on number of photos, get the first photo
                        if ( $pet_photo_limit_number == true ) {
                            $pet_photos = '<img class="space-bottom-small" alt="Photo of ' . $pet_name . '" src="' . $photo . '">';
                            break;
                        }

                        // Otherwise, get all of them
                        else {
                            $pet_photos .= '<img class="space-bottom-small pf-img" alt="Photo of ' . $pet_name . '" src="' . $photo . '">';
                        }
                        
                    }
                }
            }
        }
    }

    // If no photos have been uploaded for the pet
    else {
        $pet_photos = get_template_directory_uri() . '/img/nophoto.jpg';
    }

    return $pet_photos;
    
}





/* =============================================================
    PET NAME CLEANUP
    Adjust formatting and remove special characters from pet names.
 * ============================================================= */

function get_pet_name($pet_name) {

    // Clean-up pet name
    $pet_name = array_shift(explode('-', $pet_name)); // Remove '-' from animal names
    $pet_name = array_shift(explode('(', $pet_name)); // Remove '(...)' from animal names
    $pet_name = array_shift(explode('[', $pet_name)); // Remove '[...]' from animal names
    $pet_name = strtolower($pet_name); // Transform names to lowercase
    $pet_name = ucwords($pet_name); // Capitalize the first letter of each name

    // Return pet name
    return $pet_name;
    
}





/* =============================================================
    PET DESCRIPTION CLEANUP
    Remove inline styling and empty tags from pet descriptions.
 * ============================================================= */

function get_pet_description($pet_description) {

    // Remove unwanted styling from pet description
    $pet_description = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $pet_description);// Remove inline styling
    $pet_description = preg_replace('/<font[^>]+>/', '', $pet_description); // Remove font tag
    $pet_description_scrub = array('<p></p>' => '', '<p> </p>' => '', '<p>&nbsp;</p>' => '', '<span></span>' => '', '<span> </span>' => '', '<span>&nbsp;</span>' => '', '<span>' => '', '</span>' => '', '<font>' => '', '</font>' => ''); // Define empty tags to remove
    $pet_description = strtr($pet_description, $pet_description_scrub); // Remove empty tags

    // Return pet description
    return $pet_description;
    
}





/* =============================================================
    PET LIST CONDENSER
    Removes spacing and special characters from strings.
 * ============================================================= */

function pet_value_condensed($pet_value) {

    // Define characters to remove and remove them
    $condense_list = array('(' => '', ')' => '', '&' => '-', '/' => '-', '  ' => '-', ' ' => '-');
    $pet_value = strtr($pet_value, $condense_list);

    // Return condensed list
    return $pet_value;
    
}





/* =============================================================
    BREED LIST
    List of available breeds.
 * ============================================================= */

function get_breed_list($pets) {

    // Define Variables
    $breeds = '';
    $breed_list = '';
    $breed_list_1 = '';
    $breed_list_2 = '';

    // Get a list of breeds for each pet
    foreach( $pets as $pet ) {
        foreach( $pet->breeds->breed as $pet_breed ) {
            $breeds .= $pet_breed . "|";
        }
    }

    // Remove duplicates, convert into an array and alphabetize
    $breeds = array_filter(array_unique(explode('|', $breeds)));
    asort($breeds);

    // Create breed checkbox
    function get_breed_checkbox($breed) {

        // Create a condensed version without spaces or special characters
        $breed_condensed = pet_value_condensed($breed);

        // Create checkbox
        $breed_checkbox .=  '<label>
                                <input type="checkbox" class="pf-breeds" data-target=".' . $breed_condensed . '" checked>' .
                                $breed .
                            '</label>';

        // Return checkbox
        return $breed_checkbox;
    }

    // Split list of breeds in half
    $breed_count = count($breeds);
    $breeds_1 = array_slice($breeds, 0, $breed_count / 2);
    $breeds_2 = array_slice($breeds, $breed_count / 2);

    // Get checkboxes for first half of list
    foreach( $breeds_1 as $breed ) {
        $breed_list_1 .= get_breed_checkbox($breed);
    }

    // Get checkboxes for second half of list
    foreach( $breeds_2 as $breed ) {
        $breed_list_2 .= get_breed_checkbox($breed);
    }
                        

    $breed_list =    '<div class="grid-6">
                        <h3>Breeds</h3>
                        <label>
                            <input type="checkbox" class="pf-toggle-all" data-target=".pf-breeds" checked>
                            Select/Unselect All
                        </label>
                    </div>
                    <div class="grid-3">
                        <form>' .
                            $breed_list_1 .
                        '</form>
                    </div>
                    <div class="grid-3">
                        <form>' .
                            $breed_list_2 .
                        '</form>
                    </div>';

    // Return the list
    return $breed_list;
    
}





/* =============================================================
    SIZE LIST
    List of available size of pets.
 * ============================================================= */

function get_size_list($pets) {

    // Define Variables
    $sizes = '';
    $size_list = '';

    // Create a list of pet sizes
    foreach( $pets as $pet ) {
        $sizes .= get_pet_size($pet->size) . "|";
    }

    // Remove duplicates, convert into an array, alphabetize and reverse list order
    $sizes = array_filter(array_unique(explode('|', $sizes)));
    asort($sizes);
    $sizes = array_reverse($sizes);

    // For each size of pet
    foreach( $sizes as $size ) {

        // Create a condensed version without spaces or special characters
        $size_condensed = pet_value_condensed($size);

        // Create a list
        $size_list .=    '<label>
                            <input type="checkbox" class="pf-sort" data-target=".' . $size_condensed . '" checked>' .
                                $size .
                        '</label>';
    }

    $size_list =    '<div class="grid-img space-bottom-small">
                        <h3>Size</h3>
                        <form>' .
                            $size_list .
                        '</form>
                    </div>';

    // Return the list
    return $size_list;
    
}





/* =============================================================
    AGE LIST
    List of available pet ages.
 * ============================================================= */

function get_age_list($pets) {

    // Define Variables
    $ages = '';
    $age_list = '';

    // Create a list of pet ages
    foreach( $pets as $pet ) {
        $ages .= get_pet_age($pet->age) . "|";
    }

    // Remove duplicates, convert into an array and reverse list order
    $ages = array_reverse(array_filter(array_unique(explode('|', $ages))));

    // For each pet age
    foreach( $ages as $age ) {

        // Create a condensed version without spaces or special characters
        $age_condensed = pet_value_condensed($age);

        // Create a list
        $age_list .=    '<label>
                            <input type="checkbox" class="pf-sort" data-target=".' . $age_condensed . '" checked>' .
                                $age .
                        '</label>';
    }

    $age_list =     '<div class="grid-img space-bottom-small">
                        <h3>Age</h3>
                        <form>' .
                            $age_list .
                        '</form>
                    </div>';

    // Return the list
    return $age_list;
    
}





/* =============================================================
    GENDER LIST
    List of available pet genders.
 * ============================================================= */

function get_gender_list($pets) {

    // Define Variables
    $genders = '';
    $gender_list = '';

    // Create a list available pet genders
    foreach( $pets as $pet ) {
        $genders .= get_pet_gender($pet->sex) . "|";
    }

    // Remove duplicates and convert into an array
    $genders = array_filter(array_unique(explode('|', $genders)));

    // For each pet gender
    foreach( $genders as $gender ) {

        // Create a condensed version without spaces or special characters
        $gender_condensed = pet_value_condensed($gender);

        // Create a list
        $gender_list .=    '<label>
                            <input type="checkbox" class="pf-sort" data-target=".' . $gender_condensed . '" checked>' .
                                $gender .
                        '</label>';
    }

    $gender_list =  '<div class="grid-img space-bottom-small">
                        <h3>Gender</h3>
                        <form>' .
                            $gender_list .
                        '</form>
                    </div>';

    // Return the list
    return $gender_list;
    
}





/* =============================================================
    OPTIONS & SPECIAL NEEDS LIST
    List of all available special needs and options for pets.
 * ============================================================= */

function get_options_list($pets) {

    // Define Variables
    $options = '';
    $options_list = '';

    // Create a list of pet options and special needs
    foreach( $pets as $pet ) {
        foreach( $pet->options->option as $pet_option ) {
            $options .= get_pet_option($pet_option) . "|";
        }
    }

    // Remove duplicates, convert into an array and reverse list order
    $options = array_reverse(array_filter(array_unique(explode('|', $options))));

    // For each pet option
    foreach( $options as $option ) {

        if ($option != '' ) {

            // Create a condensed version without spaces or special characters
            $option_condensed = pet_value_condensed($option);

            // Create a list
            $option_list .=    '<label>
                                <input type="checkbox" class="pf-sort" data-target=".' . $option_condensed . '" checked>' .
                                    $option .                            
                            '</label>';

        }

    }

    $option_list =  '<div class="grid-img space-bottom-small">
                        <h3>Special Requirements</h3>
                        <form>' .
                            $option_list .
                        '</form>
                    </div>';

    // Return the list
    return $option_list;
    
}






/* =============================================================
    PET INFORMATION
    Get and display information on each pet.
 * ============================================================= */

function get_pet_info($pets) {

    $pet_info = '';

    foreach( $pets as $pet ) {

        // Define Variables
        $pet_name = get_pet_name($pet->name);
        $pet_size = get_pet_size($pet->size);
        $pet_age = get_pet_age($pet->age);
        $pet_gender = get_pet_gender($pet->sex);
        $pet_url = 'http://www.petfinder.com/petdetail/' . $pet->id;
        $pet_photos = get_pet_photos($pet);
        $pet_description = get_pet_description($pet->description);

        // Get list of breed(s)
        $pet_breeds = '';
        $pet_breeds_condensed = '';
        foreach( $pet->breeds->breed as $breed ) {
            $pet_breeds .= '<br>' . $breed;
            $pet_breeds_condensed .= pet_value_condensed($breed) . ' ';
        }

        // Get list of all pet options
        $pet_options = '';
        $pet_options_condensed = '';
        $pet_options_detail = '';
        $noCats = false;
        $noDogs = false;
        $noKids = false;
        $specialNeeds = false;
        foreach( $pet->options->option as $option ) {        
            $option = get_pet_option($option);
            if ( $option != '' ) {
                if ( $option == 'No Cats' ) { $noCats = true; }
                if ( $option == 'No Dogs' ) { $noDogs = true; }
                if ( $option == 'No Kids' ) { $noKids = true; }
                if ( $option == 'Special Needs' ) { $specialNeeds = true; }
                $pet_options_condensed .= pet_value_condensed($option) . ' ';                
            }
        }

        // Create content for pet options section
        if( $noCats == true && $noDogs == true && $noKids == true ) {
            $pet_options = '<br>No Cats/Dogs/Kids';
        }
        else if ( $noCats == true && $noDogs == true ) {
            $pet_options = '<br>No Cats/Dogs';
        }
        else if ( $noCats == true && $noKids == true ) {
            $pet_options = '<br>No Cats/Kids';
        }
        else if ( $noDogs == true && $noKids == true ) {
            $pet_options = '<br>No Dogs/Kids';
        }
        else if ($noCats == true ) {
            $pet_options = '<br>No Cats';
        }
        else if ( $noDogs == true ) {
            $pet_options = '<br>No Dogs';
        }
        else if ( $noKids == true ) {
            $pet_options = '<br>No Kids';
        }
        if( $specialNeeds == true ){
            $pet_options .= '<br>Special Needs';
        }
        if( $noCats == false && $noDogs == false && $noKids == false && $specialNeeds == false ) {
            $pet_options_detail = '<br>None';
        }
        else {
            $pet_options_detail = $pet_options;
        }


        // Compile pet info
        // Add $pet_options and $pet_breeds as classes and meta info
        $pet_info .=    '<div class="grid-img text-center space-bottom pf ' . pet_value_condensed($pet_age) . ' ' . pet_value_condensed($pet_gender) . ' ' . pet_value_condensed($pet_size) . ' ' . $pet_breeds_condensed . ' ' . $pet_options_condensed . '">
                            <a class="modal-toggle" data-target="#modal-' . $pet->id . '" target="_blank" href="' . $pet_url . '">' .
                                $pet_photos .
                                '<h3 class="no-space-top space-bottom-small">' . $pet_name . '</h3>
                            </a>' .
                            $pet_size . ', ' . $pet_age . ', ' . $pet_gender .
                            $pet_options .
                        '</div>
                        <div class="modal" id="modal-' . $pet->id . '">
                            <div class="container">
                                <div class="group">
                                    <h2>About ' . $pet_name . '<a class="close modal-close" href="#">×</a></h2>
                                </div>
                                <div class="row">
                                    <div class="grid-2">
                                        <p>
                                            <strong>Size:</strong> ' . $pet_size . '<br>
                                            <strong>Age:</strong> ' . $pet_age . '<br>
                                            <strong>Gender:</strong> ' . $pet_gender . '
                                        </p>
                                        <p>
                                            <strong>Breed(s):</strong>' .
                                            $pet_breeds .
                                        '</p>
                                        <p>
                                            <strong>Special Requirements:</strong>' .
                                            $pet_options_detail .
                                        '</p>
                                        <p>
                                            <a class="btn" href="http://www.pawsnewengland.com/adoption-form/">Fill Out an Adoption Form</a><br>
                                            <a target="_blank" href="' . $pet_url . '">Or see more photos on PetFinder...</a>
                                        </p>
                                    </div>
                                    <div class="grid-4">
                                        <p class="text-center">' . $pet_photos . '</p>' .
                                        $pet_description .
                                        '<p><button class="btn modal-close">Close</button></p>
                                    </div>
                                </div>
                            </div>
                        </div>';

    }

    // Return pet info
    return $pet_info;

}





/* =============================================================
    DISPLAY PETFINDER LISTINGS
    Compile lists and pet info, and display via a shortcode.
 * ============================================================= */

function get_petfinder_list() {

    // Access Petfinder Data
    $petfinder_data = get_petfinder_data();
    $petfinder_list = '';

    // If the API returns without errors
    if( $petfinder_data->header->status->code == "100" ) {
    
        // If there is at least one animal
        if( count( $petfinder_data->pets->pet ) > 0 ) {

            $pets = $petfinder_data->pets->pet;

            // Compile information that you want to include
            $petfinder_list =   '<div class="hide-no-js">
                                    <p>Your perfect companion could be just a click away. Use the filters to narrow your search, and click on a dog to learn more.</p>
                                </div>
                                <div class="hide-js">
                                    <p>Your perfect companion could be just a click away. Click on a dog to learn more.</p>
                                </div>
                                <p><a class="btn collapse-toggle" data-target="#sort-options" href="#"><i class="icon-filter"></i> Filter Results +</a></p>
                                <div class="collapse hide-no-js" id="sort-options">

                                    <div class="row">' .
                                        get_age_list($pets) .
                                        get_size_list($pets) .
                                        get_gender_list($pets) .
                                        get_options_list($pets) .
                                    '</div>
                                    
                                    <div class="row">' .
                                        get_breed_list($pets) .
                                    '</div>

                                </div>

                                <div class="row">' .
                                    get_pet_info($pets) .
                                '</div>';

        }

        // If no animals are available for adoption
        else {
            $petfinder_list = '<p>We don\'t have any pets available for adoption at this time. Sorry! Please check back soon.</p>';
        }
    }

    // If error code is returned
    else {
        $petfinder_list = '<p>Petfinder is down for the moment. Please check back shortly.</p>';
    }

    return $petfinder_list;
    
}
add_shortcode('petfinder_list','get_petfinder_list');

?>