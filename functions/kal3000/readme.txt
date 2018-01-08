=== Plugin Name ===
Contributors: webevangelisten
Tags: Calendar, events
Requires at least: 4
Tested up to: 4.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Custom post type for Events. With start and endtime, archives and maps.

== Description ==

Defines a custom post type to publish events. Events have a starting time, end time and a location, where they take place. 
Events will be displayed in chronological order.

= Technical details =
The plugin uses two connections to remotes servers: 
* One is to googemap-api, which can be only used remotely ( https://maps.googleapis.com/maps/api/js )
* and the other one goes to map-tiles ( http://tiles.mapbox.com ), which can be only used remotely


== Installation ==
1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[wpcalendar]` in a new site for overview of upcoming events

== Changelog ==

= 0.1 =
* Initial alpha version
