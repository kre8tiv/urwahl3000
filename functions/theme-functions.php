<?php

/*********************
START FUNCTIONS
*********************/

add_action('after_setup_theme','kr8_startup', 15);
// Hook into the 'after_setup_theme' action
add_action( 'after_setup_theme', 'kr8_theme_support',16 );
add_action( 'after_setup_theme', 'custom_theme_features',17 );

function kr8_startup() {

    // launching operation cleanup
    add_action('init', 'kr8_head_cleanup');
    // remove WP version from RSS
    add_filter('the_generator', 'kr8_rss_version');
    // remove pesky injected css for recent comments widget
    add_filter( 'wp_head', 'kr8_remove_wp_widget_recent_comments_style', 1 );
    // clean up comment styles in the head
    add_action('wp_head', 'kr8_remove_recent_comments_style', 1);
    // clean up gallery output in wp
    add_filter('gallery_style', 'kr8_gallery_style');

    // enqueue base scripts and styles
    add_action('wp_enqueue_scripts', 'kr8_scripts_and_styles', 999);
    // ie conditional wrapper
    add_filter( 'style_loader_tag', 'kr8_ie_conditional', 10, 2 );

    // launching this stuff after theme setup
    add_action('after_setup_theme','kr8_theme_support');
    // adding sidebars to Wordpress (these are created in functions.php)
    add_action( 'widgets_init', 'kr8_register_sidebars' );
    // adding the kr8 search form (created in functions.php)
    add_filter( 'get_search_form', 'kr8_wpsearch' );

    // cleaning up random code around images
    add_filter('the_content', 'kr8_filter_ptags_on_images');
    // cleaning up excerpt
    add_filter('excerpt_more', 'kr8_excerpt_more');

} /* end */


/*********************
CLEANING UP THE HEAD
*********************/

function kr8_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
  // remove WP version from css
  add_filter( 'style_loader_src', 'kr8_remove_wp_ver_css_js', 9999 );
  // remove Wp version from scripts
  add_filter( 'script_loader_src', 'kr8_remove_wp_ver_css_js', 9999 );

} /* end */

// remove WP version from RSS
function kr8_rss_version() { return ''; }

// remove WP version from scripts
function kr8_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

// remove injected CSS for recent comments widget
function kr8_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove injected CSS from recent comments widget
function kr8_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// remove injected CSS from gallery
function kr8_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function kr8_scripts_and_styles() {
  if (!is_admin()) {

    // modernizr (without media query polyfill)
    wp_register_script( 'kr8-modernizr', get_template_directory_uri() . '/lib/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );
    wp_register_script( 'kr8-fancybox', get_template_directory_uri() . '/lib/js/libs/fancybox/jquery.fancybox.pack.js', array(), '2.1.4', false );
     wp_register_script( 'kr8-fancybuttons', get_template_directory_uri() . '/lib/js/libs/fancybox/jquery.fancybox-buttons.js', array(), '1.0.5', false );
     wp_register_script( 'kr8-socialshare', get_template_directory_uri() . '/lib/js/libs/jquery.socialshareprivacy.min.js', array(), '1.4', false );


    // register main stylesheet
    wp_register_style( 'kr8-stylesheet', get_template_directory_uri() . '/lib/css/style.css', array(), '', 'all' );
    wp_register_style( 'kr8-fancycss', get_template_directory_uri() . '/lib/js/libs/fancybox/jquery.fancybox.css', array(), '', 'all' );
    wp_register_style( 'kr8-fancybuttoncss', get_template_directory_uri() . '/lib/js/libs/fancybox/jquery.fancybox-buttons.css', array(), '', 'all' );

    // ie-only style sheet
    wp_register_style( 'kr8-ie-only', get_template_directory_uri() . '/lib/css/ie.css', array(), '' );

    // comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }

    //adding scripts file in the footer
    wp_register_script( 'kr8-js', get_template_directory_uri() . '/lib/js/scripts.js', array( 'jquery' ), '', true );

    // enqueue styles and scripts
    wp_enqueue_script( 'kr8-modernizr' );
    wp_enqueue_style( 'kr8-stylesheet' );
    wp_enqueue_style( 'kr8-fancycss' );
    wp_enqueue_style( 'kr8-fancybuttoncss' );
    wp_enqueue_style('kr8-ie-only');
    /*
    I recommend using a plugin to call jQuery
    using the google cdn. That way it stays cached
    and your site will load faster.
    */
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'kr8-js' );
    wp_enqueue_script( 'kr8-fancybox' );
    wp_enqueue_script( 'kr8-socialshare' );
    wp_enqueue_script( 'kr8-fancybuttons' );

  }
}


// adding the conditional wrapper around ie stylesheet
// source: http://code.garyjones.co.uk/ie-conditional-style-sheets-wordpress/
function kr8_ie_conditional( $tag, $handle ) {
	if ( 'kr8-ie-only' == $handle )
		$tag = '<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";
	return $tag;
}


/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function kr8_theme_support() {

	// wp thumbnails
	add_theme_support('post-thumbnails');

	// default thumb size
	set_post_thumbnail_size(125, 125, true);
	add_image_size( 'medium', 540, 370,true );
	add_image_size( 'large', 847, 500, true );
	
	
	
	update_option('thumbnail_size_w', 150);
	update_option('thumbnail_size_h', 150);
	update_option('medium_size_w', 540);
	update_option('medium_size_h', 370);
	update_option('large_size_w', 847);
	update_option('large_size_h', 500);
	
	//add_image_size( 'slider', 300, 300, true  );



  

	// rss thingy
	add_theme_support('automatic-feed-links');

                

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			'chat'               // chat transcript
		)
	);

	// wp menus
	add_theme_support( 'menus' );

	// registering wp3+ menus
	register_nav_menus(
		array(
			'nav-main' => __( 'Hauptmenü', '' ),   // main
			'nav-footer' => __( 'Links in der Fußleiste', '' ), // secondary
			'nav-portal' => __( 'Links in der Kopfzeile', '' ) // portal
		)
	);
} /* end kr8 theme support */




/*********************
MENUS & NAVIGATION
*********************/

// the main menu
function kr8_nav_main() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => false,                           // remove nav container
    	'menu' => __( 'Hauptmenü', '' ),  				// nav name
    	'menu_class' => 'navigation clearfix',         // adding custom nav class
    	'theme_location' => 'nav-main',                 // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
        'depth' => 2,                                   // limit the depth of the nav
    	'fallback_cb' => 'kr8_main_nav_fallback'      // fallback function
	));
} /* end kr8 main nav */

// the footer menu (should you choose to use one)
function kr8_nav_footer() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => false,                         // remove nav container
    	'menu' => __( 'Footer Links', '' ),  		    // nav name
    	'menu_class' => 'navigation clearfix nav-footer',          // adding custom nav class
    	'theme_location' => 'nav-footer',             // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
        'depth' => 1,                                   // limit the depth of the nav
    	'fallback_cb' => 'kr8_nav_footer_fallback'   // fallback function
	));
} /* end kr8 footer link */


// the footer menu (should you choose to use one)
function kr8_nav_portal() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => false,                         // remove nav container
    	'menu' => __( 'Portal Links', '' ),  		    // nav name
    	'menu_class' => 'navigation',          // adding custom nav class
    	'theme_location' => 'nav-portal',             // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
        'depth' => 1,
        'fallback_cb' => 'kr8_nav_portal_fallback'                                   // limit the depth of the nav  
	));
} /* end kr8 footer link */


// this is the fallback for header menu
function kr8_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
    	'menu_class' => 'navigation nav-fallback clearfix',      // adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
        'link_before' => '',                            // before each link
        'link_after' => ''                             // after each link
	) );
}

// this is the fallback for footer menu
function kr8_nav_footer_fallback() {
	/* you can put a default here if you like */
}

// this is the fallback for portal menu
function kr8_nav_portal_fallback() { ?>
	<nav role="navigation" id="nav-portal"><h6 class="unsichtbar">Links zu GRÜNEN Webseiten:</h6>
		<ul id="menu-portalmenu" class="navigation">
			<li><a href="http://gruene.de">Bundesverband</a></li>
			<li><a href="http://gruene-fraktion.de">Bundestagsfraktion</a></li>
			<li><a href="http://gruene-jugend.de">Grüne Jugend</a></li>
			<li><a href="http://boell.de">Böll Stiftung</a></li>
		</ul>
	</nav>
<? }


//Adds First and Last - Class to Menu
function add_first_and_last($output) {
  $output = preg_replace('/class="menu-item/', 'class="first-menu-item menu-item', $output, 1);
  $output = substr_replace($output, 'class="last-menu-item menu-item', strripos($output, 'class="menu-item'), strlen('class="menu-item'));
  return $output;
}
add_filter('wp_nav_menu', 'add_first_and_last');


/*********************
INDIVIDUALISATION
*********************/

// Register Theme Features
function custom_theme_features()  {
	global $wp_version;

	// Add theme support for Custom Background
	$background_args = array(
		'default-color'          => '559448',
		'default-image'          => get_template_directory_uri() . '/lib/images/body_bg.jpg',
		'wp-head-callback'       => 'kr8_custom_bg',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);
	if ( version_compare( $wp_version, '3.4', '>=' ) ) :
		add_theme_support( 'custom-background', $background_args );
	else :
		add_custom_background();
	endif;
	
	
	
	

	// Add theme support for Custom Header
	$header_args = array(
		'default-image'          => '',
		'width'                  => 1140,
		'height'                 => 200,
		'flex-width'             => false,
		'flex-height'            => true,
		'random-default'         => false,
		'header-text'            => true,
		'default-text-color'     => 'ffffff',
		'uploads'                => true,
		'wp-head-callback'       => 'kr8_header_style',

	);
	if ( version_compare( $wp_version, '3.4', '>=' ) ) :
		add_theme_support( 'custom-header', $header_args );
	else :
		add_custom_image_header();
	endif;
}


function kr8_custom_bg() {
	$background = get_background_image();
	$color = get_background_color();
	if ( ! $background && ! $color )
		return;

	$style = $color ? "background-color: #$color;background-size:cover;" : '';

	if ( $background ) {
		$image = " background-image: url('$background');";

		$repeat = get_theme_mod( 'background_repeat', 'repeat' );
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
		$repeat = " background-repeat: $repeat;";

		$position = get_theme_mod( 'background_position_x', 'center' );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'center';
		$position = " background-position: top $position;";

		$attachment = get_theme_mod( 'background_attachment', 'fixed' );
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'fixed';
		$attachment = " background-attachment: $attachment;";

		$style .= $image . $repeat . $position . $attachment;
	}
?>
<style type="text/css">
body.custom-background { <?php echo trim( $style ); ?> }
</style>
<?php
}


function kr8_header_style() {
	$text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	if ( $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		#header h1, #header h2, #header #logo {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text, use that.
		else :
	?>
		@media only screen and (min-width: 770px) {
			#header h1, #header h2, #header a {	color: #<?php echo $text_color; ?> !important;}
		}
	<?php endif; ?>
	</style>
	<?php
}

/*********************
RELATED POSTS FUNCTION
*********************/

// Related Posts Function (call using kr8_related_posts(); )
function kr8_related_posts() {
	echo '<ul id="kr8-related-posts">';
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if($tags) {
		foreach($tags as $tag) { $tag_arr .= $tag->slug . ','; }
        $args = array(
        	'tag' => $tag_arr,
        	'numberposts' => 5, /* you can change this to show more */
        	'post__not_in' => array($post->ID)
     	);
        $related_posts = get_posts($args);
        if($related_posts) {
        	foreach ($related_posts as $post) : setup_postdata($post); ?>
	           	<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
	        <?php endforeach; }
	    else { ?>
            <?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'kr8theme' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_query();
	echo '</ul>';
} /* end kr8 related posts function */



/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function kr8_page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
	echo $before.'<nav class="page-navigation"><ol class="kr8_page_navi clearfix">'."";
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$first_page_text = __( "Anfang", 'kr8theme' );
		echo '<li class="kr8pn-first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
	}
	echo '<li class="kr8pn-prev-link">';
	previous_posts_link('Vorherige');
	echo '</li>';
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="kr8pn-current">'.$i.'</li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="kr8pn-next-link">';
	next_posts_link('Nächste');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = __( "Ende", 'kr8theme' );
		echo '<li class="kr8pn-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
	}
	echo '</ol></nav>'.$after."";
} /* end page navi */


/*********************
IMAGES
*********************/





// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function kr8_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}


//Lightbox Image-Link
add_filter('the_content', 'addlightboxrel_replace');
function addlightboxrel_replace ($content)
{	global $post;
	$postid = get_the_ID();
	$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
  	$replacement = '<a$1class="fancybox" rel="gallery'. $postid .'" href=$2$3.$4$5$6>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}

function add_class_attachment_link($html){
    $postid = get_the_ID();
    $html = str_replace('<a','<a class="fancybox" rel="gallery'. $postid .'"',$html);
    return $html;
}
add_filter('wp_get_attachment_link','add_class_attachment_link',10,1);

/* 10px Image-Margins entfernen */
class fixImageMargins {
    public $xs = 0; //change this to change the amount of extra spacing

    public function __construct(){
        add_filter('img_caption_shortcode', array(&$this, 'fixme'), 10, 3);
    }
    public function fixme($x=null, $attr, $content){

        extract(shortcode_atts(array(
                'id'    => '',
                'align'    => 'alignnone',
                'width'    => '',
                'caption' => ''
            ), $attr));

        if ( 1 > (int) $width || empty($caption) ) {
            return $content;
        }

        if ( $id ) $id = 'id="' . $id . '" ';

    return '<div ' . $id . 'class="wp-caption ' . $align . '" style="width: ' . ((int) $width + $this->xs) . 'px">'
    . $content . '<p class="wp-caption-text">' . $caption . '</p></div>';
    }
}
$fixImageMargins = new fixImageMargins();





/*********************
Breadcrumb
*********************/
function nav_breadcrumb() {
 
  $delimiter = '&rang;';
  $home = 'Startseite'; 
  $before = '<span class="current">'; 
  $after = '</span>'; 
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    echo '<div id="breadcrumb">';
 
    global $post;
    $homeLink = get_bloginfo('url');
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . single_cat_title('', false) . $after;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      //echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      echo $before . 'Ergebnisse für die Suche nach "' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      echo $before . 'Beiträge mit dem Schlagwort "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Beiträge veröffentlicht von ' . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      echo $before . 'Fehler 404' . $after;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo ': ' . __('Seite') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</div>';
 
  }
}






/*********************
RANDOM CLEANUP ITEMS
*********************/

// This removes the annoying […] to a Read More link
function kr8_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a href="'. get_permalink($post->ID) . '" title="Read '.get_the_title($post->ID).'" class="readmore">Weiterlesen &raquo;</a>';
}

/*
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 */
function kr8_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}

?>
