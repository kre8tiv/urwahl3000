<?php get_header(); ?>
					<div id="main" class="ninecol first clearfix" role="main">

							<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	
							<?php get_template_part( 'content', 'single' ); ?>
		
							<?php comments_template( '', true ); ?>
		
							<?php endwhile; ?>
					
									
			
					</div> 
    
			<?php get_sidebar(); ?>
			<?php get_footer(); ?>