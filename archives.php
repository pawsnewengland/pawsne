<?php /*
Template Name: Archives
*/
get_header(); ?>

	<div class="main">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<h1><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

			<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>

			<?php edit_post_link('[Edit]', '<p>', '</p>'); ?>

		<?php endwhile; endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
