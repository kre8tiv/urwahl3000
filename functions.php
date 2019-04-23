<?php
/*
Author: Benjamin Jopen
URL: htp://kre8tiv.de 

/************* INCLUDE FILES ***************/

if ( ! isset( $content_width ) ) $content_width = 783;	

if(file_exists( get_template_directory() . '/functions/theme-functions.php'))
	require_once( get_template_directory() . '/functions/theme-functions.php');
if(file_exists( get_template_directory() . '/functions/theme-sidebars.php'))
	require_once( get_template_directory() . '/functions/theme-sidebars.php');
if(file_exists( get_template_directory() . '/functions/theme-comments.php'))
	require_once( get_template_directory() . '/functions/theme-comments.php');
if(file_exists( get_template_directory() . '/functions/theme-shortcodes.php'))
	require_once( get_template_directory() . '/functions/theme-shortcodes.php');
if(file_exists( get_template_directory() . '/functions/theme-dashboard.php'))
	require_once( get_template_directory() . '/functions/theme-dashboard.php');
if(file_exists( get_template_directory() . '/functions/attachment-copyright.php'))
	require_once( get_template_directory() . '/functions/attachment-copyright.php');
if (version_compare(PHP_VERSION, '5.6.0') >= 0) {
	if(apply_filters('urwahl3000_kal3000', true)) {
		require_once('functions/kal3000/kal3000.php');
	}
}

if(file_exists( get_template_directory() . '/functions/theme-update.php')) {
	require_once( get_template_directory() . '/functions/theme-update.php');

	$MyThemeUpdateChecker = new ThemeUpdateChecker(
		'urwahl3000',
		'http://themes.kre8tiv.de/?action=get_metadata&slug=urwahl3000'
	);
}

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