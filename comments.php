<?php // Do not delete these lines
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

	/* This variable is for alternating comment background */
	$oddcomment = 'class="alt" ';
?>

<!-- You can start editing here. -->

<a name="comments"></a>
<?php if ($comments) : ?>
	<h2>Comments</h2>

	<ol class="commentlist">

	<?php foreach ($comments as $comment) : ?>

<!--FOR TRACKBACKS-->
<?php $comment_type = get_comment_type(); ?>
<?php if($comment_type == 'comment') { ?>
<!--END FOR TRACKBACKS-->

		<li <?php echo $oddcomment; ?>id="comment-<?php comment_ID() ?>">
			
			<div class="comment-bubble">
				<?php if ($comment->comment_approved == '0') : ?>
					<p>Your comment is awaiting moderation.</p>
				<?php endif; ?>
	
				<div id="comment-text"><?php echo get_avatar( $comment, $size = '40' ); ?> <b><?php comment_author_link() ?> says...</b></div>
<br>
				<?php comment_text() ?>

				<div id="comment-text"><i><?php comment_date('F jS, Y') ?> at <?php comment_time() ?></i></div>
			</div>
			
		</li>

	<?php
		/* Changes every other comment to a different class */
		$oddcomment = ( empty( $oddcomment ) ) ? 'class="alt" ' : '';
	?>

<!--FOR TRACKBACKS-->
<?php } else { $trackback = true; } /* End of is_comment statement */ ?>
<!--END FOR TRACKBACKS-->

	<?php endforeach; /* end for each comment */ ?>

	</ol>
<br><br>
<!--FOR TRACKBACKS-->
<?php if ($trackback == true) { ?>
<h3>Places that have linked here</h3>
<ol id="comment-text">
<?php foreach ($comments as $comment) : ?>
<?php $comment_type = get_comment_type(); ?>
<?php if($comment_type != 'comment') { ?>
<li><?php comment_author_link() ?></li>
<?php } ?>
<?php endforeach; ?>
</ol>
<?php } ?>
<!--END FOR TRACKBACKS-->
<br><br>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p>Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<h3 id="respond">Leave a Reply</h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p id="comment-post">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author">Name <?php if ($req) echo "(required)"; ?></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email">Mail (will not be published) <?php if ($req) echo "(required)"; ?></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url">Website</label></p>

<?php endif; ?>

<!--<p><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></p>-->

<p><textarea name="comment" id="comment" cols="72" rows="10" tabindex="4"></textarea></p>

<p id="comment-post"><strong>Looking for a place to add a personal image?</strong> Visit <a href="http://www.gravatar.com">gravatar.com</a> to get your own gravatar, a globally recognized avatar. After you're all setup, your personal image will be attached every time you comment.</p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" class="button" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>