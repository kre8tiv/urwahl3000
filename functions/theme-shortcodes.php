<?php

//SHORTCODES
function kr8_sitemap() {

//get current page ID
$the_id = get_the_ID();

	$smargs = array(
		'child_of'     => $the_id,
		'title_li'     => '',
		'parent'       => $the_id,
		'sort_order'	=> 'ASC',
		'sort_column'	=> 'menu_order'
	);

	$smitem = get_pages( $smargs );



foreach($smitem as $value){

	$thumb = get_the_post_thumbnail( $value->ID, array(100,100), $attr = '' );
	$children .= "<li>";
	$children .= "<a href='" . $value->post_name . "' >" . $thumb . "</a>";
	$children .= "<p><a href='" . $value->post_name . "' >" .  $value->post_title . "</a>";
	$children .= "<span>" .  $value->post_excerpt . "</span></p>";
	$children .= "</li>";
} 


 return '<nav><ul class="sitemap sitemap-thumb">' . $children . '</ul></nav>';



}
add_shortcode('unterseiten', 'kr8_sitemap');


//Excerpt for Pages
add_post_type_support( 'page', 'excerpt' );


//Tabs for Editor ***************
function tabs_shortcode( $atts, $content = null ) {
	
	if ( comments_open() || have_comments() ) {
		return '<div class="responsive-tabs content-tabs">' . do_shortcode($content) . '</div>';
	}
	else {
		
		return '<div class="responsive-tabs content-tabs">' . do_shortcode($content) . '</div><script>jQuery(document).ready(function() { RESPONSIVEUI.responsiveTabs(); }) </script>';
		
	}
}
add_shortcode( 'tabs', 'tabs_shortcode' );

function tab_shortcode( $atts, $content = null ) {
	extract(shortcode_atts(array(
      'title' => 'Titel anpassen',
   ), $atts));
	return '<h2>' .$title .'</h2><div>' . $content . '</div>';
}
add_shortcode( 'tab', 'tab_shortcode' ); 



add_filter("the_content", "the_content_filter");

function the_content_filter($content) {

	// array of custom shortcodes requiring the fix 
	$block = join("|",array("col","tabs","tab"));

	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
		
	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

	return $rep;

}





//Tabs for Editor ***************
function kr8_pers_listing( ) {
	
					    ob_start();
					 
					    // define attributes and their defaults
					    extract( shortcode_atts( array (
					        'order' => 'date',
					        'orderby' => 'title',
					        'posts' => -1,
					        'category' => '',
					    ), $atts ) );
							
							query_posts('post_type=person&posts_per_page=-1'); 
							?>
					    		
    		
    					<?php while ( have_posts() ) : the_post(); ?>
					    	<?php get_template_part( 'content', get_post_type() ); ?>
					    <?php endwhile; 			
		
}
//add_shortcode( 'personen', 'kr8_pers_listing' );


function myLoop($atts, $content = null) {
	extract(shortcode_atts(array(
		"pagination" => 'true',
		"query" => '',
		"category" => '',
	), $atts));
	global $wp_query,$paged,$post;
	$temp = $wp_query;
	$wp_query= null;
	$wp_query = new WP_Query();
	$query .= 'post_type=person';
	
	$wp_query->query($query);
	ob_start();
	?>
	
	
	<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
		<?php get_template_part( 'content', get_post_type() ); ?>
	<?php endwhile; ?>



	<?php $wp_query = null; $wp_query = $temp;
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode("personen", "myLoop");


?>
