<?php
/*
Template Name: Startseite mit drei Kacheln (Sticky Posts)
*/
?>

			<?php get_header(); ?>	
			
			<?php 	if (!is_paged()) { 
				
						$stickyposts = get_posts(array(
							'posts_per_page'	=> 3,
							'post__in'			=> get_option( 'sticky_posts' ),
						));
						if(count($stickyposts) < 3) {
							$nonstickyposts = get_posts(array(
								'posts_per_page'	=> 3 - count($stickyposts),
							));
							$stickyposts = array_merge($stickyposts, $nonstickyposts);
						}
						
						if($stickyposts) : ?>
	
							<div id="teaser" class="clearfix kacheln kacheln-neu">
								
			<?php 				global $post;
								$post = $stickyposts[0];
								setup_postdata( $post ); ?>
									<div class="eightcol first clearfix">
										<?php kr8_template_part( 'content-kachel', get_post_format() ); ?>
					 				</div>
			<?php 				unset($stickyposts[0]);
								wp_reset_postdata(); ?>
								
			<?php 				if($stickyposts) : ?>
									<div class="fourcol last clearfix">
			<?php 						foreach($stickyposts as $stickypost) :
											global $post;
											$post = $stickypost;
											setup_postdata( $post ); ?>
											<?php kr8_template_part( 'content-kachel', get_post_format() ); ?>
			<?php 						endforeach;
										wp_reset_postdata(); ?>
									</div>
			<?php				endif; ?>
							</div>
			<?php	 	endif; 
					} ?>
				  
						<div id="main" class="ninecol first clearfix" role="main">
						
						<?php wp_reset_query(); ?>

    		
					    
						<?php 
							if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
							elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
							else { $paged = 1; }
							
							
							
							
							$postsperpage = get_option('posts_per_page');
							
							
							?>
							
							
							
						<?php $args3 = array(
								'posts_per_page' => $postsperpage,
								'paged' => $paged,
								'post__not_in'  => get_option( 'sticky_posts' ),
								'ignore_sticky_posts' => 1
							);
							query_posts($args3);
						?>
					    		
    		
    					<?php while ( have_posts() ) : the_post(); ?>
					    	<?php kr8_template_part( 'content', get_post_format() ); ?>
					    <?php endwhile; ?>	
					    
					    
					     <?php if (function_exists('kr8_page_navi')) { ?>
						        <?php kr8_page_navi(); ?>
					        <?php } else { ?>
						        <nav class="wp-prev-next">
							        <ul class="clearfix">
								        <li class="prev-link"><?php next_posts_link(__('&laquo; Ältere Beiträge', "kr8theme")) ?></li>
								        <li class="next-link"><?php previous_posts_link(__('Neuere Beiträge &raquo;', "kr8theme")) ?></li>
							        </ul>
					    	    </nav>
					        <?php } ?>

			
			
    		</div> <!-- end #main -->
    
			<?php get_sidebar(); ?>
			<?php get_footer(); ?>


