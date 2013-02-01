<?php /*
Template Name: Main Page
*/
get_header(); ?>
	
	<div id="main-page">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                        <h1>
				<a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</h1>
<br>

		<div class="post" id="post-<?php the_ID(); ?>">
			<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

<?php edit_post_link('Edit This Post', '<p>', '</p>'); ?>
		</div>
		<?php endwhile; endif; ?>

	</div>
	
<?php get_footer(); ?>