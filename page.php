<?php get_header(); ?>

<div class="main" id="post-<?php the_ID(); ?>">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

		<?php the_content('<p>Read the rest of this page &raquo;</p>'); ?>

		<?php edit_post_link('[Edit]', '<p>', '</p>'); ?>

	<?php endwhile; endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>