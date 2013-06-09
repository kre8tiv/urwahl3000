
							<?php if ( has_post_thumbnail() ): ?>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large');  ?></a>
							<?php endif; ?>

					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
					    

						
						    <header class="article-header">							
							    <h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
							     <p class="byline">Veröffentlicht am <time class="updated" datetime="<?php echo the_time('c'); ?>"><?php the_time('j. F Y')?> um <?php the_time('H:i')?> Uhr.</time></p>
						    </header>
					
						    
						    		<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>		
										 <section class="entry-content clearfix">
											<?php the_excerpt(); ?>
										</section> 
							
										<?php else : ?>
										
										<section class="entry-content clearfix">											
											<?php the_content(); ?>
											<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'nilmini' ), 'after' => '</div>' ) ); ?>
										</section>
										
										<?php endif; ?>
						    
						
						    <footer class="article-footer">
    							<p class="tags"><?php the_tags('<span class="tags-title">' . __('', '') . '</span> ', ', ', ''); ?></p>
						    </footer> 
						    <?php // comments_template(); // uncomment if you want to use them ?>
						    </article> 
						    
						    <div class="sharewrap">
						    	<p class="calltoshare">Teile diesen Inhalt:</p>
						    	<div id="socialshareprivacy"></div>
						    </div>
						    