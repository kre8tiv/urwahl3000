					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
						    <header class="article-header">
							    <h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
						    </header>
					
							<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>		

							    <section class="entry-content clearfix" itemprop="articleBody">
								    <?php the_excerpt(); ?>
								</section>
							    
							<?php else : ?>
						    
							    <section class="entry-content clearfix" itemprop="articleBody">
								    <?php the_content(); ?>
								</section>
							    
							<?php endif; ?>
					
					    </article>
