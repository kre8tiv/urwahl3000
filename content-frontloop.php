								<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix frontloop'); ?> role="article">
									<?php if ( has_post_thumbnail() ): ?>
											<a href="<?php the_permalink(); ?>" class="postimglist"><?php the_post_thumbnail('medium');  ?></a>
									<?php endif; ?>
									
									<?php do_action('kr8_content_vor_article_footer'); ?>
									
									<footer class="article-footer">
										
										<?php do_action('kr8_content_im_article_footer1'); ?>
												
										<p class="pseudobyline"><?php the_category(', '); ?></p>
																				
										<?php do_action('kr8_content_im_article_footer2'); ?>
											
									</footer> 										 

									<?php do_action('kr8_content_nach_article_footer'); ?>
								 
									<?php do_action('kr8_content_vor_article_header'); ?>

									<header class="article-header">							

										<?php do_action('kr8_content_im_article_header1'); ?>

										<h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1> 

										<?php do_action('kr8_content_im_article_header2'); ?>

									</header>

									<?php do_action('kr8_content_nach_article_header'); ?>
									
									<?php do_action('kr8_content_vor_article_content'); ?>
								
									<section class="entry-content">

										<?php do_action('kr8_content_im_article_content1'); ?>

										<?php the_excerpt(); ?>

										<?php do_action('kr8_content_im_article_content2'); ?>
										
										<p><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="readmore">Weiterlesen »</a></p>

										<?php do_action('kr8_content_im_article_content3'); ?>
										
									</section>
									
									<?php do_action('kr8_content_nach_article_content'); ?>
								
								</article>