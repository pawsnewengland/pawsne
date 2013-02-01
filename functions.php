<?php
// Don't touch anything in here or the sky will fall on your head

if( !is_admin()){
   wp_deregister_script('jquery');
   wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"), false, '1.3.2');
   wp_enqueue_script('jquery');
}


if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ));

?>
