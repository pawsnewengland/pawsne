<?php get_header(); ?>

<div id="lower-wrap">
	
	<div id="main-col">

		<h1>Uh oh!</h1>

		<p class="post">The page your looking for doesn't exist. You can either <a href="<?php echo get_option('home'); ?>/">go back to the homepage</a> and try again, or use the search box below.</p>

		<center><?php include (TEMPLATEPATH . '/searchform.php'); ?></center>
	
	</div>

	<?php get_sidebar(); ?>
	
</div>

<?php get_footer(); ?>