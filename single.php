<?php get_header(); ?>

<div id="main-col">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
<p class="postmetadata">On <?php the_time('F j, Y') ?> in <?php the_category(', '); ?> <?php edit_post_link('[Edit]', '  ', ''); ?></p>

		<div class="post" id="post-<?php the_ID(); ?>">
		
			<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

		</div>


		<div class="social">
			<ul>
				<li><a rel="nofollow" href="http://twitter.com/?status=<?php the_title(); ?>%20<?php $turl = getBitlyUrl(get_permalink($post->ID)); echo $turl; ?>%20by%20@ChrisFerdinandi"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twittern.png" alt="Tweet This!" ></a></li>
				<li><a rel="nofollow" href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>&t=<?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebookn.png" alt="Facebook This!"></a></li>
				<li><a rel="nofollow" href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_title(); ?>:%20<?php echo the_permalink(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/emailn.png" alt="Email This!"></a></li>
			</ul>
		</div>


		<?php comments_template(); ?>
	
		<?php endwhile; else: ?>
	
			<p>Sorry, no posts matched your criteria.</p>
	
		<?php endif; ?>
	
	</div>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>