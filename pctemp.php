<?php /*
Template Name: Pods
*/
get_header(); ?>

<div id="lower-wrap">
	
	<div id="main-col">

                        <h1>
				<a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</h1>
<br>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
<br>
<h2>Subscribe</h2>

<ul id="podcast-sb">
<li><a href="http://feeds.feedburner.com/RHRPodcast"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/podcast-rss.png"> Subscribe by RSS</a></li>
<li><a href="http://feedburner.google.com/fb/a/mailverify?uri=RHRPodcast&amp;loc=en_US"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/podcast-email.png"> Subscribe by Email</a></li>
<li><a href="itpc://feeds.feedburner.com/RHRPodcast"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/iTunes.png"> Subscribe with iTunes</a></li>
</ul>

<h2>Recent Episodes</h2>
<br>
<?php
include_once(ABSPATH.WPINC.'/rss.php'); // path to include script
$feed = fetch_rss('http://feeds.feedburner.com/RHRPodcast'); // specify feed url
$items = array_slice($feed->items, 0, 5); // specify first and last item
?>

<?php if (!empty($items)) : ?>
<?php foreach ($items as $item) : ?>

<ul><li><a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a></li></ul>

<?php endforeach; ?>
<?php endif; ?>

<p><b><a href="http://renegadehr.net/category/podcasts/">Find more podcasts...</a></b></p>

			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

<?php edit_post_link('[Edit]', '<p>', '</p>'); ?>
<br>
<p><strong>Spread the Word:</strong></p>
<div id="social">
<ul>
<li><a href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook.png" alt="Facebook This!"></a></li>
<li><a href="http://twitter.com/home?status=<?php the_title(); ?> <?php $turl = getBitlyUrl(get_permalink($post->ID)); echo $turl; ?> via @ChrisFerdinandi"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twitter.png" alt="Tweet This!" ></a></li>
<li><a href="mailto:?subject=<?php the_title(); ?>&body=<?php the_title(); ?>: <?php echo the_permalink(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/email.png" alt="Email This!"></a></li>
</ul>
</div>

		</div>
		<?php endwhile; endif; ?>
	
	</div>

	<?php get_sidebar(); ?>
	
</div>

<?php get_footer(); ?>