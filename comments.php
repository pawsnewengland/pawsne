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
					<p>Because your comment contained a link, it's awaiting moderation. As long as it's not spam, I'll approve asap!</p>
				<?php endif; ?>

				<div class="comment-info">

					<div class="alignleft"><?php echo get_avatar( $comment, $size = '40', $default = 'http://chrisferdinandi.com/test/wp-content/themes/PAWSNewEngland2/images/missing-gravatar.png' ); ?></div>

					<p class="comment-name"><?php comment_author_link() ?></p>
					<p class="comment-meta"><?php comment_date('F jS, Y') ?> at <?php comment_time() ?><span class="comment-text"><?php edit_comment_link('[Edit]', ' ', ''); ?></span></p>

<div class="clear"></div>

				</div>
	
				<div class="comment-text"><?php comment_text() ?></div>
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

<!--FOR TRACKBACKS-->
<?php if ($trackback == true) { ?>
<h3>Places that have linked here</h3>
<ol class="comment-text">
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

<h2 id="respond">Leave a Comment</h2>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p class="comment-text">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>

<?php else : ?>

<p><em>Your email address will not be published. Required fields are marked with an asterisk (<span style="color: #E0812A;">*</span>).</em></p>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author">Name <span style="color: #E0812A;"><?php if ($req) echo "*"; ?></span></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email">Email <span style="color: #E0812A;"><?php if ($req) echo "*"; ?></span></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url">Website</label></p>

<?php endif; ?>

<p><textarea name="comment" id="comment" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" class="button" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>

<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>