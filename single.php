<?php get_header(); ?>

<div id="main-col">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

				<p class="postmetadata"><?php the_time('F j, Y') ?> - <a href="<?php the_permalink() ?>#comments"><?php comments_number('No Comments', '1 Comment', '% Comments'); ?></a></p>

		<div class="post" id="post-<?php the_ID(); ?>">
		
			<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

<?php edit_post_link('Edit This Post', '<p>', '</p>'); ?>
<br>
<p><strong>Spread the Word:</strong></p>
<div id="social">
<ul>
<li><a href="mailto:?subject=<?php the_title(); ?>&body=Hi,%0D%0A%0D%0AI thought you might enjoy this article: <?php echo the_permalink(); ?>"<?php the_title(); ?>."<?php echo the_permalink(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/email.png" alt="Email This!"></a></li>
<li><a href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook.png" alt="Facebook This!"></a></li>
<li><a href="http://twitter.com/home?status=<?php the_title(); ?> <?php echo the_permalink(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twitter.png" alt="Tweet This!" ></a></li>
</ul>
</div>

		</div>

		<?php comments_template(); ?>
	
		<?php endwhile; else: ?>
	
			<p>Sorry, no posts matched your criteria.</p>
	
		<?php endif; ?>
	
	</div>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>