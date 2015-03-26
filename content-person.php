								 <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
								    <?php if ( has_post_thumbnail() ): ?>
											<a href="	<?php the_permalink(); ?>" class="postimglist"><?php the_post_thumbnail('medium');  ?></a>
									<?php endif; ?>								 
								 
									 <header class="article-header">							
										 <h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
										 <?php $amt =  get_post_meta( $post->ID, 'kr8mb_pers_pos_amt', true );   
								if (! empty ($amt )){ ?><h2 class="h3"><?php echo $amt; ?></h2><?php } ?>
									</header>
																	
								
									<section class="entry-content"><?php $excerpt =  get_post_meta( $post->ID, 'kr8mb_pers_excerpt', true );   
												if (! empty ($excerpt )){ ?><p><?php echo $excerpt; ?></p><?php } ?></section>
								

								</article> 	