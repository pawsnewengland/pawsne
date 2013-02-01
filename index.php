<?php get_header(); ?>

<div id="main-col">

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

				<p class="postmetadata"><?php the_time('F j, Y') ?> - <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?><?php edit_post_link('[Edit]', '  ', ''); ?></p>

			<div class="post" id="post-index">
				
				<?php the_content('<br>Keep reading...'); ?>	
				
<div id="social">
<ul>
<li><a href="http://twitter.com/home?status=<?php the_title(); ?> <?php $turl = getBitlyUrl(get_permalink($post->ID)); echo $turl; ?> via @ChrisFerdinandi"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twitter.png" alt="Tweet This!" ></a></li>
<li><a href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>&t=<?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook.png" alt="Facebook This!"></a></li>
<li><a href="mailto:?subject=<?php the_title(); ?>&body=<?php the_title(); ?>: <?php echo the_permalink(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/email.png" alt="Email This!"></a></li>
</ul>
</div>

			</div>
<br>
		<?php endwhile; ?>

    <!-- Previous/Next page navigation -->
    <div class="page-nav">
	    <div class="nav-previous"><p><?php previous_posts_link('← Newer Entries') ?></p></div>
            <div class="nav-next"><p><?php next_posts_link('Older Entries →') ?></p></div>
    </div>

	<?php else : ?>

		<h2>Oh snap!</h2>
		<p>The page your looking for doesn't exist. Check the URL, or try using the search function.</p>

	<?php endif; ?>
	
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>