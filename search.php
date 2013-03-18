<?php get_header(); ?>

<div class="row">
    <div class="grid-4">

        <?php if (have_posts()) : ?>
	        <header>
		        <h1>Search Results for "<?php the_search_query(); ?>"</h1>
		        <hr>
	        </header>

	        <?php while (have_posts()) : the_post(); ?>

		        <article>

			        <header>
				        <h1 class="no-space-bottom"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
				        <aside>
					        <p class="text-muted"><time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_time('F j, Y') ?></time><?php edit_post_link('[Edit]', ' - ', ''); ?></p>
				        </aside>
			        </header>

			        <?php the_content('<p>Keep reading...</p>'); ?>

                    <p>
	                    <a class="btn btn-tweet" rel="nofollow" target="_blank" href="http://twitter.com/?status=<?php the_title(); ?>%20<?php echo the_permalink(); ?>"><i class="icon-twitter"></i> Tweet</a>
	                    <a class="btn btn-fb" rel="nofollow" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>&t=<?php the_title(); ?>"><i class="icon-facebook"></i> Share</a>
                        <a class="btn btn-comment" href="<?php comments_link(); ?>"><i class="icon-chat"></i> <?php comments_number( 'Comment', '1 Comment', '% Comments' ); ?></a>
                    </p>

		        </article>

		        <hr>

	        <?php endwhile; ?>


	        <!-- Previous/Next page navigation -->
	        <nav>
		        <p><?php posts_nav_link( '&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;', '&larr; Newer', 'Older &rarr;' ); ?></p>
	        </nav>


        <?php else : ?>
	        <article>
		        <header>
			        <h1>No Results Found for "<?php the_search_query(); ?>"</h1>
		        </header>
		        <p>Sorry, your search didn't turn up any results. Maybe try using different keywords?</p>

		        <?php echo pne_wpsearch(); ?>
	        </article>
        <?php endif; ?>

    </div>

    <div class="grid-2">
        <?php get_sidebar(); ?>
    </div>

</div>
	

<?php get_footer(); ?>
