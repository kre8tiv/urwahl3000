<?php get_header(); ?>
			
			<div id="main" class="ninecol first clearfix" role="main">

					
					    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
						    <header class="article-header">
							    <h1 class="page-title" itemprop="headline">Seite nicht gefunden.</h1>
						    </header>
					
						    <section class="entry-content clearfix" itemprop="articleBody">
							    <p>Oooops. Das hier ist so falsch und inhaltsleer wie die Politik der schwarz-gelben Merkelregierung. Entschuldige bitte. Am besten nutzt Du die Suchfunktion dieser Seite - dann findest Du, was Du suchst (Schade, dass die Bundesregierung diese Funktion nicht bietet).</p>
							    <?php get_search_form( $echo ); ?>
							</section>
						    
						   
					
					    </article>
					
					   
			
    		</div> 
    
			<?php get_sidebar(); ?>
			<?php get_footer(); ?>
