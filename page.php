<?php get_header(); ?>

<div class="row">

    <div class="grid-4">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <article>

	            <header>
		            <h1><?php the_title(); ?></h1>
	            </header>

	            <?php the_content(); ?>

	            <?php edit_post_link('[Edit]', '<p>', '</p>'); ?>

            </article>

        <?php endwhile; endif; ?>

    </div>

    <div class="grid-2">
        <?php get_sidebar(); ?>
    </div>

</div>

<?php get_footer(); ?>
