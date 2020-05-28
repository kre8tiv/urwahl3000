<?php

//SHORTCODES
function kr8_sitemap($atts) {
	extract(shortcode_atts(array(
		'personen'		=> 'nein',
	), $atts));

	//get current page ID
	$the_id = get_the_ID();
	
	$smargs = array(
	'child_of'	 => $the_id,
	'title_li'	 => '',
	'parent'	   => $the_id,
	'sort_order'	=> 'ASC',
	'sort_column'	=> 'menu_order'
	);
	$smitem = get_pages( $smargs );
	$personenclass = ($personen === 'nein') ? '' : 'sitemap-persons';
	
	$children = '';	
	foreach($smitem as $value){
		$thumb = get_the_post_thumbnail( $value->ID, 'square', $attr = '' );
		$children .= "<li>";
			$children .= "<a href='" . $value->post_name . "' >" . $thumb . "</a>";
			$children .= "<p><a href='" . $value->post_name . "' >" .  $value->post_title . "</a>";
			$children .= "<span>" .  $value->post_excerpt . "</span></p>";
		$children .= "</li>";
	} 
	
	return '<nav><ul class="sitemap sitemap-thumb ' . $personenclass . '">' . $children . '</ul></nav>';
}
add_shortcode('unterseiten', 'kr8_sitemap');

add_post_type_support( 'page', 'excerpt' );

//Tabs for Editor ***************
function tabs_shortcode( $atts, $content = null ) {
	if ( comments_open() || have_comments() ) {
		return '<div class="responsive-tabs content-tabs">' . do_shortcode($content) . '</div>';
	} else {
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

function the_content_filter($content) {
	// array of custom shortcodes requiring the fix 
	$block = join("|",array("col","tabs","tab"));

	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
		
	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

	return $rep;
}
add_filter("the_content", "the_content_filter");

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

/**
 * Font Awesome Shortcode
 *
 * [fa icon="heart" set="fas" margin="r2" color="#000000" class="fa-fw"]
 *
 * Icon is set to "heart" by default.
 * Set is set to "fas" by default.
 * Margin is set if required. Possible values are:
 *	 a (all), t (top), b (bottom), l (left), r (right), x (left + right), y (top + bottom)
 *	 with digit from 0 to 5 (like spacing classes in Bootstrap 4)
 * Class can be any additional CSS classes incl. all from Font Awesome like size, fixed width etc.
 * Color is only set as hexadecimal value if required.
 *
 * @see <https://fontawesome.com/icons?d=gallery&m=free>
 * @see <https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use>
 * @see <https://wordpress.org/plugins/shortcode-for-font-awesome/>
 */
function kr8_fontawesome_shortcode($atts) {
	// @see <https://torquemag.io/2017/06/custom-shortcode/>
	$a = shortcode_atts(array(
		'icon' => 'heart',
		'set' => 'fas',
		'margin' => '',
		'color' => '',
		'class' => ''
	), $atts);
	$style = '';
	if (($a['margin'] !== '') && preg_match('/^[ablrty][0-5]$/', $a['margin']) === 1) {
		// @see <https://getbootstrap.com/docs/4.4/utilities/spacing/>
		$length = array('0', '.25rem', '.5rem', '1rem', '1.5rem', '3rem')[intval(substr($a['margin'], -1))];
		switch(substr($a['margin'], 0, 1)) {
			case 'a':
				$style .= 'margin:' . $length . ';';
				break;
			case 't':
			case 'y':
				$style .= 'margin-top:' . $length . ';';
			case 'b':
			case 'y':
				$style .= 'margin-bottom:' . $length . ';';
				break;
			case 'l':
			case 'x':
				$style .= 'margin-left:' . $length . ';';
			case 'r':
			case 'x':
				$style .= 'margin-right:' . $length . ';';
		}
	}
	if (($a['color'] !== '') && preg_match('/#([a-f0-9]{3}){1,2}\b/i', $a['color']) === 1) {
		// @see <https://stackoverflow.com/a/12837990>
		$style .= 'color:' . $a['color'] . ';';
	}
	return '<span class="' . $a['set'] . ' fa-' . $a['icon'] . ($a['class'] !== '' ? ' ' . $a['class'] : '') . '"'
		. ($style !== '' ? ' style="' . $style . '"' : '') . '></span>';
}
add_shortcode( 'fa', 'kr8_fontawesome_shortcode' );
add_filter('nav_menu_item_title', function($title, $item, $args, $depth) {
	// @see <https://wordpress.stackexchange.com/a/294351>
	return do_shortcode($title);
}, 10, 4);
add_filter('widget_text', 'do_shortcode');

?>
