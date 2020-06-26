					<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>		

						<?php if ( has_post_thumbnail() ): ?>
							<?php 	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
									$url = $thumb['0']; ?>
									<a href="<?php echo $url ?>" class="postimg fancybox"><?php the_post_thumbnail('titelbild');  ?></a>
									<?php 	$imgexc = get_post(get_post_thumbnail_id())->post_excerpt;
											if ($imgexc != "") { ?>
												<p class="caption"><span><i class="fas fa-image"></i> <?php echo $imgexc;?></span></p>
									<?php 	} ?>
						<?php endif; ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
							<header class="article-header">
								<h2 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
							</header>

							<section class="entry-content clearfix" itemprop="articleBody">
								<?php the_excerpt(); ?>

								<p><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="readmore">Weiterlesen »</a></p>
							</section>
								
						</article>
						
					<?php else : ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
							<header class="article-header">
								<h2 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
							</header>

							<section class="entry-content clearfix" itemprop="articleBody">
								<?php the_excerpt(); ?>

								<p><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="readmore">Weiterlesen »</a></p>
							</section>
					
						</article>
						
					<?php endif; ?>
