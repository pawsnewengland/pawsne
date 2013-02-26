<?php /*
Template Name: Plain
*/
get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php the_content(); ?>

    <?php edit_post_link('[Edit]', '<p>', '</p>'); ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
