<?php 
    // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}
?>

<!-- You can start editing here. -->
<h2 id="comments"><?php comments_number( 'Leave a Comment', '1 Comment', '% Comments' ); ?></h2>

<?php if ($comments) : ?>

	<ul class="unstyled">

	    <?php foreach ($comments as $comment) : ?>

	        <li id="comment-<?php comment_ID() ?>">

		        <hr class="space-bottom-small">
		
		        <?php if ($comment->comment_approved == '0') : ?>
			        <p>Your comment is being held for moderation.</p>
		        <?php endif; ?>

		        <article>
			        <header>
				        <h3 class="no-space-bottom"><?php comment_author_link() ?></h3>
				        <aside>
					        <p><span class="text-muted text-small"><?php comment_date('F jS, Y') ?><?php edit_comment_link('[Edit]', ' - ', ''); ?></span></p>
				        </aside>
			        </header>

			        <?php comment_text() ?>
		        <article>
		
	        </li>

		<?php endforeach; // end for each comment ?>

	</ul>



<?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p>Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

    <h2 id="respond">Leave a Reply</h2>

    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	    <!-- If user must be logged in to comment -->
    <?php else : ?>
    <form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">

	    <?php if ( $user_ID ) : ?>

		    <p class="muted"><em>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></em></p>

	    <?php else : ?>
	        <div class="row">
	            <div class="grid-4">
		            <label for="author">Your Name</label>
		            <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" required>
		        </div>
		    </div>

	        <div class="row">
	            <div class="grid-4">
		            <label for="email">Your Email</label>
		            <input type="email" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" required>
		        </div>
		    </div>

	        <div class="row">
	            <div class="grid-4">
		            <label for="url">Your Website (optional)</label>
		            <input type="url" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" >
		        </div>
		    </div>
	    <?php endif; ?>

		    <textarea name="comment" id="comment" tabindex="4" required></textarea>

		    <button name="submit" type="submit" class="btn btn-large" id="submit" tabindex="5">Submit Comment</button>
		    <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />

		    <?php do_action('comment_form', $post->ID); ?>

    </form>

    <?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
