<?php get_header(); ?>

<div class="row">
	<div class="grid-4">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article>

				<header>
					<h1 class="no-space-bottom"><?php the_title(); ?></h1>
					<aside>
						<p class="text-muted"><time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_time('F j, Y') ?></time><?php edit_post_link('[Edit]', ' - ', ''); ?></p>
					</aside>
				</header>

				<?php the_content(); ?>

				<p>
					<a class="btn btn-tweet" rel="nofollow" target="_blank" href="http://twitter.com/?status=<?php the_title(); ?>%20by%20@pawsnewengland%20<?php echo the_permalink(); ?>">
						<i class="icon icon-twitter icon-inherit-color"></i>
						Tweet
					</a>
					<a class="btn btn-fb" rel="nofollow" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>&t=<?php the_title(); ?>%20">
						<i class="icon icon-facebook icon-inherit-color"></i>
						Like
					</a>
				</p>

			</article>

		<?php endwhile; endif; ?>

	</div>

	<div class="grid-2">
		<?php get_sidebar(); ?>
	</div>

</div>


<?php get_footer(); ?>
