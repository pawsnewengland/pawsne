<?php

/**
 * content-gmt_donate_invoices.php
 * Template for "Donation Invoice" custom post type content.
 */

?>

<article>

	<div class="container">

		<h1><?php the_title(); ?></h1>

		<?php
			// The page or post content
			the_content( '<p>' . __( 'Read More...', 'keel' ) . '</p>' );
		?>

		<?php
			// Add link to edit pages
			edit_post_link( __( 'Edit', 'keel' ), '<p>', '</p>' );
		?>
	</div>

</article>