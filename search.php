<?php get_header(); ?>

<div id="main-col">

	<?php if (have_posts()) : ?>
	
		<h2>Search Results</h2>
	
		<?php while (have_posts()) : the_post(); ?>
	
			<ul class="post">
				<li id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			</ul>
	
		<?php endwhile; ?>
	
    <!-- Previous/Next page navigation -->
    <div class="page-nav">
	    <div class="nav-previous"><p><?php previous_posts_link('← Newer Entries') ?></p></div>
            <div class="nav-next"><p><?php next_posts_link('Older Entries →') ?></p></div>
    </div>
	
	<?php else : ?>
	
		<h2>No posts found. Try a different search?</h2>
	
	<?php endif; ?>
	
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>