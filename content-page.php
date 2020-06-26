					<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>		

						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
							<?php if ( has_post_thumbnail() ): ?>
									<div class="postimglist maybeImgCopyright">
										<a href="<?php the_permalink(); ?>" class="postimglist-a"><?php the_post_thumbnail('medium'); ?></a>
										<?php 	$imgcopyright = get_post_meta(get_post_thumbnail_id(), '_copyright', true);
												if ($imgcopyright) { ?>
													<p class="caption imgCopyright"><?php echo make_clickable($imgcopyright);?></p>
										<?php 	} ?>
									</div>
							<?php endif; ?>

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
