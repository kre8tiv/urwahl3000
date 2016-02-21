<?php
/*
Template Name: Startseite mit drei Kacheln (Sticky Posts)
*/
?>

			<?php get_header(); ?>	
			
			<?php if (!is_paged()) { ?>
				<div id="teaser" class="clearfix kacheln">
				
					<div class="eightcol first clearfix">
						<?php $args = array(
								'posts_per_page' => 1,
								'post__in'  => get_option( 'sticky_posts' ),
								'ignore_sticky_posts' => 1
							);
							query_posts($args);
						?>
						<?php while ( have_posts() ) : the_post(); ?>
					    	<?php get_template_part( 'content-kachel', get_post_format() ); ?>
					    <?php endwhile; ?>	
					 
					</div>
					
					<div class="fourcol last clearfix">
						<?php $args2 = array(
								'posts_per_page' => 2,
								'post__in'  => get_option( 'sticky_posts' ),
								'offset' => 1,
								'ignore_sticky_posts' => 1
							);
							query_posts($args2);
						?>
						<?php while ( have_posts() ) : the_post(); ?>
					    	<?php get_template_part( 'content-kachel', get_post_format() ); ?>
					    <?php endwhile; ?>	
					 
					</div>					
					

			</div>
			<?php } ?>
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
					    	<?php get_template_part( 'content', get_post_format() ); ?>
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


