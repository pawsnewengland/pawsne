<?php get_header(); ?>

<div id="main-col">

		<?php if (have_posts()) : ?>

		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>
		<h1><?php single_cat_title(); ?></h1>
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

				<p class="postmetadata">By <?php the_author_link(); ?> on <?php the_time('F j, Y') ?> - <a href="<?php the_permalink() ?>#comments"><?php comments_number('No Comments', '1 Comment', '% Comments'); ?></a></p>

			<div class="post" id="post-index">
				
				<?php the_content('<br>Keep reading...'); ?>

<br>
<h3>Share This</h3>

<div id="social">
<ul>
<li><a href="mailto:?subject=<?php the_title(); ?>&body=Hi,%0D%0A%0D%0AI thought you might enjoy this article: <?php echo the_permalink(); ?>"<?php the_title(); ?>."<?php echo the_permalink(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/email.png" alt="Email This!"></a></li>
<li><a href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook.png" alt="Facebook This!"></a></li>
<li><a href="http://twitter.com/home?status=<?php the_title(); ?> <?php echo the_permalink(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twitter.png" alt="Tweet This!" ></a></li>
</ul>
</div>
				
			</div>

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
