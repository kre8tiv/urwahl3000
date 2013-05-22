<?php

/************* COMMENT LAYOUT *********************/
		
// Comment Layout
function kr8_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
		
			   <?php echo get_avatar( $comment, 32 ); ?>
			    <!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>', 'kr8theme'), get_comment_author_link()) ?> 
				<time datetime="<?php echo comment_time('Y-m-j'); ?>">am <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time('j. F Y')?> um <?php comment_time('H:i')?> Uhr</a></time>
				<?php edit_comment_link(__('(Bearbeiten)', 'kr8theme'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
       			<div class="alert info">
          			<p><?php _e('Der Kommentar wartet auf Freischaltung.', 'kr8theme') ?></p>
          		</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
    <!-- </li> is added by WordPress automatically -->
<?php
}


add_filter( 'avatar_defaults', 'new_default_avatar' );

function new_default_avatar ( $avatar_defaults ) {
		//Set the URL where the image file for your avatar is located
		$new_avatar_url = get_bloginfo( 'template_directory' ) . '/lib/images/avatar.png';
		//Set the text that will appear to the right of your avatar in Settings>>Discussion
		$avatar_defaults[$new_avatar_url] = 'Urwahl3000';
		return $avatar_defaults;
}
?>