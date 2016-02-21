
					    
					    



								 <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
								    <?php if ( has_post_thumbnail() ): ?>
											<a href="	<?php the_permalink(); ?>" class="postimglist"><?php the_post_thumbnail('medium');  ?></a>
									<?php endif; ?>
									
																		
									<footer class="article-footer">
												
												<?php 	$posttags = get_the_tags();
											 	if ($posttags) {
											 		?><p class="byline"><?php
											 		foreach($posttags as $tag) {
											 		echo '' .$tag->name. ' '; 
										  			}
										  		?></p><?php	
												} else {
													
													?> <p class="byline"><?php the_category(', '); ?></p><?php
												}
										?>		
									</footer> 										 
								 
									 <header class="article-header">							
										 <h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1> 
									</header>
							
								
									<section class="entry-content"><?php the_excerpt(); ?></section>
								

								</article> 					    
				