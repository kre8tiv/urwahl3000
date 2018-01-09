<?php
/*
Author: Benjamin Jopen
URL: htp://kre8tiv.de 

/************* INCLUDE FILES ***************/

if ( ! isset( $content_width ) ) $content_width = 783;	

require_once('functions/theme-functions.php');
require_once('functions/theme-sidebars.php');
require_once('functions/theme-comments.php');
require_once('functions/theme-shortcodes.php');
require_once('functions/admin-dashboard.php');
require_once('functions/attachment-copyright.php');
require_once('functions/kal3000/kal3000.php');

require 'functions/theme-update.php';
$MyThemeUpdateChecker = new ThemeUpdateChecker(
	'urwahl3000', //Theme slug. Usually the same as the name of its directory.
	'http://themes.kre8tiv.de/?action=get_metadata&slug=urwahl3000' //Metadata URL.
);

function urwahl3000_after_update() {
	$current_version = wp_get_theme()->get('Version');
	$old_version = get_option( 'urwahl3000_theme_version' );
	
	if ($old_version !== $current_version) {
		flush_rewrite_rules();
		update_option('urwahl3000_theme_version', $current_version);
	}
}
add_action('after_setup_theme', 'urwahl3000_after_update');

?>
