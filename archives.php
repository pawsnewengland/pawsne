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
<br>

<h2>By Tags:</h2>

	 <div class="post"><?php wp_tag_cloud(''); ?></div>

<h2>By Date:</h2>
<ul class="post">
	<?php wp_get_archives('type=monthly'); ?>
</ul>
	
	</div>

	<?php get_sidebar(); ?>
	
</div>

<?php get_footer(); ?>