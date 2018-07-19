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

<div class="responsive-tabs comment-tabs">
	
	<?php if ( is_singular( 'post' ) ) { ?>
	<h2>Verwandte Artikel</h2>
	<div class="tab">
		 <?php  kr8_related_posts(); ?>

		
	</div>
	
	
	<?php 
		}
		if ( comments_open() ) : ?>
	<h2>Kommentar verfassen</h2>
	<div class="tab">
	<section id="respondbox" class="respond-form">
	
	<?php
			$comments_args = array(
				'comment_notes_before' =>__( ''),
				'title_reply'=>__( 'Artikel kommentieren', 'kr8theme'),
				'comment_notes_after' =>__( '<p class="required-info"><span class="req">*</span> Pflichtfeld</p><p>Mit der Nutzung dieses Formulars erklären Sie sich mit der Speicherung und Verarbeitung Ihrer Daten durch diese Website einverstanden. Weiteres entnehmen Sie bitte der <a href="' . site_url() . '/datenschutz/">Datenschutzerklärung</a>.</p>', 'kr8theme'),
				'comment_field'  => '<p class="comment-form-comment"><label for="comment">' . _x( 'Dein Kommentar<span class="req">*</span>', 'kr8theme' ) . 			'</label><br/><textarea id="comment" name="comment" tabindex="4" rows="8" placeholder="Dein Kommentar hier..."></textarea></p>',
				'label_submit'	=> __( 'Abschicken', 'kr8theme' )
				
			);
			
			comment_form($comments_args);
			
		?>
	
	</section>
	</div>
	
	<?php endif; // if you delete this the sky will fall on your head ?>	
	

<?php if ( have_comments() ) : ?>

	
	<h2><?php comments_number( '0', '1 Kommentar', '% Kommentare' ); ?></h2>
	<div class="tab">
	<ol class="commentlist">
		<?php wp_list_comments('callback=kr8_comments'); ?>
	</ol>
	
	<nav id="comment-nav">
		<ul class="clearfix">
	  		<li class="prev"><?php previous_comments_link() ?></li>
	  		<li class="next"><?php next_comments_link() ?></li>
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


</div><script>jQuery(document).ready(function() { RESPONSIVEUI.responsiveTabs(); }) </script>