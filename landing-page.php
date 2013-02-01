<?php /*
Template Name: Landing Page
*/
get_header(); ?>
	
	<div id="main-col-nosidebar">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">

			<?php the_content('<p>Read the rest of this page &raquo;</p>'); ?>

<!-- LANDING PAGE CONTENT START -->

	<div class="landing-full dotted">

		<h1 class="textcenter">We've saved the lives of over 3,500 dogs.</h1>

		<div class="landing-half">
			<h2>Here's how you can help...</h2>

			<div class="clear">
				<a href="<?php echo get_option('home'); ?>/adopt/"><img class="alignleft" src="<?php bloginfo('stylesheet_directory'); ?>/images/Adopt64.png">
				<h2 class="nospace">Adopt</h2></a>
				<p>Give a deserving dog a new home.</p>
			</div>

			<div class="clear">
				<a href="<?php echo get_option('home'); ?>/donate/"><img class="alignleft" src="<?php bloginfo('stylesheet_directory'); ?>/images/Donate64.png">
				<h2 class="nospace">Donate</h2></a>
				<p>Help fund our life-saving work.</p>
			</div>

			<div  class="clear">
				<a href="<?php echo get_option('home'); ?>/volunteer/"><img class="alignleft" src="<?php bloginfo('stylesheet_directory'); ?>/images/Volunteer64.png">
				<h2 class="nospace">Volunteer</h2></a>
				<p>Share your time or just spread the word.</p>
			</div>

		</div>

		<div class="landing-half">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/images/main.png">
		</div>

		<div class="clear"></div>
	</div>


	<div class="landing-full dotted">

		<h1 class="textcenter">How We Work</h1>

		<div class="landing-third textcenter">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/images/Rescue.png">
			<h2 class="nospace">1. Rescue</h2>
			<p>We rescue abandoned, neglected, and abused dogs from high-kill shelters.</p>
		</div>

		<div class="landing-third textcenter">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/images/Rehab.png">
			<h2 class="nospace">2. Rehabilitate</h2>
			<p>Next, we provide veterinary care and much needed TLC.</p>
		</div>

		<div class="landing-third textcenter">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/images/Rehome.png">
			<h2 class="nospace">3. Rehome</h2>
			<p>When they're ready, we place our dogs in safe and loving homes.</p>
		</div>

		<div class="clear"></div>
	</div>


	<div class="landing-full">

		<h1 class="textcenter">Get Free Updates</h1>

		<div class="landing-third">
			<a href="http://eepurl.com/ifVL"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/email48.png" class="alignleft"><h2 class="nospace">Join our newsletter</h2></a>
		</div>

		<div class="landing-third">
			<a href="http://feeds.feedburner.com/pawsne"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/rss48.png" class="alignleft"><h2 class="nospace">Subscribe to our blog</h2></a>
		</div>

		<div class="landing-third">
			<a href="http://www.facebook.com/PAWSNewEngland"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook48.png" class="alignleft"><h2 class="nospace">Like us on Facebook</h2></a>
		</div>

		<div class="clear"></div>
	</div>

<!-- LANDING PAGE CONTENT END -->


<?php edit_post_link('[Edit]', '<p>', '</p>'); ?>
		</div>
		<?php endwhile; endif; ?>

	</div>
	
<?php get_footer(); ?>
