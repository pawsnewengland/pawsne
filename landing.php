<?php /*
Template Name: Landing
*/
get_header(); ?>

	<div class="row">
		<br>

		<h1 class="textcenter">We've saved the lives of over 3,500 dogs.</h1>

		<div class="span6">
			<h2>Here's how you can help...</h2>
			<br>

			<div class="link-help">
				<a href="<?php echo get_option('home'); ?>/adopt/">
					<p>
						<i class="icon home icon-help"></i>
						<span class="h2-help">Adopt</span><br>
						<span class="text-help">Give a deserving dog a new home.</span>
					</p>
				</a>
			</div>

			<div class="link-help">
				<a href="<?php echo get_option('home'); ?>/donate/">
					<p>
						<i class="icon heart icon-help"></i>
						<span class="h2-help">Donate</span><br>
						<span class="text-help">Help fund our life-saving work.</span>
					</p>
				</a>
			</div>

			<div class="link-help">
				<a href="<?php echo get_option('home'); ?>/volunteer/">
					<p>
						<i class="icon time icon-help"></i>
						<span class="h2-help">Volunteer</span><br>
						<span class="text-help">Share your time or just spread the word.</span>
					</p>
				</a>
			</div>
		</div>

		<div class="span6 textcenter">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/img/main.png" title="A PAWS Rescue Dog">
		</div>

	</div>


	<div class="dotted"></div>


	<div class="row textcenter">
		<br>
		<h1>How We Work</h1>

		<div class="span4">
			<i class="sprite-rescue"></i>
			<h2 class="nospace">1. Rescue</h2>
			<p>We rescue abandoned, neglected, and abused dogs from high-kill shelters.</p>
		</div>

		<div class="span4">
			<i class="sprite-rehab"></i>
			<h2 class="nospace">2. Rehabilitate</h2>
			<p>Next, we provide veterinary care and much needed TLC.</p>
		</div>

		<div class="span4">
			<i class="sprite-rehome"></i>
			<h2 class="nospace">3. Rehome</h2>
			<p>When they're ready, we place our dogs in safe and loving homes.</p>
		</div>

	</div>


	<div class="dotted"></div>


	<div class="row textcenter">
		<br>
		<h1>Get Free Updates</h1>

		<div class="span4">
			<a href="http://eepurl.com/ifVL"><h2 class="nospace"><i class="icon email"></i> Join our newsletter</h2></a>
		</div>

		<div class="span4">
			<a href="http://feeds.feedburner.com/pawsne"><h2 class="nospace"><i class="icon rss"></i> Subscribe to our blog</h2></a>
		</div>

		<div class="span4">
			<a href="http://www.facebook.com/PAWSNewEngland"><h2 class="nospace"><i class="icon facebook"></i> Like us on Facebook</h2></a>
		</div>

	</div>


<?php get_footer(); ?>