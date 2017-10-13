<?php
/*
Template Name: Startseite mit Willkommenstext
*/
?>

			<?php get_header(); ?>	
			
			<?php if (!is_paged()) { ?>
				<div id="teaser" class="twelvecol first clearfix welcome">
					   
					    <?php while (have_posts()): the_post(); ?>
					
					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
					    
					    							
						    <header class="article-header">
							    <h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
						    </header>
					
						    <section class="entry-content clearfix" itemprop="articleBody">
							    <?php the_content(); ?>
							</section>
						    
					
					    </article>
					
					    <?php endwhile; ?>
						</div>
			<?php } ?>
						<div id="main" class="ninecol first clearfix" role="main">
						
						<?php wp_reset_query(); ?>

					    		
					    
						<?php 
							if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
							elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
							else { $paged = 1; }
							
							$postsperpage = get_option('posts_per_page');
							
							query_posts('posts_per_page='. $postsperpage .'&paged=' . $paged); 
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


