<?php

/* ======================================================================
	nav-main.php
	Template for site navigation.
 * ====================================================================== */

?>

<header class="nav-bg">
	<nav class="nav-wrap container">
		<a class="logo" href="<?php echo site_url(); ?>">
			<span class="icon-fallback-text">PAWS New England</span>
			<i class="icon icon-logo icon-inherit-color"></i>
		</a>
		<button class="btn nav-toggle" data-nav-toggle="#nav-menu">
			<span class="screen-reader">Toggle navigation</span>
			<i class="icon-bar"></i>
			<i class="icon-bar"></i>
			<i class="icon-bar"></i>
			<span class="screen-reader">Menu Toggle</span>
		</button>
		<div class="nav-collapse" id="nav-menu">
			<ul class="nav group">
				<li><a href="<?php echo site_url(); ?>/">Home</a></li>
				<li class="dropdown">
					<a href="<?php echo site_url(); ?>/about/">
						About
						<span class="text-show-more">+</span>
						<span class="text-show-less">&ndash;</span>
					</a>
					<div class="dropdown-menu">
						<ul>
							<li><a href="<?php echo site_url(); ?>/our-story/">Our Story</a></li>
							<li><a href="<?php echo site_url(); ?>/financials/">Financials</a></li>
							<li><a href="<?php echo site_url(); ?>/hbo/">HBO Special</a></li>
							<li><a href="<?php echo site_url(); ?>/rehoming-your-dog/">Rehome Your Dog</a></li>
							<li><a href="<?php echo site_url(); ?>/contact/">Contact</a></li>
						</ul>
					</div>
				</li>
				<li class="dropdown">
					<a href="<?php echo site_url(); ?>/adopt/">
						Adopt
						<span class="text-show-more">+</span>
						<span class="text-show-less">&ndash;</span>
					</a>
					<div class="dropdown-menu">
						<ul>
							<li><a href="<?php echo site_url(); ?>/adopt/">The Process</a></li>
							<li><a href="<?php echo site_url(); ?>/our-dogs/">Our Dogs</a></li>
							<li><a href="<?php echo site_url(); ?>/adoption-form/">Adoption Form</a></li>
							<li><a href="<?php echo site_url(); ?>/resources/">Resources</a></li>
						</ul>
					</div>
				</li>
				<li class="dropdown">
					<a href="<?php echo site_url(); ?>/help/">
						How to Help
						<span class="text-show-more">+</span>
						<span class="text-show-less">&ndash;</span>
					</a>
					<div class="dropdown-menu">
						<ul>
							<li><a href="<?php echo site_url(); ?>/donate/">Donate</a></li>
							<li><a href="<?php echo site_url(); ?>/volunteer/">Volunteer</a></li>
							<li><a href="<?php echo site_url(); ?>/foster/">Foster</a></li>
							<li><a href="<?php echo site_url(); ?>/paws-harness-program/">Buy a Harness</a></li>
							<li><a target="_blank" href="http://skreened.com/pawsnewengland/">Buy PAWS Gear</li>
							<li><a href="<?php echo site_url(); ?>/goodsearch/">Browse the Web</a></li>
							<li><a href="<?php echo site_url(); ?>/owen-fund/">The Owen Fund</a></li>
							<li><a href="<?php echo site_url(); ?>/paws-partners/">Support Our Partners</a></li>
						</ul>
					</div>
				</li>
				<li><a href="<?php echo site_url(); ?>/news/">Blog</a></li>
			</ul>
		</div>
	</nav>
</header>