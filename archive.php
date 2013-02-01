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
				
			</div>

		<?php endwhile; ?>

    <!-- Previous/Next page navigation -->
    <div class="page-nav">
	    <div class="nav-previous"><p><?php previous_posts_link('← Newer Entries') ?></p></div>
            <div class="nav-next"><p><?php next_posts_link('Older Entries →') ?></p></div>
    </div>

	<?php else : ?>

		<h1>Uh oh!</h1>

		<p class="post">The page your looking for doesn't exist. You can either <a href="<?php echo get_option('home'); ?>/">go back to the homepage</a> and try again, or use the search box below.</p>

		<center><?php include (TEMPLATEPATH . '/searchform.php'); ?></center>

	<?php endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
