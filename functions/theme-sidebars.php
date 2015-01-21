<?php 
// sidebars
if ( function_exists('register_sidebars') )
	register_sidebars(0);

if (!function_exists('kr8_register_sidebars')) {
	function kr8_register_sidebars() {
		if ( function_exists('register_sidebar') ) {

			register_sidebar(array(
				'name' => 'Infospalte',
				'description'   => 'Infospalte für Widgets. Wird auf den meisten Seiten angezeigt.',
				'id' => 'infospalte',
				'before_widget' => "\n\t\t" . '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => "\n\t" . '<h3 class="widgettitle">',
				'after_title' => '</h3>',
			));
			
			register_sidebar(array(
				'name' => 'Fussleiste',
				'description'   => 'Platz für Widgets in der Fußleiste.',
				'id' => 'fussleist',
				'before_widget' => "\n\t\t" . '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => "\n\t" . '<h3 class="widgettitle">',
				'after_title' => '</h3>',
			));

			
			
		}
	}
	
	
}


/************* SEARCH FORM LAYOUT *****************/

function kr8_wpsearch($form) {
    $form = '<section class="suche"><h6 class="unsichtbar">Suchformular</h6><form role="search" method="get" class="searchform" action="' . home_url( '/' ) . '" >
    <label for="search">Der Suchbegriff nach dem die Website durchsucht werden soll.</label>
    <input type="text" name="s" id="search" value="' . get_search_query() . '" placeholder="Suchbegriff eingeben ..." />
    <button type="submit" class="button-submit">
                <span class="fa fa-search"></span> <span class="text">Suchen</span>
            </button>
    </form></section>';
    return $form;
} 


/************* SOCIAL MEDIA WIDGET *****************/
 class kr8_socialmedia extends WP_Widget {

	function kr8_socialmedia() {
		$widget_ops = array('description' => 'Links zu deinen Profilen in den Sozialen Netzwerken.');

		parent::WP_Widget(false, __('Social Media Links'),$widget_ops);
	}

	function widget($args, $instance) {  
		extract( $args );
		$title = $instance['title'];
		$twitter = $instance['twitter'];
		$facebook = $instance['facebook'];
		$googleplus = $instance['googleplus'];
		$flickr = $instance['flickr'];
		$instagram = $instance['instagram'];
		$youtube = $instance['youtube'];
		$vimeo = $instance['vimeo'];
		$pinterest = $instance['pinterest'];
		$soundcloud = $instance['soundcloud'];
		$foursquare = $instance['foursquare'];
		$xing = $instance['xing'];
		$tumblr = $instance['tumblr'];
		$rss = $instance['rss'];
		$rsscomments = $instance['rsscomments'];
		
		
		echo $before_widget; ?>
		<?php if($title != '')
			echo '<h3 class="widgettitle">'.$title.'</h3>'; ?>

        <ul class="sociallinks">
			<?php 
			if($twitter != '') {
				echo '<li><a href="https://twitter.com/'.$twitter.'" title="Twitter"><span class="fa fa-fw fa-twitter"></span><span class="hidden">Twitter</span></a></li>';
			}
			?>

			<?php 
			if($facebook != '') {
				echo '<li><a href="'.$facebook.'"title="Facebook"><span class="fa fa-fw fa-facebook"></span><span class="hidden">Facebook</span></a></li>';
			}
			?>

			<?php 
			if($googleplus != '') {
				echo '<li><a href="'.$googleplus.'" title="Google+"><span class="fa fa-fw fa-google-plus"></span><span class="hidden">Google+</span></a></li>';
			}
			?>

			<?php if($flickr != '') {
				echo '<li><a href="'.$flickr.'" title="Flickr"><span class="fa fa-fw fa-flickr"></span><span class="hidden">Flickr</span></a></li>';
			}
			?>
			
			<?php if($instagram != '') {
				echo '<li><a href="'.$instagram.'" title="Instagram"><span class="fa fa-fw fa-instagram"></span><span class="hidden">Instagram</span></a></li>';
			}
			?>

			<?php if($youtube != '') {
				echo '<li><a href="'.$youtube.'" title="YouTube"><span class="fa fa-fw fa-youtube"></span><span class="hidden">YouTube</span></a></li>';
			}
			?>

			<?php if($vimeo != '') {
				echo '<li><a href="'.$vimeo.'" title="Vimeo"><span class="fa fa-fw fa-vimeo-square"></span><span class="hidden">Vimeo</span></a></li>';
			}
			?>

			<?php if($soundcloud != '') {
				echo '<li><a href="'.$soundcloud.'" title="Soundcloud"><span class="fa fa-fw fa-soundcloud"></span><span class="hidden">Soundcloud</span></a></li>';
			}
			?>

			<?php if($foursquare != '') {
				echo '<li><a href="'.$foursquare.'" title="Foursquare"><span class="fa fa-fw fa-foursquare"></span><span class="hidden">Foursquare</span></a></li>';
			}
			?>
			
			<?php if($pinterest != '') {
				echo '<li><a href="'.$pinterest.'" title="Pinterst"><span class="fa fa-fw fa-pinterest"></span><span class="hidden">Pinterest</span></a></li>';
			}
			?>

			<?php if($xing != '') {
				echo '<li><a href="'.$xing.'" title="Xing"><span class="fa fa-fw fa-xing"></span><span class="hidden">Xing</span></a></li>';
			}
			?>
			
			<?php if($tumblr != '') {
				echo '<li><a href="'.$tumblr.'" title="Tumblr"><span class="fa fa-fw fa-tumblr"></span><span class="hidden">Tumblr</span></a></li>';
			}
			?>
    
			<?php if($rss != '') {
				echo '<li><a href="'.$rss.'" title="RSS Feed"><span class="fa fa-fw fa-rss"></span><span class="hidden">RSS Feed</span></a></li>';
			}
			?>

			<?php if($rsscomments != '') {
				echo '<li><a href="'.$rsscomments.'" title="RSS Comments"><span class="fa fa-fw fa-comments-o"></span><span class="hidden">RSS Comments</span></a></li>';
			}
			?>

		</ul><!-- end .sociallinks -->

	   <?php			
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) { 
		$title = esc_attr($instance['title']);
		$twitter = esc_attr($instance['twitter']);
		$facebook = esc_attr($instance['facebook']);
		$googleplus = esc_attr($instance['googleplus']);
		$flickr = esc_attr($instance['flickr']);
		$instagram = esc_attr($instance['instagram']);
		$youtube = esc_attr($instance['youtube']);
		$vimeo = esc_attr($instance['vimeo']);
		$pinterest = esc_attr($instance['pinterest']);
		$soundcloud = esc_attr($instance['soundcloud']);
		$foursquare = esc_attr($instance['foursquare']);
		$tumblr = esc_attr($instance['tumblr']);
		$xing = esc_attr($instance['xing']);
		$rss = esc_attr($instance['rss']);
		$rsscomments = esc_attr($instance['rsscomments']);

		
		?>

		 <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter-Benutzername:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo $twitter; ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook URL:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo $facebook; ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id('googleplus'); ?>"><?php _e('Google+ URL:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('googleplus'); ?>" value="<?php echo $googleplus; ?>" class="widefat" id="<?php echo $this->get_field_id('googleplus'); ?>" />
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id('flickr'); ?>"><?php _e('Flickr URL:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('flickr'); ?>" value="<?php echo $flickr; ?>" class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" />
        </p>
		  
		 <p>
            <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram URL:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('instagram'); ?>" value="<?php echo $instagram; ?>" class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('YouTube URL:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('youtube'); ?>" value="<?php echo $youtube; ?>" class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" />
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id('vimeo'); ?>"><?php _e('Vimeo URL:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('vimeo'); ?>" value="<?php echo $vimeo; ?>" class="widefat" id="<?php echo $this->get_field_id('vimeo'); ?>" />
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e('Pinterest URL:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('pinterest'); ?>" value="<?php echo $pinterest; ?>" class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('soundcloud'); ?>"><?php _e('Soundcloud URL:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('soundcloud'); ?>" value="<?php echo $soundcloud; ?>" class="widefat" id="<?php echo $this->get_field_id('soundcloud'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('foursquare'); ?>"><?php _e('Foursquare URL:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('foursquare'); ?>" value="<?php echo $foursquare; ?>" class="widefat" id="<?php echo $this->get_field_id('foursquare'); ?>" />
        </p>


		<p>
            <label for="<?php echo $this->get_field_id('xing'); ?>"><?php _e('Xing URL:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('xing'); ?>" value="<?php echo $xing; ?>" class="widefat" id="<?php echo $this->get_field_id('xing'); ?>" />
        </p>

		<p>
            <label for="<?php echo $this->get_field_id('tumblr'); ?>"><?php _e('Tumblr URL:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('tumblr'); ?>" value="<?php echo $xing; ?>" class="widefat" id="<?php echo $this->get_field_id('tumblr'); ?>" />
        </p>
		
				
		
		<p>
            <label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('RSS-Feed URL:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('rss'); ?>" value="<?php echo $rss; ?>" class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" />
        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id('rsscomments'); ?>"><?php _e('RSS for Comments URL:'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('rsscomments'); ?>" value="<?php echo $rsscomments; ?>" class="widefat" id="<?php echo $this->get_field_id('rsscomments'); ?>" />
        </p>

       
		<?php
	}
} 

register_widget('kr8_socialmedia');




?>