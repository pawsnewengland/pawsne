<?php get_header(); ?>

<div class="main">

	<?php if (have_posts()) : ?>
	
		<h2>Search Results</h2>
	
		<?php while (have_posts()) : the_post(); ?>
	
			<ul>
				<li id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			</ul>
	
		<?php endwhile; ?>
	
	<!-- Previous/Next page navigation -->
	<div class="page-nav">
		<div class="nav-new"><p><?php previous_posts_link('&larr; Newer') ?></p></div>
		<div class="nav-old"><p><?php next_posts_link('Older &rarr;') ?></p></div>
	</div>
	
	<?php else : ?>
	
		<h2>No posts found. Try a different search?</h2>
	
	<?php endif; ?>
	
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
