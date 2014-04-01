<?php /*
Template Name: Landing
*/
get_header(); ?>

	<!-- <div class="alert">Alert here...</div> -->

	<article>

		<h1 class="text-hero text-center">We save lives, one dog at a time.</h1>

		<div class="row">

			<div class="grid-3">
				<h2>Here's how you can help...</h2>

				<div class="group">
					<p>
						<a class="url-action" href="<?php echo get_option('home'); ?>/adopt/">
							<i class="icon-home"></i>
							<span class="h2">Adopt</span><br>
							Give a deserving dog a new home.
						</a>
					</p>
				</div>

				<div class="group">
					<p>
						<a class="url-action" href="<?php echo get_option('home'); ?>/donate/">
							<i class="icon-heart"></i>
							<span class="h2">Donate</span><br>
							Help fund our life-saving work.
						</a>
					</p>
				</div>

				<div class="group">
					<p>
						<a class="url-action" href="<?php echo get_option('home'); ?>/volunteer/">
							<i class="icon-time"></i>
							<span class="h2">Volunteer</span><br>
							Share your time or just spread the word.
						</a>
					</p>
				</div>

			</div>

			<div class="grid-3 text-center">
				<img class="hide-mobile" src="<?php bloginfo('stylesheet_directory'); ?>/img/main.png" height="346" width="459" title="A photo of a PAWS rescue dog">
			</div>

		</div>

		<hr>

	</article>


	<article>
		<div class="row">
			<div class="grid-1 offset-1 text-center">
				<img class="space-top" src="<?php bloginfo('stylesheet_directory'); ?>/img/campaigns/dig-cover-small.jpg">
			</div>
			<div class="grid-3">
				<h1>The Doggie Investigation Gang</h1>
				<p>Doggie Investigation Gang is a book series created and authored by PAWS supporter Shara Puglisi Katsos. Inspired by three real-life dogs, all profits from sales of the first book of the series will be donated to PAWS New England.</p>
				<p class="no-space-bottom text-center">
					<a class="btn" href="http://www.amazon.com/Missing-Canine-Shara-Puglisi-Katsos/dp/0977639657/">Buy It Now</a><br>
					<a href="">Or learn more...</a>
				</p>
			</div>
		</div>

		<hr>
	</article>


	<article class="row text-center">
		<h2 class="h1">How We Work</h2>

		<div class="grid-2">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/img/rescue.jpg" height="175" width="175" title="">
			<h2 class="nospace">1. Rescue</h2>
			<p>We rescue abandoned, neglected, and abused dogs from high-kill shelters.</p>
		</div>

		<div class="grid-2">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/img/rehab.jpg" height="175" width="175" title="">
			<h2 class="nospace">2. Rehabilitate</h2>
			<p>Next, we provide veterinary care and much needed TLC.</p>
		</div>

		<div class="grid-2">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/img/rehome.jpg" height="175" width="175" title="">
			<h2 class="nospace">3. Rehome</h2>
			<p>When they're ready, we place our dogs in safe and loving homes.</p>
		</div>

	</article>


	<hr>


	<article class="row text-center">

		<h2 class="h1">Get Free Updates</h2>

		<div class="grid-2">
			<a class="h2" href="http://eepurl.com/ifVL"><i class="icon-email"></i> Join our newsletter</a>
		</div>

		<div class="grid-2">
			<a class="h2" href="http://feeds.feedburner.com/pawsne"><i class="icon-rss"></i> Subscribe to our blog</a>
		</div>

		<div class="grid-2">
			<a class="h2" href="http://www.facebook.com/PAWSNewEngland"><i class="icon-facebook"></i> Like us on Facebook</a>
		</div>

	</article>


<?php get_footer(); ?>
