<?php get_header(); ?>

<div class="row">
    <div class="grid-4">

        <article>
	        <header>
		        <h1>Sad puppy!</h1>
	        </header>

	        <p>Sorry, but the page you were looking for doesn't exist. It looks like this was the result of either:</p>

            <ol>
                <li>A mistyped address.</li>
                <li>An out-of-date link.</li>
            </ol>

            <p>Try searching for it?</p>

            <?php get_search_form(); ?>

        </article>

    </div>

    <div class="grid-2">
        <?php get_sidebar(); ?>
    </div>


<?php get_footer(); ?>
