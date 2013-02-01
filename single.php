<?php get_header(); ?>

<div class="main" id="post-<?php the_ID(); ?>">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<h1 class="instapaper_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<p class="meta">On <?php the_time('F j, Y') ?> <?php edit_post_link('[Edit]', '  ', ''); ?></p>

		<div class="instapaper_body">
			<?php the_content('<p>Read the rest of this entry &raquo;</p>'); ?>
		</div>

		<p>
			<a class="btn-sm" id="twitter" rel="nofollow" href="http://twitter.com/?status=<?php the_title(); ?>%20<?php echo the_permalink(); ?>" onclick="centeredPopup(this.href,'myWindow', '550','450','yes');return false"><i class="icon twitter-alt"></i> Tweet</a>
			<a class="btn-sm" id="facebook" rel="nofollow" href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>&t=<?php the_title(); ?>" onclick="centeredPopup(this.href,'myWindow','675','450','yes');return false"><i class="icon facebook"></i> Like</a>
		</p>

		<?php comments_template(); ?>

	
	<?php endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
	<?php endif; ?>
	
</div>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>
