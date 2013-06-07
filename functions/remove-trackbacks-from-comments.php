<?php

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

?>
