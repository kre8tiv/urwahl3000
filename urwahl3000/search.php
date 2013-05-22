<?php get_header(); ?>
			
			<div id="content">

				<div id="inner-content" class="wrap clearfix">
			
					<div id="main" class="eightcol first clearfix" role="main">
						<h1 class="archive-title"><span>Suchergebnisse für:</span> <?php echo esc_attr(get_search_query()); ?></h1>

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
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
					
					    <?php else : ?>
					
    					    <article id="post-not-found" class="hentry clearfix">
    					    	<header class="article-header">
    					    		<h1>Keine Ergebnisse.</h1>
    					    	</header>
    					    	<section class="entry-content">
    					    		<p>Es konnte kein Inhalt mit dem verwendeten Suchbegriff gefunden werden.</p>
    					    	</section>

    					    </article>
					
					    <?php endif; ?>
			
				    </div> <!-- end #main -->
    			
    			    <?php get_sidebar(); ?>
    			
    			</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>
