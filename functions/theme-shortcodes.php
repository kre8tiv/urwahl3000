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



?>