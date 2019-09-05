<?php	if( !get_post_type() || get_post_type() !== 'termine')
			wp_die();

global $post;	
$ical3000_meta = get_post_custom( get_the_ID());
$ical3000_dateformat = 'Ymd\THis';

if($ical3000_meta['_lat'][0]) {
	$ical3000_meta['_lat'][0] = floatval($ical3000_meta['_lat'][0]);
	if($ical3000_meta['_lat'][0] < 10) {
		$ical3000_meta['_lat'][0] = '0' . floatval($ical3000_meta['_lat'][0]);
	}
}
if($ical3000_meta['_lon'][0]) {
	$ical3000_meta['_lon'][0] = floatval($ical3000_meta['_lon'][0]);
	if($ical3000_meta['_lon'][0] < 10) {
		$ical3000_meta['_lon'][0] = '0' . floatval($ical3000_meta['_lon'][0]);
	}
}

$ical3000_start 		= date_i18n($ical3000_dateformat, @$ical3000_meta['_zeitstempel'][0]);
$ical3000_end 			= date_i18n($ical3000_dateformat, @$ical3000_meta['_zeitstempel'][0]);
$ical3000_current_time 	= date_i18n($ical3000_dateformat, @$ical3000_meta['_zeitstempel'][0]);
$ical3000_title 		= html_entity_decode( get_the_title() , ENT_COMPAT, 'UTF-8');
$ical3000_location 		= preg_replace('/([\,;])/','\\\$1', implode(' ', array( @$ical3000_meta['_geoshow'][0], @$ical3000_meta['_geostadt'][0] ) )); 
$ical3000_geo 			= @$ical3000_meta['_lat'][0] . ';' . @$ical3000_meta['_lon'][0];
$ical3000_description 	= html_entity_decode( $post->post_content , ENT_COMPAT, 'UTF-8');
$ical3000_url 			= get_permalink( get_the_ID() );
$ical3000_prodid 		= '-//urwahl3000//' . get_site_url() . '//DE';
$ical3000_prodid		= str_replace('https://', '', $ical3000_prodid);
$ical3000_prodid		= str_replace('http://', '', $ical3000_prodid);
$ical3000_prodid		= str_replace('www.', '', $ical3000_prodid);
$ical3000_file_name 	= $post->post_name;

$eol = "\r\n";
$ical3000_ics_content =
'BEGIN:VCALENDAR'.$eol.
'VERSION:2.0'.$eol.
'PRODID:'.$ical3000_prodid.$eol.
'CALSCALE:GREGORIAN'.$eol.
'BEGIN:VEVENT'.$eol.
'DTSTART:'.$ical3000_start.$eol.
'DTEND:'.$ical3000_end.$eol.
'LOCATION:'.$ical3000_location.$eol.
'GEO:'.$ical3000_geo.$eol.
'DTSTAMP:'.$ical3000_current_time.$eol.
'SUMMARY:'.$ical3000_title.$eol.
'URL;VALUE=URI:'.$ical3000_url.$eol.
'DESCRIPTION:'.$ical3000_description.$eol.
'UID:'.$ical3000_current_time.'-'.$ical3000_start.'-'.$ical3000_end.$eol.
'END:VEVENT'.$eol.
'END:VCALENDAR';

header("Content-type: text/calendar");
header("Content-Disposition: attachment; filename=$ical3000_file_name.ics");
echo $ical3000_ics_content; ?>