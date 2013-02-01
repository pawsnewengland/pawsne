<?php /*
Template Name: Landing Page
*/
get_header(); ?>
	
	<div id="main-col-landing-page">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">

<!-- LANDING PAGE CONTENT START -->

<center><h1><img src="<?php bloginfo('stylesheet_directory'); ?>/images/3500dogs.png" alt="We’ve saved the lives of over 3,500 dogs."></h1></center>

<div id="landing-page-content-1">

	<div id="landing-page-1">

		<h1><img src="<?php bloginfo('stylesheet_directory'); ?>/images/Rescue.png" alt="1. Rescue"></h1>

		<p>We rescue abandoned, neglected, and abused dogs from high-kill shelters.</p>

	</div>

	<div id="landing-page-2">

		<h1><img src="<?php bloginfo('stylesheet_directory'); ?>/images/Rehabilitate.png" alt="2. Rehabilitate"></h1>

		<p>Next, we provide veterinary care and much needed TLC.</p>		

	</div>


	<div id="landing-page-3">

		<h1><img src="<?php bloginfo('stylesheet_directory'); ?>/images/Adopt.png" alt="3. Adopt"></h1>

		<p>When they're ready, we place our dogs in safe and loving homes.</p>

	</div>

</div>

<div class="clear"></div>

<div id="landing-page-content-2">

	<div id="landing-page-4">

		<ul id="adopt-button">
			<li><center><a href="<?php echo get_option('home'); ?>/adopt/">Adopt</a></center></li>
		</ul>

<div class="clear"></div>

		<p>Or learn about <a href="<?php echo get_option('home'); ?>/help/">other ways you can help...</a></p>

	</div>

</div>

<div class="clear"></div>


<!-- LANDING PAGE CONTENT END -->


<?php edit_post_link('[Edit]', '<p>', '</p>'); ?>
		</div>
		<?php endwhile; endif; ?>

	</div>
	
<?php get_footer(); ?>