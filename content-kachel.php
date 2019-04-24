								 <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
									<?php if ( has_post_thumbnail() ):
											$background = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
											$background = ($background) ? 'style="background-image:url(' . $background[0] . ')"' : ''; ?>
											<a href="	<?php the_permalink(); ?>" class="postimglist" <?php echo $background; ?>><?php the_post_thumbnail('large');  ?></a>
									<?php endif; ?>								 
								 
									 <header class="article-header">							
										 <h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1> 
									</header>
									
									<footer class="article-footer">
												<p class="byline"><a href="<?php the_permalink(); ?>" title="Permanenter Verweis zu <?php the_title(); ?>"><time class="updated" datetime="<?php echo the_time('c'); ?>"><?php the_time('j. F Y')?></time></a> • <?php the_category(', '); ?></p>
									</footer> 									
								
									<section class="entry-content"><?php the_excerpt(); ?></section>
								
								</article>