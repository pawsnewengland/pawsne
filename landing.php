<?php /*
Template Name: Landing
*/
get_header(); ?>

    <div class="alert"><strong>New:</strong> The Owen Fund was created to honor the spirit and bravery of a young pup who beat the odds. <a class="scroll" href="#owen-fund">Learn more...</a></div>

	<div class="row">

		<h1 class="text-hero text-center">We save lives, one dog at a time.</h1>

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


	<div class="row" id="owen-fund">
	    <br>

		<div class="grid-3">
            <p><iframe src="http://player.vimeo.com/video/69292438?byline=0&amp;portrait=0" width="560" height="420" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></p>
		</div>

		<div class="grid-3">
		    <h1>The Owen Fund</h1>
            <p>The Owen Fund was created to honor the inspiring spirit and bravery of this young pup who beat the odds.</p>
            <p><a class="btn btn-large" href="<?php echo get_option('home'); ?>/owen-fund/">Learn More</a>
		</div>

	</div>


	<hr>


	<div class="row text-center">
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

	</div>


	<hr>


	<div class="row text-center">

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

	</div>


<?php get_footer(); ?>
