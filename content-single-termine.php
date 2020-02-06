



					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
						    

					    <?php if ( has_post_thumbnail() ): ?>
							<div class="postimg">
								
									<span class="clearfix"><?php the_post_thumbnail('titelbild');  ?>	</span>
								
								<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
								$url = $thumb['0']; ?>
								
								
								<?php 
									$imgexc = get_post(get_post_thumbnail_id())->post_excerpt;
									if ($imgexc != "") {
										?><p class="wp-caption-text"><a href="<?php echo $url ?>" class="fancybox" title="<?php echo $imgexc;?>"><i class="fas fa-image"></i> <?php echo $imgexc;?></a></p><?php 
									} ?>
									
							</div>
							<?php endif; ?>


							
						
						    <header class="article-header">
							    
							    
							    							
							    <h1 class="h2"><?php the_title(); ?></h1>
							     <?php $amt =  get_post_meta( $post->ID, 'kr8mb_pers_pos_amt', true );   
								if (! empty ($amt )){ ?><h2 class="h3"><?php echo $amt; ?></h2><?php } ?>
								
								
						    </header>
					

										
										<section class="entry-content clearfix">
											
											
																		
											<div class="socialprofile">
											
												
											<?php $www =  get_post_meta( $post->ID, 'kr8mb_pers_contact_www', true );   
												if (! empty ($www )){ ?><a href="<?php echo $www; ?>"><span class="fas fa-globe-americas"></span></a><?php } ?>	
												
											<?php $email =  get_post_meta( $post->ID, 'kr8mb_pers_contact_email', true );   
												if (! empty ($email )){ ?><a href="mailto:<?php echo $email; ?>"><span class="fas fa-envelope"></span></a><?php } ?>
													
											
											<?php $facebook =  get_post_meta( $post->ID, 'kr8mb_pers_contact_facebook', true );   
												if (! empty ($facebook )){ ?><a href="<?php echo $facebook; ?>"><span class="fab fa-facebook"></span></a><?php } ?>
											
											<?php $twitter =  get_post_meta( $post->ID, 'kr8mb_pers_contact_twitter', true );   
												if (! empty ($twitter )){ ?><a href="https://twitter.com/<?php echo $twitter; ?>"><span class="fab fa-twitter"></span></a><?php } ?>
											
																						
											</div>
											
											
											
											<?php $excerpt =  get_post_meta( $post->ID, 'kr8mb_pers_excerpt', true );   
												if (! empty ($excerpt )){ ?><p class="intro"><?php echo $excerpt; ?></p><?php } ?>	

											
											
											
																						
											<?php the_content(); ?>
											
											<?php $anschrift =  get_post_meta( $post->ID, 'kr8mb_pers_contact_anschrift', true );   
												if (! empty ($anschrift )){ ?><div class="anschrift"><?php echo wpautop( $anschrift, $br = 1 ); ?></div><?php } ?>
											
										</section>
										

						    

							
						   
						   
						    </article> 

