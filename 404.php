<?php get_header(); ?>
			
			<div id="main" class="ninecol first clearfix" role="main">

						

					
					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
						    <header class="article-header">
							    <h1 class="page-title" itemprop="headline">Seite nicht gefunden.</h1>
						    </header>
					
						    <section class="entry-content clearfix" itemprop="articleBody">
							    <p>Oooops. Leider wurde die Seite nicht gefunden. Das tut uns sehr leid. Am Besten probierst Du die Suchfunktion aus, um den passenden Inhalt zu finden.</p>
							   <?php get_search_form(); ?>
							</section>
						    
						   
					
					    </article>
					
					   
			
    		</div> 
    
			<?php get_sidebar(); ?>
			<?php get_footer(); ?>
