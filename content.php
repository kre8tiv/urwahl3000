								<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
									<?php if ( has_post_thumbnail() ): ?>
											<div class="postimglist maybeImgCopyright">
												<a href="<?php the_permalink(); ?>" class="postimglist-a"><?php the_post_thumbnail('medium'); ?></a>
												<?php 	$imgcopyright = get_post_meta(get_post_thumbnail_id(), '_copyright', true);
														if ($imgcopyright) { ?>
															<p class="caption imgCopyright"><?php echo make_clickable($imgcopyright);?></p>
												<?php 	} ?>
											</div>
									<?php endif; ?>
									
									<?php do_action('kr8_content_vor_article_header_and_footer'); ?>
									
									<div class="article-header-and-footer">
									
										<?php do_action('kr8_content_vor_article_footer'); ?>
										
										<footer class="article-footer">
											
											<?php do_action('kr8_content_im_article_footer1'); ?>
											
											<p class="byline">
												
												<?php if(apply_filters('kr8_content_im_article_byline_tags', true)) { echo get_the_term_list( get_the_ID(), 'post_tag', '<i class="fas fa-tags"></i> ', ', ', '<span style="width:10px;display:inline-block;"></span>' ); } ?>
														
												<?php if(apply_filters('kr8_content_im_article_byline_categories', true)) { echo get_the_term_list( get_the_ID(), 'category', '<i class="fas fa-folder-open"></i> ', ', ', '<span style="width:10px;display:inline-block;"></span>' ); } ?>
												
												<?php if(apply_filters('kr8_content_im_article_byline_date', true)) { echo apply_filters('kr8_content_im_article_byline_date_content', get_the_time('j. F Y')); } ?>
												
											</p>
	
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
									
									</div>
									
									<?php do_action('kr8_content_nach_article_header_and_footer'); ?>
									
									<?php do_action('kr8_content_vor_article_content'); ?>
								
									<section class="entry-content">

										<?php do_action('kr8_content_im_article_content1'); ?>

										<?php the_excerpt(); ?>

										<?php do_action('kr8_content_im_article_content2'); ?>
										
										<p><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="readmore">Weiterlesen »</a></p>

										<?php do_action('kr8_content_im_article_content3'); ?>
										
									</section>
									
									<?php do_action('kr8_content_nach_article_content'); ?>
								
								</article>