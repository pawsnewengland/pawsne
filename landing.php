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
							<svg class="url-action-icon icon-home" role="presentation"><use xlink:href="#home"></use></svg>
							<span class="url-action-header h2">Adopt</span><br>
							Give a deserving dog a new home.
						</a>
					</p>
				</div>

				<div class="group">
					<p>
						<a class="url-action" href="<?php echo get_option('home'); ?>/donate/">
							<svg class="url-action-icon icon-heart" role="presentation"><use xlink:href="#heart"></use></svg>
							<span class="url-action-header h2">Donate</span><br>
							Help fund our life-saving work.
						</a>
					</p>
				</div>

				<div class="group">
					<p>
						<a class="url-action" href="<?php echo get_option('home'); ?>/volunteer/">
							<svg class="url-action-icon icon-time" role="presentation"><use xlink:href="#time"></use></svg>
							<span class="url-action-header h2">Volunteer</span><br>
							Share your time or just spread the word.
						</a>
					</p>
				</div>

			</div>

			<div class="grid-3 text-center">
				<img class="hide-mobile" src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/main.png" height="346" width="459" alt="A photo of a PAWS rescue dog">
			</div>

		</div>

		<hr>

	</article>


	<article>
		<div class="row">
			<div class="grid-1 offset-1 text-center">
				<a href="http://www.amazon.com/Missing-Canine-Shara-Puglisi-Katsos/dp/0977639657/ref=as_li_ss_til?tag=paneen-20&linkCode=w01&creativeASIN=0977639657"><img class="space-top" src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/campaigns/dig-cover-small.jpg"></a>
			</div>
			<div class="grid-3">
				<h1>The Doggie Investigation Gang</h1>
				<p>Doggie Investigation Gang is a book series created and authored by PAWS supporter Shara Puglisi Katsos. Inspired by three real-life dogs, all profits from sales of the first book of the series will be donated to PAWS New England.</p>
				<p class="no-space-bottom text-center">
					<a class="btn" href="http://www.amazon.com/Missing-Canine-Shara-Puglisi-Katsos/dp/0977639657/ref=as_li_ss_til?tag=paneen-20&linkCode=w01&creativeASIN=0977639657">Buy It Now</a><br>
					<a href="http://www.pawsnewengland.com/now-on-sale-the-doggie-investigation-gang/">Or learn more...</a>
				</p>
			</div>
		</div>

		<hr>
	</article>


	<article class="row text-center">
		<h2 class="h1">How We Work</h2>

		<div class="grid-2">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/rescue.jpg" height="175" width="175" title="">
			<h2 class="nospace">1. Rescue</h2>
			<p>We rescue abandoned, neglected, and abused dogs from high-kill shelters.</p>
		</div>

		<div class="grid-2">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/rehab.jpg" height="175" width="175" title="">
			<h2 class="nospace">2. Rehabilitate</h2>
			<p>Next, we provide veterinary care and much needed TLC.</p>
		</div>

		<div class="grid-2">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/dist/img/rehome.jpg" height="175" width="175" title="">
			<h2 class="nospace">3. Rehome</h2>
			<p>When they're ready, we place our dogs in safe and loving homes.</p>
		</div>

	</article>


	<hr>


	<article class="row text-center">

		<h2 class="h1">Stay Connected</h2>

		<div class="text-center">
			<a class="icon-grid" href="http://www.facebook.com/PAWSNewEngland">
				<svg class="icon icon-large icon-facebook" role="img" title="Facebook"><use xlink:href="#facebook">Facebook</use></svg>
			</a>
			<a class="icon-grid" href="https://twitter.com/pawsnewengland">
				<svg class="icon icon-large icon-twitter" role="img" title="Twitter"><use xlink:href="#twitter">Twitter</use></svg>
			</a>
			<a class="icon-grid" href="http://instagram.com/pawsnewengland">
				<svg class="icon icon-large icon-instagram" role="img" title="Instagram"><use xlink:href="#instagram">Instagram</use></svg>
			</a>
			<a class="icon-grid" href="http://eepurl.com/ifVL">
				<svg class="icon icon-large icon-email" role="img" title="Newsletter"><use xlink:href="#email">Newsletter</use></svg>
			</a>
			<a class="icon-grid" href="http://feeds.feedburner.com/pawsne">
				<svg class="icon icon-large icon-rss" role="img" title="RSS"><use xlink:href="#rss">RSS</use></svg>
			</a>
		</div>

	</article>


<?php get_footer(); ?>
