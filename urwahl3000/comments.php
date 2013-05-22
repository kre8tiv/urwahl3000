<?php
/*
The comments page
*/

// Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

  if ( post_password_required() ) { ?>
  	<div class="alert help">
    	<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.", "kr8theme"); ?></p>
  	</div>
  <?php
    return;
  }
?>

<!-- You can start editing here. -->

<ul class='tabs'>
    <?php if ( have_comments() ) : ?><li><a href='#tab1'>Kommentare <span><?php comments_number( '0', '1', '%' ); ?></span></a></li><?php endif; ?>
    <?php if ( comments_open() ) : ?><li><a href='#tab2'>Kommentar verfassen</a></li><?php endif; ?>
</ul>


<?php if ( have_comments() ) : ?>
<div id='tab1'>
	

	<nav id="comment-nav">
		<ul class="clearfix">
	  		<li><?php previous_comments_link() ?></li>
	  		<li><?php next_comments_link() ?></li>
	 	</ul>
	</nav>
	
	<ol class="commentlist">
		<?php wp_list_comments('type=comment&callback=kr8_comments'); ?>
	</ol>
	
	<nav id="comment-nav">
		<ul class="clearfix">
	  		<li><?php previous_comments_link() ?></li>
	  		<li><?php next_comments_link() ?></li>
		</ul>
	</nav>
</div>
	<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
    	<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>
	
	<!-- If comments are closed. -->
	<!--p class="nocomments"><?php _e("Comments are closed.", "kr8theme"); ?></p-->

	<?php endif; ?>

<?php endif; ?>


<?php if ( comments_open() ) : ?>
<div id='tab2'>
<section id="respond" class="respond-form">

	<h3 id="comment-form-title" class="h2"><?php comment_form_title( __('Artikel kommentieren', 'kr8theme'), __('Dein Kommentar zu %s', 'kr8theme' )); ?></h3>

	<div id="cancel-comment-reply">
		<p class="small"><?php cancel_comment_reply_link(); ?></p>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
  	<div class="alert help">
  		<p><?php printf( __('You must be %1$slogged in%2$s to post a comment.', 'kr8theme'), '<a href="<?php echo wp_login_url( get_permalink() ); ?>">', '</a>' ); ?></p>
  	</div>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

	<?php if ( is_user_logged_in() ) : ?>

	<p class="comments-logged-in-as"><?php _e("Logged in as", "kr8theme"); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e("Log out of this account", "kr8theme"); ?>"><?php _e("Log out", "kr8theme"); ?> <?php _e("&raquo;", "kr8theme"); ?></a></p>

	<?php else : ?>
	
	<ul id="comment-form-elements" class="clearfix">
		
		<li>
		  <label for="author"><?php _e("Name", "kr8theme"); ?><span class="req"><?php if ($req) _e("*"); ?></span></label>
		  <input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" placeholder="<?php _e('Name', 'kr8theme'); ?>" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
		</li>
		
		<li>
		  <label for="email"><?php _e("Mail", "kr8theme"); ?><span class="req"><?php if ($req) _e("*"); ?></span> <small><?php _e("(Wird nicht veröffentlicht)", "kr8theme"); ?></small></label>
		  <input type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="<?php _e('E-Mail', 'kr8theme'); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
		  
		</li>
		
		<li>
		  <label for="url"><?php _e("Website", "kr8theme"); ?></label>
		  <input type="url" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" placeholder="<?php _e('Website', 'kr8theme'); ?>" tabindex="3" />
		</li>
		
	</ul>

	<?php endif; ?>
	
	<p><textarea name="comment" id="comment" placeholder="<?php _e('Dein Kommentar hier...', 'kr8theme'); ?>" tabindex="4"></textarea></p>
	
	<p>
	  <input name="submit" type="submit" id="submit" class="button" tabindex="5" value="<?php _e('Abschicken', 'kr8theme'); ?>" />
	  <?php comment_id_fields(); ?>
	</p>
	
	
	
	
	<?php do_action('comment_form', $post->ID); ?>
	<p class="required-info">* Pflichtfeld</p>
	</form>
	
	<?php endif; // If registration required and not logged in ?>
</section>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>
