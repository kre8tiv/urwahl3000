
							<?php if ( has_post_thumbnail() ): ?>
								<a href="<?php the_permalink(); ?>" class="postimg"><?php the_post_thumbnail('titelbild');  ?></a>
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
											<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Seiten:', 'kr8' ), 'after' => '</div>' ) ); ?>
										</section>
										
										<?php endif; ?>
						    
						
						    <footer class="article-footer">
						    	<p class="categories"><span class"cats-title">Kategorien:</span> <?php the_category(', '); ?></p>
    							<p class="tags"><?php the_tags('<span class="tags-title">' . __('Schlagworte:', '') . '</span> ', ', ', ''); ?></p>
						    </footer> 
						   
						   <!-- Autor -->
							<?php if ( get_post_format() ) : ?>	
							<?php else: ?>
								<?php if ( get_the_author_meta( 'description' ) ) : ?>
								<div class="author cleafix">
										
										<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
										<div class="author-description">
											<h3><?php the_author_posts_link(); ?></h3>
											<p><?php the_author_meta( 'description' ); ?></p>
										</div>		
									</div>
								<?php endif; ?>
							<?php endif; ?>
						   
						   
						    </article> 
						    
						    <div class="sharewrap">
						    	<p class="calltoshare">
						    		<a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink() ?>" class="twitter">Twitter</a>
									<a href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" class="facebook">Facebook</a>
									<a href="https://plus.google.com/share?url=<?php the_permalink() ?>" class="google">Google+</a>
						    	</p>
						    </div>
						    