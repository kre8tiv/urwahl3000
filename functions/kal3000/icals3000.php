<?php	$archiv = 		@$_GET['archiv'];
		$kat = 			@$_GET['kat'];
		$maxmonths = 	@$_GET['maxmonths'];
		$anzahl = 		@$_GET['anzahl'];

		$ical3000_file_name 	= 'ical3000_calendar';
		if($archiv) 			$ical3000_file_name .= '_archiv_' . esc_attr($archiv);
		if($kat) 				$ical3000_file_name .= '_kat_' . esc_attr($kat);
		if($maxmonths) 			$ical3000_file_name .= '_maxmonths_' . esc_attr($maxmonths);
		if($anzahl) 			$ical3000_file_name .= '_anzahl_' . esc_attr($anzahl);

		$ical3000_prodid 		= '-//urwahl3000//' . get_site_url() . '//DE';
		$ical3000_prodid		= str_replace('https://', '', $ical3000_prodid);
		$ical3000_prodid		= str_replace('http://', '', $ical3000_prodid);
		$ical3000_prodid		= str_replace('www.', '', $ical3000_prodid);

		$ical3000_dateformat 	= 'Ymd\THis';

		global $wp_query,$paged,$post;
		$temp = $wp_query;
		$wp_query= null;
		$wp_query = new WP_Query();
		
		if( $archiv === 'true'){
			$order='DESC';
			$compare='<=';
			$maxmonths = strtotime('-' . $maxmonths . ' months');
			$maxmonths_compare = '>=';
		}else{
			$order='ASC';
			$compare='>=';
			$maxmonths = strtotime('+' . $maxmonths . ' months');
			$maxmonths_compare = '<=';
		}
		
		$args = array(
			'post_type'=>'termine',
			'orderby' => 'meta_value',
			'meta_key' => '_zeitstempel',
			'termine_type' => $kat,
			'order' => $order,
			'posts_per_page' => $anzahl,
			'meta_query' => array(
				array(
					'key' => '_zeitstempel',
					'value' => time(),
					'compare' => $compare
				),
				array(
					'key' => '_secretevent',
					'value' => 'true',
					'compare' => 'NOT IN'
				)
			)
		);
		
		if($maxmonths) {
			$args['meta_query'][] = array(
				'key' => '_zeitstempel',
				'value' => $maxmonths,
				'compare' => $maxmonths_compare
			);
		}
		
		$ical3000_ics_content = array();
		$termine = get_posts($args);
		if($termine) :

			$ical3000_ics_content[] = 'BEGIN:VCALENDAR';
			$ical3000_ics_content[] = 'VERSION:2.0';
			$ical3000_ics_content[] = 'PRODID:' . $ical3000_prodid;
			$ical3000_ics_content[] = 'CALSCALE:GREGORIAN';
			foreach($termine as $termin) :
				$ical3000_meta = get_post_custom( $termin->ID);
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
				
				$ical3000_start 			= date_i18n($ical3000_dateformat, @$ical3000_meta['_zeitstempel'][0]);
				$ical3000_end 				= date_i18n($ical3000_dateformat, @$ical3000_meta['_zeitstempel'][0]);
				$ical3000_current_time 		= date_i18n($ical3000_dateformat, @$ical3000_meta['_zeitstempel'][0]);
				$ical3000_title 			= html_entity_decode( $termin->post_title , ENT_COMPAT, 'UTF-8');
				$ical3000_location 			= preg_replace('/([\,;])/','\\\$1', implode(' ', array( @$ical3000_meta['_geoshow'][0], @$ical3000_meta['_geostadt'][0] ) )); 
				$ical3000_geo 				= @$ical3000_meta['_lat'][0] . ';' . @$ical3000_meta['_lon'][0];
				$ical3000_geo				= trim(';', $ical3000_geo);
				$ical3000_description 		= html_entity_decode( $termin->post_content , ENT_COMPAT, 'UTF-8');
				$ical3000_url 				= get_permalink( $termin->ID );
				
				if(!$ical3000_start) {
					continue;
				}
				
				$ical3000_ics_content[] =	'BEGIN:VEVENT';
				if($ical3000_start) 		$ical3000_ics_content[] = 'DTSTART:'.$ical3000_start;
				if($ical3000_end)			$ical3000_ics_content[] = 'DTEND:'.$ical3000_end;
				if($ical3000_location)		$ical3000_ics_content[] = 'LOCATION:'.$ical3000_location;
				if($ical3000_geo)			$ical3000_ics_content[] = 'GEO:'.$ical3000_geo;
				if($ical3000_current_time)	$ical3000_ics_content[] = 'DTSTAMP:'.$ical3000_current_time;
				if($ical3000_title)			$ical3000_ics_content[] = 'SUMMARY:'.$ical3000_title;
				if($ical3000_url)			$ical3000_ics_content[] = 'URL;VALUE=URI:'.$ical3000_url;
				if($ical3000_description)	$ical3000_ics_content[] = 'DESCRIPTION:'.$ical3000_description;
				$ical3000_ics_content[] = 	'UID:'.$ical3000_current_time.'-'.$ical3000_start.'-'.$ical3000_end;
				$ical3000_ics_content[] = 	'END:VEVENT';
			endforeach;
			$ical3000_ics_content[] = 'END:VCALENDAR';
		endif;
		
		$ical3000_ics_content = implode("\r\n", $ical3000_ics_content);
		
		header("Content-type: text/calendar");
		header("Content-Disposition: attachment; filename=$ical3000_file_name.ics");
		echo $ical3000_ics_content;
		exit;