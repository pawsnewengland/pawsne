<?php /*
Template Name: Landing Page Template
*/
get_header(); ?>
	
	<div id="main-page">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">


<div class="main-left">

<p id="intro-paragraph"><span>PAWS New England</span> rescues unwanted, abandoned, neglected, and abused dogs from high kill shelters.</p> 

<p id="intro-paragraph">We also educate the public about the need to spay and neuter pets to prevent overpopulation.</p>

<p align="right" id="intro-paragraph"><strong><a href="<?php echo get_option('home'); ?>/about/">Learn more...</a></strong></p>

<ul id="act-now">
<li><center><a href="<?php echo get_option('home'); ?>/adopt/">ADOPT</a></center></li>
<li><center><a href="<?php echo get_option('home'); ?>/volunteer/">VOLUNTEER</a></center></li>
<li><center><a href="<?php echo get_option('home'); ?>/donate/">DONATE</a></center></li>
</ul>

<div class="clear"></div>

</div>

<div class="main-right">

<p align="right"><object width="400" height="270"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=5413550&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=5413550&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="400" height="270"></embed></object><p align="center"><strong><a href="http://vimeo.com/user1980054">More PAWS videos on Vimeo...</a></strong></p></p>


</div>

<div class="clear"></div>



<!-- START PAGE CONTENT -->

<div class="landing-page-content">

			<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

</div>

<!-- END PAGE CONTENT -->



<div class="bottom">

<div class="bottom1">

<h3>Latest News</h3>

<p>Here's what's new at PAWS:</p>

<?php
include_once(ABSPATH.WPINC.'/rss.php'); // path to include script
$feed = fetch_rss('http://www.pawsnewengland.com/news/archive/wp-rss.php'); // specify feed url
$items = array_slice($feed->items, 0, 3); // specify first and last item
?>

<?php if (!empty($items)) : ?>
<?php foreach ($items as $item) : ?>

<ul id="whats-new"><li><a href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a></li></ul>

<?php endforeach; ?>
<?php endif; ?>

<div class="clear"></div>

</div>


<div class="bottom2">

<h3>PAWS Newsletter</h3>

<p>Get updates on the latest PAWS news. Sign-up for our free newsletter.</p>

                <ul id="newsletter-link">
                       <li><a href="http://eepurl.com/ifVL"><img src="http://chrisferdinandi.com/test/wp-content/themes/PAWS%20New%20England%20Theme/images/email.png" alt="" title="Updates by Email"> Updates by Email</a></li>
                       <li><a href="#"><img src="http://chrisferdinandi.com/test/wp-content/themes/PAWS%20New%20England%20Theme/images/rss.png" alt="" title="Updates by RSS"> Updates by RSS</a></li>
                </ul>

<div class="clear"></div>

</div>


<div class="bottom3">

<h3>Connect</h3>

                <ul id="connect">
                       <li><a href="http://www.facebook.com/group.php?gid=51621723873"><img src="http://chrisferdinandi.com/test/wp-content/themes/PAWS%20New%20England%20Theme/images/facebook.png" alt="" title="Become a Fan on Facebook"> Facebook</a></li>
                       <li><a href="http://twitter.com/PAWSNewEngland"><img src="http://chrisferdinandi.com/test/wp-content/themes/PAWS%20New%20England%20Theme/images/twitter.png" alt="" title="Follow on Twitter"> Twitter</a></li>
                       <li><a href="http://vimeo.com/user1980054"><img src="http://chrisferdinandi.com/test/wp-content/themes/PAWS%20New%20England%20Theme/images/vimeo.png" alt="" title="Watch Us on Vimeo"> Vimeo</a></li>
                </ul>

<div class="clear"></div>

</div>

</div>

<div class="clear"></div>


<?php edit_post_link('Edit This Post', '<p>', '</p>'); ?>
		</div>
		<?php endwhile; endif; ?>

	</div>
	
<?php get_footer(); ?>