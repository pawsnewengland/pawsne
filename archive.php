<?php get_header(); ?>

<div class="main">

	<?php if (have_posts()) : ?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h1>On <?php single_cat_title(); ?>...</h1>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h1>On <?php single_tag_title(); ?>...</h1>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h1>On <?php the_time('F jS, Y'); ?>...</h1>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h1>From <?php the_time('F, Y'); ?>...</h1>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h1>From <?php the_time('Y'); ?>...</h1>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h1>Author Archive</h1>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h1>Blog Archives</h1>
	<?php } ?>

	<div class="dotted"></div>

	<?php while (have_posts()) : the_post(); ?>

		<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		<p class="meta">On <?php the_time('F j, Y') ?> <?php edit_post_link('[Edit]', '  ', ''); ?></p>

		<?php the_content('<p>Keep reading...</p>'); ?>

		<p>
			<a class="btn-sm" id="twitter" rel="nofollow" href="http://twitter.com/?status=<?php the_title(); ?>%20<?php echo the_permalink(); ?>" onclick="centeredPopup(this.href,'myWindow', '550','450','yes');return false"><i class="icon twitter-alt"></i> Tweet</a>
			<a class="btn-sm" id="facebook" rel="nofollow" href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>&t=<?php the_title(); ?>" onclick="centeredPopup(this.href,'myWindow','675','450','yes');return false"><i class="icon facebook"></i> Like</a>
			<a class="btn-sm" id="chat" rel="nofollow" href="<?php comments_link(); ?>"><i class="icon chat"></i> Comment</a>
		</p>

		<div class="dotted"></div>


	<?php endwhile; ?>

	<!-- Previous/Next page navigation -->
	<div class="page-nav">
		<div class="nav-new"><p><?php previous_posts_link('&larr; Newer') ?></p></div>
		<div class="nav-old"><p><?php next_posts_link('Older &rarr;') ?></p></div>
	</div>

	<?php else : ?>

	<h2>Uh-oh!</h2>
	<p>The page your looking for doesn't exist. Check the URL, or try using the search function.</p>

	<?php endif; ?>
	
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
