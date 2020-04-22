			<?php get_header(); ?>	
			<div id="main" class="ninecol first clearfix" role="main">
				
					    <?php if (is_category()) { ?>
						    <div class="archive-title">
						    <h1 class="h2"><?php single_cat_title(); ?></h1>
						    <?php echo category_description(); ?>
						    </div>
					    <?php } elseif (is_tag()) { ?> 
						    <div class="archive-title">
						    <h1 class="h2"><?php single_tag_title(); ?></h1>
						    <?php echo tag_description(); ?>
						    </div>
				
					    
					    <?php } elseif (is_author()) { 
					    	global $post;
					    	$author_id = $post->post_author;
					    ?>
						    <h1 class="archive-title h2">

						    	<span><?php echo get_the_author_meta('display_name', $author_id); ?>

						    </h1>

					    <?php } ?>

					    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					    		
					    <?php kr8_template_part( 'content', get_post_type() ); ?>
					    		
					
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
					
					    <?php else : ?>
					
    					    <article id="post-not-found" class="hentry clearfix">
    						    <header class="article-header">
    							    <h1><?php _e("Ups, keine Beiträge gefunden.", "kr8theme"); ?></h1>
    					    	</header>
    						    <section class="entry-content">
    							    <p><?php _e("Tut mir leid, aber hier gibt es keine Beiträge. Vielleicht hilft die Suche weiter.", "kr8theme"); ?></p>
									<?php get_search_form(); ?>
        						</section>
    				    	</article>
					
					    <?php endif; ?>
			
			
    		</div> <!-- end #main -->
    
			<?php get_sidebar(); ?>
			<?php get_footer(); ?>
