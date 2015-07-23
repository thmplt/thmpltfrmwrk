<?php if(!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) : ?>  	
	<?php die('You can not access this page directly!'); ?>  
<?php endif; ?>

<?php if(!empty($post->post_password)) : ?>
  	<?php if($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
		<p>This post is password protected. Enter the password to view comments.</p>
  	<?php endif; ?>
<?php endif; ?>

<?php if($comments) : ?>

<hr />
<div id='comments' >
	<h3>Responses:</h3>
  	<ol>
    	<?php foreach($comments as $comment) : ?>
  		<li id="comment-<?php comment_ID(); ?>">
  			<?php if ($comment->comment_approved == '0') : ?>
  				<p>Your comment is awaiting approval</p>
  			<?php endif; ?>
  			<?php comment_text(); ?>
  			<p class="meta"><?php comment_type(); ?> by <?php comment_author_link(); ?> on <?php comment_date(); ?> at <?php comment_time(); ?></p>
  		</li>
		<?php endforeach; ?>
	</ol>
</div>
<?php else : ?>
	<!-- <p>No comments yet</p> -->
<?php endif; ?>

<?php if(comments_open()) : ?>
<div id='respond' >

	<h4>Leave a response</h4>

	<?php if(get_option('comment_registration') && !$user_ID) : ?>
    
		<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p><?php else : ?>
        
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			<?php if($user_ID) : ?>
				<p>Logged in as 
                <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. 
                <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Log out &raquo;</a></p>
			<?php else : ?>
            
				<p>
	                <label for="author"><small>Name <?php if($req) echo "(required)"; ?></small></label>
                	<input type="text" name="author" id="author" size="22" tabindex="1" 
                    class="form-control" placeholder="Name" value="<?php echo $comment_author; ?>"/>
				</p>
				<p>
					<label for="email"><small>Mail (will not be published) <?php if($req) echo "(required)"; ?></small></label>                
                	<input type="text" name="email" id="email" size="22" tabindex="2" 
                    class="form-control" placeholder="Email" value="<?php echo $comment_author_email; ?>"/>
				</p>
				<p>
					<label for="url"><small>Website</small></label>                
                	<input type="text" name="url" id="url" size="22" tabindex="3" 
                    class="form-control" placeholder="Website" value="<?php echo $comment_author_url; ?>"/>
				</p>
                
			<?php endif; ?>
			<p>
            	<textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4" class="form-control"></textarea>
			</p>
			<p>
            	<input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
				<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
			</p>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
</div>        
	<?php endif; ?>
<?php else : ?>
	<p>The comments are closed.</p>
<?php endif; ?>