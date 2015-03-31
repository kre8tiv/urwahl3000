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
require_once('functions/theme-posttypes.php');
require_once('functions/theme-metaboxes.php');

require 'functions/theme-update.php';
$MyThemeUpdateChecker = new ThemeUpdateChecker(
'urwahl3000', //Theme slug. Usually the same as the name of its directory.
'http://themes.kre8tiv.de/?action=get_metadata&slug=urwahl3000' //Metadata URL.
);
hallo

?>
