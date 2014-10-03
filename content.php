
					    
					    
					    <?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>	


								 <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
								    <?php if ( has_post_thumbnail() ): ?>
											<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium');  ?></a>
									<?php endif; ?>								 
								 
									 <header class="article-header">							
										 <h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1> 
									</header>
								
									<section class="entry-content"><?php the_excerpt(); ?></section>
								
									<footer class="article-footer">
												<p class="byline"><a href="<?php the_permalink(); ?>" title="Permanenter Verweis zu <?php the_title(); ?>"><time class="updated" datetime="<?php echo the_time('c'); ?>"><?php the_time('j. F Y')?>, um <?php the_time('H:i')?> Uhr</time></a> •  <?php comments_popup_link( 'Keine Kommentare', '1 Kommentar', '% Kommentare', 'comments-link', 'Kommentare sind geschlossen'); ?></p>
									</footer> 
								</article> 					    
					    
					    <?php else : ?>
					    
							    <?php if ( has_post_thumbnail() ): ?>
										<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large');  ?></a>
								<?php endif; ?>
								 <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
								 
									 <header class="article-header">							
										 <h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
										 <p class="byline"><a href="<?php the_permalink(); ?>" title="Permanenter Verweis zu <?php the_title(); ?>"><time class="updated" datetime="<?php echo the_time('c'); ?>"><?php the_time('j. F Y')?>, um <?php the_time('H:i')?> Uhr</time></a> •  <?php comments_popup_link( 'Keine Kommentare', '1 Kommentar', '% Kommentare', 'comments-link', 'Kommentare sind geschlossen'); ?></p>
									</header>
								
									<section class="entry-content clearfix"><?php the_content(); ?></section>
								
									<?php
										if( has_tag() ) {?>
									<footer class="article-footer">
												<p class="tags"><?php the_tags('Schlagworte: ', ' ', ''); ?></p>
									</footer> 
									<?php }?>
								</article> 
					    
					    <?php endif; ?>
					    

						  
		
		