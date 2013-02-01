<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div id="lower-wrap">
	
	<div id="main-col">

                        <h1>
				<a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			</h1>

		<div class="post">

			<p><?php include (TEMPLATEPATH . '/searchform.php'); ?></p>
<br>
			<p><?php wp_nav_menu(); ?></p>

		</div>
	

	</div>

	<?php get_sidebar(); ?>
	
</div>

<?php get_footer(); ?>