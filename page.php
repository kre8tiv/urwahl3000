<?php get_header(); ?>
			
			<div id="main" class="ninecol first clearfix" role="main">

	
				<?php if ( has_post_thumbnail() ): ?>
							<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
								$url = $thumb['0']; ?>
								<a href="<?php echo $url ?>" class="postimg fancybox"><?php the_post_thumbnail('titelbild');  ?></a>
								<?php 
									$imgexc = get_post(get_post_thumbnail_id())->post_excerpt;
									if ($imgexc != "") {
										?><p class="caption"><span><i class="fa fa-picture-o"></i> <?php echo $imgexc;?></span></p><?php 
									}
									 ?>
							<?php endif; ?> 

					     <?php while (have_posts()): the_post(); ?>
					
					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
						    <header class="article-header">
							    <h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
						    </header>
					
						    <section class="entry-content clearfix" itemprop="articleBody">
							    <?php the_content(); ?>
							</section>
						    
						    
					
					    </article>
					    
					    <?php comments_template(); ?>
					
					    <?php endwhile; ?>
			
    		</div> 
    
			<?php get_sidebar(); ?>
			<?php get_footer(); ?>
