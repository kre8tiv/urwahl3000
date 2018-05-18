<?php


/************* DASHBOARD WIDGETS *****************/

// disable default dashboard widgets
function disable_default_dashboard_widgets() {
	// remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget

	// remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');         //
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //

	/*
	have more plugin widgets you'd like to remove?
	share them with us so we can get a list of
	the most commonly used. :D
	https://github.com/eddiemachado/kr8/issues
	*/
}

/*
Now let's talk about adding your own custom Dashboard widget.
Sometimes you want to show clients feeds relative to their
site's content. For example, the NBA.com feed for a sports
site. Here is an example Dashboard Widget that displays recent
entries from an RSS Feed.

For more information on creating Dashboard Widgets, view:
http://digwp.com/2010/10/customize-wordpress-dashboard/
*/

// RSS Dashboard Widget
function kr8_rss_dashboard_widget() {
	if(function_exists('fetch_feed')) {
		include_once(ABSPATH . WPINC . '/feed.php');               // include the required file
		$feed = fetch_feed('https://github.com/kre8tiv/urwahl3000/commits/master.atom');        // specify the source feed
		$limit = $feed->get_item_quantity(7);                      // specify number of items
		$items = $feed->get_items(0, $limit);                      // create an array of items
	}
	if ($limit == 0) echo '<div>The RSS Feed is either empty or unavailable.</div>';   // fallback message
	else foreach ($items as $item) { ?>

	<h4 style="margin-bottom: 0;">
		<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo mysql2date(__('j F Y @ g:i a', 'kr8theme'), $item->get_date('Y-m-d H:i:s')); ?>" target="_blank">
			<?php echo $item->get_title(); ?>
		</a>
	</h4>
	<p style="margin-top: 0.5em;">
		<?php echo substr($item->get_description(), 24); ?>
	</p>
	<?php }
}


// Doku-Widget
function kr8_doku_widget() { ?>

	<p>Howdy,<br>Du nutzt <a href="https://www.urwahl3000.de">Urwahl3000</a>, dass freie und GRÜNE Layout für Wordpress.</p>
	<p>Urwahl3000 bietet eine Vielzahl an Funktionen und Möglichkeiten. <strong>Deshalb habe ich eine Dokumentation erstellt</strong>, die Antworten auf häufige Fragen gibt und Dir die ersten Schritte erleichtert. Wenn Du mehr aus deinem Urwahl3000 rausholen willst, wirf doch einen Blick hinein.</p>
	<p><strong>Kleiner Tipp:</strong> Schau regelmäßig auf der <a href="https://www.urwahl3000.de">Urwahl3000-Seite</a> vorbei, vielleicht gibt es ja ein Update. Nun aber viel Spaß mit deiner Website im Urwahl3000-Outfit.</p>
	<p>Viele Grüße<br>Ben</p>
	
	<p><a href="https://www.urwahl3000.de/dokumentation/" class="button-primary" target="_blank">Dokumentation</a>  <a href="https://www.urwahl3000.de" class="button-primary" target="_blank">Updates & Support</a></p>
	
	
<?php }



// calling all custom dashboard widgets
function kr8_custom_dashboard_widgets() {
	wp_add_dashboard_widget('kr8_rss_dashboard_widget', __('Neues von Urwahl3000 - GitHub', 'kr8theme'), 'kr8_rss_dashboard_widget');
	wp_add_dashboard_widget('kr8_doku_widget', __('Urwahl3000 Dokumentation', 'kr8theme'), 'kr8_doku_widget');
	/*
	Be sure to drop any other created Dashboard Widgets
	in this function and they will all load.
	*/
}


// removing the dashboard widgets
add_action('admin_menu', 'disable_default_dashboard_widgets');
// adding any custom widgets
add_action('wp_dashboard_setup', 'kr8_custom_dashboard_widgets');


/************* CUSTOM LOGIN PAGE *****************/

// calling your own login css so you can style it

//Updated to proper 'enqueue' method
//http://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
function kr8_login_css() {
	wp_enqueue_style( 'kr8_login_css', get_template_directory_uri() . '/lib/css/login.css', false );
}

// changing the logo link from wordpress.org to your site
function kr8_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function kr8_login_title() { return get_option('blogname'); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'kr8_login_css', 10 );
add_filter('login_headerurl', 'kr8_login_url');
add_filter('login_headertitle', 'kr8_login_title');


/************* CUSTOMIZE ADMIN *******************/

/*
I don't really recommend editing the admin too much
as things may get funky if WordPress updates. Here
are a few funtions which you can choose to use if
you like.
*/

// Custom Backend Footer
function kr8_custom_admin_footer() {
	_e('<span id="footer-thankyou"><a href="http://kre8tiv.de/urwahl3000" target="_blank">Urwahl3000</a></span> - entwickelt von <a href="http://kre8tiv.de" target="_blank">Benjamin Jopen</a>.', 'kr8theme');
}

// adding it to the admin area
add_filter('admin_footer_text', 'kr8_custom_admin_footer');

?>
