
						<?php if ( has_post_thumbnail() ): ?>
							<?php 	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
									$url = $thumb['0']; ?>
									<a href="<?php echo $url ?>" class="postimg fancybox"><?php the_post_thumbnail('titelbild');  ?></a>
									<?php 	$imgexc = get_post(get_post_thumbnail_id())->post_excerpt;
											if ($imgexc != "") { ?>
												<p class="caption"><span><i class="fa fa-picture-o"></i> <?php echo $imgexc;?></span></p>
									<?php 	} ?>
						<?php endif; ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
						
							<?php do_action('kr8_contentsingle_vor_article_header'); ?>

							<header class="article-header">							

								<?php do_action('kr8_contentsingle_im_article_header1'); ?>

								<p class="byline">
											
									<?php if(apply_filters('kr8_contentsingle_im_article_byline_categories', true)) { echo get_the_term_list( get_the_ID(), 'category', '<i class="fa fa-folder-open"></i> ', ', ', '<span style="width:10px;display:inline-block;"></span>' ); } ?>
									
									<?php if(apply_filters('kr8_contentsingle_im_article_byline_tags', true)) { echo get_the_term_list( get_the_ID(), 'post_tag', '<i class="fa fa-tags"></i> ', ', ', '<span style="width:10px;display:inline-block;"></span>' ); } ?>
									
									<?php if(apply_filters('kr8_contentsingle_im_article_byline_date', true)) { the_time('j. F Y'); } ?>
									
								</p>

								<?php do_action('kr8_contentsingle_im_article_header2'); ?>

								<h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

								<?php do_action('kr8_contentsingle_im_article_header3'); ?>
								 
							</header>

							<?php do_action('kr8_contentsingle_nach_article_header'); ?>
							
							<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>		

								<?php do_action('kr8_contentsingle_vor_article_content'); ?>

								<section class="entry-content clearfix">
									<?php do_action('kr8_contentsingle_im_article_content1'); ?>

									<?php the_excerpt(); ?>

									<?php do_action('kr8_contentsingle_im_article_content2'); ?>

									<p><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="readmore">Weiterlesen »</a></p>

									<?php do_action('kr8_contentsingle_im_article_content3'); ?>
								</section> 

								<?php do_action('kr8_contentsingle_nach_article_content'); ?>
							
							<?php else : ?>
										
								<?php do_action('kr8_contentsingle_vor_article_content'); ?>

								<section class="entry-content clearfix">											

									<?php do_action('kr8_contentsingle_im_article_content1'); ?>

									<?php the_content(); ?>

									<?php do_action('kr8_contentsingle_im_article_content2'); ?>

									<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Seiten:', 'kr8' ), 'after' => '</div>' ) ); ?>

									<?php do_action('kr8_contentsingle_im_article_content3'); ?>
								</section>

								<?php do_action('kr8_contentsingle_nach_article_content'); ?>
							
							<?php endif; ?>
							
							<?php do_action('kr8_contentsingle_vor_article_footer'); ?>
						
							<footer class="article-footer">
	
								<?php do_action('kr8_contentsingle_im_article_footer1'); ?>

							</footer> 

							<?php do_action('kr8_contentsingle_nach_article_footer'); ?>
						   
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
							
							<?php if(apply_filters( 'kr8_contentsingle_share', true )) : ?>
							<div class="sharewrap">
								<p class="calltoshare">
									<a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink() ?>" class="twitter" title="Artikel twittern">Twitter</a>
									<a href="whatsapp://send?abid=256&text=Schau%20Dir%20das%20mal%20an%3A%20<?php the_permalink(); ?>" class="whatsapp" title="Per WhatsApp verschicken">WhatsApp</a>
									<a href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" class="facebook" title="Auf Facebook teilen">Facebook</a>
									<a href="mailto:?subject=Das musst Du lesen: <?php echo rawurlencode(get_the_title()); ?>&body=Hey, schau Dir mal den Artikel auf <?php bloginfo('name'); ?> an: <?php the_permalink(); ?>" title="Per E-Mail weiterleiten" class="email">E-Mail</a>
								</p>
							</div>
							<?php endif; ?>
