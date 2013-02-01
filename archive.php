<?php get_header(); ?>

<div id="main-col">

		<?php if (have_posts()) : ?>

		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>
		<h1>On <?php single_cat_title(); ?>...</h1>
		<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h1><?php single_tag_title(); ?>...</h1>
		<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h1>Archive for <?php the_time('F jS, Y'); ?></h1>
		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h1>Archive for <?php the_time('F, Y'); ?></h1>
		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h1>Archive for <?php the_time('Y'); ?></h1>
		<?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h1>Author Archive</h1>
		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h1>Blog Archives</h1>
		<?php } ?>
<br><br>
		<?php while (have_posts()) : the_post(); ?>

				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
<p class="postmetadata">On <?php the_time('F j, Y') ?> in <?php the_category(', '); ?> <?php edit_post_link('[Edit]', '  ', ''); ?></p>

			<div class="post">
				
				<?php the_content('<p>Keep reading...</p>'); ?>

				
<div id="social">
	<div id="social-left">
		<ul>
			<li><a rel="nofollow" href="http://twitter.com/?status=<?php the_title(); ?> <?php $turl = getBitlyUrl(get_permalink($post->ID)); echo $turl; ?> by @ChrisFerdinandi"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twittern.png" alt="Tweet This!" ></a></li>
			<li><a rel="nofollow" href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>&t=<?php the_title(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebookn.png" alt="Facebook This!"></a></li>
			<li><a rel="nofollow" href="mailto:?subject=<?php the_title(); ?>&body=<?php the_title(); ?>: <?php echo the_permalink(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/emailn.png" alt="Email This!"></a></li>
		</ul>
	</div>
	<div id="social-right"><?php comments_popup_link('{ Leave a Comment }', '{ 1 Comment }', '{ % Comments }'); ?></div>
</div>

			</div>



	<div class="dotted"></div>


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