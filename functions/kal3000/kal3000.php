<?php

/*
Based on Plugin: wpCalendar by Thomas Rose
Additional Work by: design & kommunikation im modulbuero
*/

function kal3000_legacy() {
	deactivate_plugins( 'wpcalendar/wpCalendar.php' );
}
add_action('admin_init', 'kal3000_legacy');

function kal3000_termine_taxonomies(){
	register_taxonomy('termine_type',array('termine'), array(
		'hierarchical' => true,
		'labels' => array(
			'name' => 'Terminkategorie',
			'singular_name' => 'Terminkategorie',
			'search_items' =>  'Terminkategorien durchsuchen',
			'all_items' => 'Alle Terminkategorien',
			'parent_item' => 'Übergeordnete Terminkategorie',
			'parent_item_colon' => 'Übergeordnete Terminkategorie:',
			'edit_item' => 'Terminkategorie bearbeiten',
			'update_item' => 'Terminkategorie ändern',
			'add_new_item' => 'Terminkategorie hinzufügen',
			'new_item_name' => 'Neue Terminkategorie',
			),
		'show_ui' => true,
		'query_var' => true,
		'show_in_nav_menus' => true,
		'rewrite' => array('slug' => 'termine', 'with_front' => false),
	));
}
add_action('init' , 'kal3000_termine_taxonomies' );

function kal3000_post_type_termine() {
	register_post_type(
		'termine',
		array(
			'labels' => array ('name' => 'Termine', 'singular_name' => 'Termin'),
			'public' => true,
			'menu_icon' => 'dashicons-calendar',
			'rewrite' => array( 'slug' => 'termin'),
			'show_ui' => true,
			'taxonomies' => array('termine_types'),
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'revisions',
			)
		)
	);
}
add_action('init', 'kal3000_post_type_termine');

function kal3000_add_scripts() {
	wp_enqueue_style( 'wp-cal-leaflet-css', get_template_directory_uri() . '/functions/kal3000//map/leaflet.css' );
	wp_enqueue_script( 'wp-cal-leaflet-js', get_template_directory_uri() . '/functions/kal3000//map/leaflet.js' );
}
add_action( 'wp_enqueue_scripts', 'kal3000_add_scripts' );

function kal3000_add_adminscripts() {
	global $post_type;
	if( 'termine' == $post_type ) {
		wp_deregister_script('jquery-ui-datepicker');
		wp_enqueue_style( 'kal3000-datepicker-css', get_template_directory_uri() . '/functions/kal3000/css/jquery.datetimepicker.css' );
		wp_enqueue_script( 'kal3000-datepicker-js', get_template_directory_uri() . '/functions/kal3000/js/jquery.datetimepicker.js' );
		wp_enqueue_script( 'kal3000-js', get_template_directory_uri() . '/functions/kal3000/js/wpCalendar.js' );
	}
}
add_action( 'admin_enqueue_scripts', 'kal3000_add_adminscripts' ); 

function kal3000_secretevents_exclude_search($query) {
	if ( $query->is_search ) {
		global $wpdb;
		$meta_key1 = '_secretevent';
		$meta_key1_value = 'true';
		
		$postids = $wpdb->get_col( $wpdb->prepare( 
			"
			SELECT      key1.post_id
			FROM        $wpdb->postmeta key1
		
			WHERE       key1.meta_key = %s
			AND key1.meta_value = %s
		
			",
			$meta_key1,
			$meta_key1_value
		) ); 
		
		if( $postids )
		$query->set('post__not_in', $postids ); // id of page or post
	}
	return $query;
}
add_filter( 'pre_get_posts', 'kal3000_secretevents_exclude_search' );

function kal3000_termine_save_postdata( $post_id ) {
	 // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	 // Bail if nonce is breaking
	if( !isset( $_POST['wpcalendar_noncename'] ) || !wp_verify_nonce( $_POST['wpcalendar_noncename'], 'my_wpcalendar_noncename' ) ) return;
 
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post', $post_id ) ) return;

	update_post_meta($_POST['post_ID'], '_wpcal_from', $_POST['wpc_from'], false); 
	
	update_post_meta($_POST['post_ID'], '_lat', $_POST['wpc_lat'], false); 
	update_post_meta($_POST['post_ID'], '_lon', $_POST['wpc_lon'], false); 
	update_post_meta($_POST['post_ID'], '_geoshow', $_POST['wpc_geoshow'], false); 
	update_post_meta($_POST['post_ID'], '_zoom', $_POST['wpc_zoom'], false); 
	update_post_meta($_POST['post_ID'], '_geostadt', $_POST['wpc_geocity'], false); 
	update_post_meta($_POST['post_ID'], '_veranstalter', $_POST['wpc_veranstalter'], false); 
	update_post_meta($_POST['post_ID'], '_veranstalterlnk', $_POST['wpc_veranstalterlnk'], false); 
	//update_post_meta($_POST['post_ID'], '_secretevent', $_POST['wpc_secretevent']); 
	 
	$wert14 = "";
	if(isset($_POST["wpc_secretevent"])) {
		$wert14 = $_POST["wpc_secretevent"];
	}   
	update_post_meta($_POST['post_ID'], '_secretevent', $wert14); 

	update_post_meta($_POST['post_ID'], '_bis', $_POST['wpc_until'], false); 
	$zeitstempel = strftime( strToTime( $_POST['wpc_from'] ) );
	if(!$zeitstempel) {
		// strftime doesn't seem to work, so let's get creative
		preg_match("/([0-9]{1,2}).\s(\w{1,})\s([0-9]{4})\s([0-9]{2}):([0-9]{2})/", $_POST['wpc_from'], $zeitstempel);
		
		$month_number = "";
		for($i=1;$i<=12;$i++){
			if(strtolower(date_i18n("F", mktime(0, 0, 0, $i, 1, 0))) == strtolower($zeitstempel[2])){
				$month_number = $i;
				break;
			}
		}

		$zeit = mktime($zeitstempel[4], $zeitstempel[5], 0, $month_number, $zeitstempel[1], $zeitstempel[3]);
		$zeitstempel = date_i18n('U', $zeit);
	}
	update_post_meta($_POST['post_ID'], '_zeitstempel', $zeitstempel, false); 
}
add_action( 'save_post', 'kal3000_termine_save_postdata' );

function kal3000_termine_add_custom_box() {
	add_meta_box(
		'termine_sectionid', 'Termininfos', 'kal3000_termine_inner_custom_box','termine', 'side','high'
	);
}
add_action( 'add_meta_boxes', 'kal3000_termine_add_custom_box' );

function kal3000_termine_inner_custom_box( $post ) {
	wp_nonce_field( 'my_wpcalendar_noncename', 'wpcalendar_noncename' );
	global $pagenow;
	$isnew = ($pagenow === 'post-new.php') ? true : false;
	$kal3000_options = get_option( 'kal3000_settings' );

	$from=get_post_meta(get_the_ID(), '_wpcal_from',true);
	echo '<input type="text" id="wpcal-from" placeholder="Beginn" name="wpc_from" value="'.$from.'">';

	echo '<br/>';
	$wert7=get_post_meta(get_the_ID(), '_bis',true);
	echo '<input type="text" id="termine_new_field7" name="wpc_until" placeholder="Bis (bel. Text)" value="'.$wert7.'" />';
	
	$wert8=get_post_meta(get_the_ID(), '_geoshow',true);
	if(!$wert8 && $isnew) $wert8 = @$kal3000_options['kal3000_text_field_0'];
	echo '<div class="spacer"></div><input type="text" id="termine_new_field8" name="wpc_geoshow" placeholder="Angezeigte Adresse (ohne Stadt)" value="'.$wert8.'" style="width:90%" />';
	
	$wert11=get_post_meta(get_the_ID(), '_geostadt',true);
	if(!$wert11 && $isnew) $wert11 = @$kal3000_options['kal3000_text_field_1'];
	echo '<input type="text" id="termine_new_field11" name="wpc_geocity" placeholder="Stadt" value="'.$wert11.'" style="width:90%" />';
	
	$wert12=get_post_meta(get_the_ID(), '_veranstalter',true);
	if(!$wert12 && $isnew) $wert12 = @$kal3000_options['kal3000_text_field_2'];
	echo '<br><br>Veranstalter (optional):<br><input type="text" id="termine_new_field12" name="wpc_veranstalter" placeholder="Veranstalter" value="'.$wert12.'" style="width:90%" />';
	
	$wert13=get_post_meta(get_the_ID(), '_veranstalterlnk',true);
	if(!$wert13 && $isnew) $wert13 = @$kal3000_options['kal3000_text_field_3'];
	echo '<input type="text" id="termine_new_field13" name="wpc_veranstalterlnk" placeholder="Link zum Veranstalter https://" value="'.$wert13.'" style="width:90%" />';
	
	$wert14=get_post_meta(get_the_ID(), '_secretevent', true);

	if($wert14 == "") { ?>
		<br><br><input name="wpc_secretevent" id="termine_new_field14" type="checkbox" value="true"> Geheime Veranstaltung<br>
    <?php } else if($wert14 == "true") { ?>  
		<br><br><input name="wpc_secretevent" id="termine_new_field14"  type="checkbox" value="true" checked> Geheime Veranstaltung<br>
	<?php }
		
	echo '<br/>';

	echo '<div style="display:none">';

		$wert6=get_post_meta(get_the_ID(), '_lat',true);
		if(!$wert6 && $isnew) $wert6 = @$kal3000_options['kal3000_text_field_4'];
		echo '<input  id="termine_new_field6" name="wpc_lat" placeholder="Lat (ca. 48.5)" value="'.$wert6.'" style="width:15%" />';
	
		$wert9=get_post_meta(get_the_ID(), '_lon',true);
		if(!$wert9 && $isnew) $wert9 = @$kal3000_options['kal3000_text_field_5'];
		echo '<input  id="termine_new_field9" name="wpc_lon" placeholder="Lon (ca. 11.4)" value="'.$wert9.'" style="width:15%" />';
	
		$wert10=get_post_meta(get_the_ID(), '_zoom',true);
		if(!$wert10 && $isnew) $wert10 = @$kal3000_options['kal3000_text_field_6'];
		echo '<input  id="termine_new_field10" name="wpc_zoom" placeholder="Zoom (11-13)" value="'.$wert10.'" style="width:15%" />';

	echo '</div>';

?>
<script type="text/javascript">
	function popup (url) {
		fenster = window.open(url, "Landkarte", "width=650,height=300,resizable=yes");
		fenster.focus();
		return false;
	}

	function setPin( lat, lng, zoom, address, city){
		jQuery('#termine_new_field6').val( lat );
		jQuery('#termine_new_field9').val( lng );
		jQuery('#termine_new_field10').val( zoom );
		jQuery('#termine_new_field8').val( address );
		jQuery('#termine_new_field11').val( city );
	}
</script>
	<?php 	echo ' <a href="' . get_template_directory_uri() . '/functions/kal3000/map/?lat='.$wert6.'&lng='.$wert9.'&zoom='.$wert10.'" target="_blank" onclick="return popup(this.href);">Landkarte anzeigen</a> <br/><div style="opacity:0.6; font-size:11px; margin-top: 10px; line-height: 150%;">Damit die Landkarte angezeigt wird, bitte einmal hier klicken und den Punkt im sich öffnenden Karten-Fenster an die gewünschte Stelle bewegen. Danach kann das Fenster wieder geschlossen und der Termin aktualisiert werden.</div>'; ?>
<?php
}

function kal3000_the_termin(){
	$meta_angabe_zeit=get_post_custom( get_the_ID());
	$wpcal_from = date_create_from_format( 'd.m.Y H:i', $meta_angabe_zeit['_wpcal_from'][0] );
	$wpcal_from_u = get_date_from_gmt( $wpcal_from->format('Y-m-d H:i:s'), 'U' );
	
	$echo = "\n\n<div class='termin_meta'>\n";
	if(date('G',$meta_angabe_zeit['_zeitstempel'][0])==0){
		// Ohne Stundenangabe
		$echo .= '<span class="termin_tag">';
			echo date('l, j. F Y', $wpcal_from_u);
		if(isset($meta_angabe_zeit['_bis']) AND $meta_angabe_zeit['_bis'][0]!='') { 
			$echo .= ' bis '.$meta_angabe_zeit['_bis'][0];
		}

		$echo .= "</span>\n";

	} else {
		if(isset($meta_angabe_zeit['_bis']) AND $meta_angabe_zeit['_bis'][0]!='') {
			$echo .= '<span class="termin_tag">';
				$echo .= date_i18n('l, j. F Y, H:i', $wpcal_from_u);
				$echo .= ' Uhr';
			$echo .= '</span>';
			$echo .= '<span class="termin_zeit">';
				$echo .= 'Bis ';
				$echo .= $meta_angabe_zeit['_bis'][0];
				$echo .= ' Uhr';
			$echo .= "</span>\n";
		}else {
			$echo .= '<span class="termin_tag">';
				$echo .= date_i18n('l, j. F Y', $wpcal_from_u);
			$echo .= '</span>';
			$echo .= '<span class="termin_zeit">';
				$echo .= date_i18n('H:i', $wpcal_from_u);
				$echo .= ' Uhr';
			$echo .= "</span>\n";
		}
	}

	if(isset($meta_angabe_zeit['_geostadt']) AND $meta_angabe_zeit['_geostadt'][0]!=''){
		$echo .= '<span class="termin_ort">';
		$echo .= $meta_angabe_zeit['_geoshow'][0];
		if($meta_angabe_zeit['_geoshow'][0]!='' AND isset($meta_angabe_zeit['_geostadt'])) $echo .= ', ';
			$echo .= $meta_angabe_zeit['_geostadt'][0];
			$echo .= '</span>';
		}

	if($meta_angabe_zeit['_veranstalter'][0]!='') {
		$echo .= '<span class="termin_veranstalter">Veranstaltet von: ';
		if($meta_angabe_zeit['_veranstalter'][0]!='' AND $meta_angabe_zeit['_veranstalterlnk'][0]!='') {
			$echo .= '<a href="';
			$echo .= $meta_angabe_zeit['_veranstalterlnk'][0];
			$echo .= '">';
			$echo .= $meta_angabe_zeit['_veranstalter'][0];
			$echo .= '</a>';
		} else {
			$echo .= $meta_angabe_zeit['_veranstalter'][0];
		}
		$echo .= '</span>';
	}

	$echo .= "\n</div><!-- /meta -->\n";
	return $echo;
}

function kal3000_the_termin_short(){
	$meta_angabe_zeit=get_post_custom( get_the_ID());
	echo "\n\n<div class='termin_meta_kurz'>\n";
		// Ohne Stundenangabe
		echo '<span class="termin_wochentag_kurz">' . date_i18n('l', $meta_angabe_zeit['_zeitstempel'][0]) . '</span>';
		echo '<span class="termin_datum_kurz">' . date_i18n('d.m.Y',$meta_angabe_zeit['_zeitstempel'][0]) . '</span>';
		if(isset($meta_angabe_zeit['_geostadt']) AND $meta_angabe_zeit['_geostadt'][0]!=''){ echo '<span class="termin_ort_kurz">'.$meta_angabe_zeit['_geostadt'][0].'</span>'; }
	echo "\n</div><!-- /meta -->\n";
}

function kal3000_the_termin_geo(){
	$custom=get_post_custom( get_the_ID());
	if(isset($custom['_geoshow']) AND $custom['_geoshow'][0]!='' AND isset($custom['_lat']) AND !empty(array_filter($custom['_lat']))){
		ob_start(); ?>
		<div id="termin_map_wrapper">
			<div id="termin_map" style="width:100%; height:300px"></div>
			<a href="https://www.openstreetmap.org/?mlat=<?=$custom['_lat'][0]?>&mlon=<?=$custom['_lon'][0]?>#map=<?=$custom['_zoom'][0]?>/<?=$custom['_lat'][0]?>/<?=$custom['_lon'][0]?>" target="_blank">Kartenausschnitt auf OpenStreetMap anzeigen</a>
			<script>
			var map = L.map('termin_map').setView([<?=$custom['_lat'][0]?>, <?=$custom['_lon'][0]?>], <?=$custom['_zoom'][0]?>);
			mapLink = '<a href="https://openstreetmap.org">OpenStreetMap</a>';
			L.tileLayer(
			'https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: 'Map data © ' + mapLink,
			maxZoom: 18,
			}).addTo(map);
			
			var greenIcon = L.icon({
			    iconUrl: ' <?= get_template_directory_uri() . '/functions/kal3000/map/images/icon.png'?>',
			    shadowUrl: '<?= get_template_directory_uri() . '/functions/kal3000/map/images/icon-shadow.png'?>',
			
			    iconSize:     [21, 34], // size of the icon
			    shadowSize:   [35, 34], // size of the shadow
			    iconAnchor:   [11, 34], // point of the icon which will correspond to marker's location
			    shadowAnchor: [10, 34],  // the same for the shadow
			    popupAnchor:  [0, -30] // point from which the popup should open relative to the iconAnchor
			});
			var marker = L.marker([<?=$custom['_lat'][0]?>, <?=$custom['_lon'][0]?>],{icon:greenIcon}).addTo(map).bindPopup("<a href=<?="https://www.openstreetmap.org/?mlat={$custom['_lat'][0]}&mlon={$custom['_lon'][0]}#map={$custom['_zoom'][0]}/{$custom['_lat'][0]}/{$custom['_lon'][0]}"?> class=\"noicon\">&rarr; <?=$custom['_geoshow'][0]?></a>").openPopup();
			</script>
		</div>
<?php	$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
}

function kal3000_add_content( $content ) {
	if( 'termine' != get_post_type() )
      return $content;

	$custom_content = kal3000_the_termin();
	$custom_content .= $content;
	if(apply_filters( 'kal3000_ical', true )) {
		$custom_content .= '<p style="font-size:13px;"><i class="fas fa-download" style="margin-right: 5px;"></i> <a href="' . get_permalink() . '/?ical=true">Diesen Termin als iCal-Datei herunterladen</a></p>';
	}
	$custom_content .= kal3000_the_termin_geo();
	return $custom_content;
}
add_filter( 'the_content', 'kal3000_add_content' );

/*Widget Liste */
class kal3000_termine_liste_widget extends WP_Widget {
	//Einstellungen
	function __construct() {
		$widget_ops = array('description' => 'Liste der angelegten Termine');
		parent::__construct(false, __('Termine'),$widget_ops);
	}

	//Form Admin-Area
 	public function form($instance)  {
		$defaults = array(
			'title' => 'Termine',
			'cat' => '',
			'limit' => '5'
		);
		$instance = wp_parse_args((array)$instance, $defaults);

		$title = $instance['title'];
		$cat = $instance['cat'];
		$limit = $instance['limit'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Titel:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cat'); ?>"><?php echo 'Termin-Kategorie:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" type="text" value="<?php echo esc_attr($cat); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php echo 'Anzahl:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo esc_attr($limit); ?>" />
		</p>
		<?php
	}

	//Save form
	public function update($new_instance, $old_instance) {
		$instance = array();
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['cat'] = strip_tags($new_instance['cat']);
		$instance['limit'] = (int)$new_instance['limit'];

		return $instance;
	}

	//widget frontend
	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$cat = $instance['cat'];
		$limit = $instance['limit'];

		echo $before_widget;
		
		if(!empty($title)) {
			echo $before_title . $title . $after_title;
		} ?>
		<ul>
			<?php	// Start your custom WP_query
					$my_query = new WP_query();
					$args = array('post_type'=>'termine',
						'orderby' => 'meta_value',
						'termine_type' => $cat,
						'meta_key' => '_zeitstempel',
						'posts_per_page' => $limit,
							'order' => 'ASC',
							'meta_query' => array(
								array(
									'key' => '_zeitstempel',
									'value' => time(),
									'compare' => '>='
								),
								array(
									'key' => '_secretevent',
									'value' => 'true',
									'compare' => 'NOT IN'
								)
						)
					);
					// Assign predefined $args to your query
					$my_query->query($args);
			while ($my_query->have_posts()) : $my_query->the_post(); ?>
				<li <?php post_class('clearfix'); ?>>
					<?php  if(function_exists('kal3000_the_termin_short')) kal3000_the_termin_short(); ?>
					<h4><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
					<?php the_excerpt();?>
				</li>
			<?php endwhile; 
			wp_reset_query();
		?></ul><?php
		echo $after_widget;
	}
	
}
add_action('widgets_init', function() { return register_widget('kal3000_termine_liste_widget'); });

/*Widget Karte */
class kal3000_termine_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'kal3000_termine_widget', 'description' => 'Alle Termine auf einer Karte' );
		parent::__construct(false, __('Termine Widgets (Karte)'),$widget_ops);
	}

 	//Form Admin-Area
 	public function form($instance)  {
		$defaults = array(
			'title' => 'Terminkarte',
			'lon' => '11',
			'lat' => '50',
			'zoom' => '5'
		);
		$instance = wp_parse_args((array)$instance, $defaults);

		$title = $instance['title'];
		$lon = $instance['lon'];
		$lat = $instance['lat'];
		$zoom = $instance['zoom'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Titel:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('lon'); ?>"><?php echo 'Längengrad:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('lon'); ?>" name="<?php echo $this->get_field_name('lon'); ?>" type="text" value="<?php echo esc_attr($lon); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('lat'); ?>"><?php echo 'Breitengrad:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('lat'); ?>" name="<?php echo $this->get_field_name('lat'); ?>" type="text" value="<?php echo esc_attr($lat); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('zoom'); ?>"><?php echo 'Zoom (1-9):'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('zoom'); ?>" name="<?php echo $this->get_field_name('zoom'); ?>" type="text" value="<?php echo esc_attr($zoom); ?>" />
		</p>
		<?php
	}
 
	//Save form
	public function update($new_instance, $old_instance) {
		$instance = array();
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['lat'] = strip_tags($new_instance['lat']);
		$instance['lon'] = strip_tags($new_instance['lon']);
		$instance['zoom'] = (int)$new_instance['zoom'];

		return $instance;
	}
	
	function widget($args, $instance)  {
		extract($args, EXTR_SKIP);

		$title = apply_filters('widget_title', $instance['title']);
		$lat = $instance['lat'];
		$lon = $instance['lon'];
		$zoom = $instance['zoom'];
	
		echo $before_widget;
	
		if(!empty($title)) {
			echo $before_title . $title . $after_title;
		} ?>
		<div id="termin_karte" style="">
			<div id="termin_karte_map" style="width:100%; height:350px;"></div>
			<script>
				var map = L.map('termin_karte_map',{ zoomControl:false }).setView([<?=$lat?>, <?=$lon?>], <?=$zoom?>);
				mapLink = '<a href="https://openstreetmap.org">OpenStreetMap</a>';
				L.tileLayer(
				'https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
				attribution: 'Map data © ' + mapLink,
				maxZoom: 18,
				}).addTo(map);
				
				var greenIcon = L.icon({
				  iconUrl: ' <?= get_template_directory_uri() . '/functions/kal3000/map/images/icon.png'?>',
					shadowUrl: '<?= get_template_directory_uri() . '/functions/kal3000/map/images/icon-shadow.png'?>',
				
					iconSize:	 [21, 34], // size of the icon
					shadowSize:   [35, 34], // size of the shadow
					iconAnchor:   [11, 34], // point of the icon which will correspond to marker's location
					shadowAnchor: [10, 34],  // the same for the shadow
					popupAnchor:  [0, -30] // point from which the popup should open relative to the iconAnchor
				});
				
				var blueIcon = L.icon({
					iconUrl: ' <?= get_template_directory_uri() . '/functions/kal3000/map/images/icon.png'?>',
					shadowUrl: '<?= get_template_directory_uri() . '/functions/kal3000/map/images/icon-shadow.png'?>',
				
					iconSize:	 [21, 34], // size of the icon
					shadowSize:   [35, 34], // size of the shadow
					iconAnchor:   [11, 34], // point of the icon which will correspond to marker's location
					shadowAnchor: [10, 34],  // the same for the shadow
					popupAnchor:  [0, -30] // point from which the popup should open relative to the iconAnchor
				});
			
				<?php
				$termine = get_posts(array('post_type'=>'termine',
					'orderby' => 'meta_value',
					'meta_key' => '_zeitstempel',
					'posts_per_page' => 50,
					'order' => 'DESC',
					'meta_query' => array(
						array(
							'key' => '_zeitstempel',
							'value' => time(),
							'compare' => '>='
						),
						array(
							'key' => '_secretevent',
							'value' => 'true',
							'compare' => 'NOT IN'
						)
					)
				));

				foreach ($termine AS $termin){
					$lat = get_post_meta( $termin->ID, '_lat', true );
					$lon = get_post_meta( $termin->ID, '_lon', true );

					$ort = preg_replace('/,/', '\\,' , utf8_decode( get_post_meta( $termin->ID, '_geoshow', true ) . ' ' . get_post_meta( $termin->ID, '_geostadt', true ) ) );
					$tag = sprintf( '%04d%02d%02d' , 
					get_post_meta( $termin->ID, '_jahr', true ),
					get_post_meta( $termin->ID, '_monat', true ),
					get_post_meta( $termin->ID, '_tag', true ) );

					$stunde = sprintf( '%02d', get_post_meta( $termin->ID, '_stunde', true ) );
					$minute = sprintf( '%02d', get_post_meta( $termin->ID, '_minute', true ) );

					$dtstart = "{$tag}T{$stunde}{$minute}00Z";
					$stundebis = sprintf( '%02d', ($stunde + 1 ) );
					$dtend = "{$tag}T{$stundebis}{$minute}00Z";
					$titelcal = preg_replace('/,/', '\\,' , utf8_decode($termin->post_title) );
					$descriptioncal = preg_replace('/,/', '\\,' , utf8_decode($termin->post_name) );

					if( $lat == '' ) continue; ?>
						var marker = L.marker([<?=$lat?>, <?=$lon?>],{icon:greenIcon}).addTo(map).bindPopup("<a href=\"/termin/<?="$termin->post_name"?>\" class=\"noicon\">&rarr; <?=wordwrap($termin->post_title, 20, '<br/>')?></a>");
					<?php
				}

				$termine = get_posts(array('post_type'=>'post',		 
					'posts_per_page' => 50,
					'order' => 'DESC'
				));
				$tz=0;
				foreach ($termine AS $termin){
					$lat = get_post_meta( $termin->ID, '_lat', true );
					$lon = get_post_meta( $termin->ID, '_lon', true );

					if( $lat == '') continue;
						$tz++;
					if($tz > 7 ) break; ?>
						var marker = L.marker([<?=$lat?>, <?=$lon?>],{icon:blueIcon}).addTo(map).bindPopup("<a href=\"/<?=$termin->post_name;?>\" class=\"noicon\">&rarr; <?=wordwrap($termin->post_title, 20, '<br/>')?></a>"); 
						<?php
					}
					?>
				</script>
			</div>
	<?php	echo $after_widget;
		}
	}
	add_action( 'widgets_init', function() { return register_widget('kal3000_termine_widget'); });
	
	function kal3000_shortcode_overview( $atts ) {
	extract(shortcode_atts(array(
		'archiv' => 'false',
		'thumbnail' => 'ja',
		'kat' => '',
		'maxmonths' => false,
		'anzahl' => 50,
	), $atts));
	
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
	
	$wp_query->query($args);
	ob_start(); ?>			
		<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
			<article <?php post_class('clearfix'); ?>>
				 <?php if ( has_post_thumbnail() && $thumbnail === 'ja'): ?>
					<div class="postimg">
						<?php the_post_thumbnail('titelbild');  ?>
					</div>
				<?php endif; ?>
				<?php  if(function_exists('kal3000_the_termin_short')) kal3000_the_termin_short(); ?>
				<h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
				<?php if ( has_excerpt() ) {
					the_excerpt();
				} ?>
				<a href="<?php the_permalink();?>" class="weiterlesen">Termindetails »</a>
			</article>
			
		<?php endwhile; ?>
	
	<?php $wp_query = null; $wp_query = $temp;
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode( 'wpcalendar', 'kal3000_shortcode_overview' );

/*
Additional Fallback Definitions
Sponsored by Grüne Ratsfraktion Freiburg
*/
function kal3000_add_admin_menu(  ) { 
	add_submenu_page( 'edit.php?post_type=termine', 'kal3000', 'Einstellungen', 'manage_options', 'kal3000', 'kal3000_options_page' );
}
add_action( 'admin_menu', 'kal3000_add_admin_menu' );

function kal3000_settings_init(  ) { 
	register_setting( 'pluginPage', 'kal3000_settings' );

	add_settings_section(
		'kal3000_pluginPage_section', 
		'', 
		'kal3000_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'kal3000_text_field_0', 
		__( 'Standard für „Angezeigte Adresse“', 'kal3000_' ), 
		'kal3000_text_field_0_render', 
		'pluginPage', 
		'kal3000_pluginPage_section' 
	);

	add_settings_field( 
		'kal3000_text_field_1', 
		__( 'Standard für „Stadt“', 'kal3000_' ), 
		'kal3000_text_field_1_render', 
		'pluginPage', 
		'kal3000_pluginPage_section' 
	);

	add_settings_field( 
		'kal3000_text_field_2', 
		__( 'Standard für „Veranstalter“', 'kal3000_' ), 
		'kal3000_text_field_2_render', 
		'pluginPage', 
		'kal3000_pluginPage_section' 
	);

	add_settings_field( 
		'kal3000_text_field_3', 
		__( 'Standard für „Link zum Veranstalter“', 'kal3000_' ), 
		'kal3000_text_field_3_render', 
		'pluginPage', 
		'kal3000_pluginPage_section' 
	);

	add_settings_field( 
		'kal3000_text_field_4', 
		__( 'Standard für „Breitengrad“', 'kal3000_' ), 
		'kal3000_text_field_4_render', 
		'pluginPage', 
		'kal3000_pluginPage_section' 
	);

	add_settings_field( 
		'kal3000_text_field_5', 
		__( 'Standard für „Längengrad“', 'kal3000_' ), 
		'kal3000_text_field_5_render', 
		'pluginPage', 
		'kal3000_pluginPage_section' 
	);

	add_settings_field( 
		'kal3000_text_field_6', 
		__( 'Standard für „Zoomstufe', 'kal3000_' ), 
		'kal3000_text_field_6_render', 
		'pluginPage', 
		'kal3000_pluginPage_section' 
	);
}
add_action( 'admin_init', 'kal3000_settings_init' );

function kal3000_text_field_0_render(  ) { 
	$options = get_option( 'kal3000_settings' ); ?>
	<input type='text' name='kal3000_settings[kal3000_text_field_0]' value='<?php echo $options['kal3000_text_field_0']; ?>'>
<?php }


function kal3000_text_field_1_render(  ) { 
	$options = get_option( 'kal3000_settings' ); ?>
	<input type='text' name='kal3000_settings[kal3000_text_field_1]' value='<?php echo $options['kal3000_text_field_1']; ?>'>
<?php }


function kal3000_text_field_2_render(  ) { 
	$options = get_option( 'kal3000_settings' ); ?>
	<input type='text' name='kal3000_settings[kal3000_text_field_2]' value='<?php echo $options['kal3000_text_field_2']; ?>'>
<?php }

function kal3000_text_field_3_render(  ) { 
	$options = get_option( 'kal3000_settings' ); ?>
	<input type='text' name='kal3000_settings[kal3000_text_field_3]' value='<?php echo $options['kal3000_text_field_3']; ?>'>
<?php }

function kal3000_text_field_4_render(  ) { 
	$options = get_option( 'kal3000_settings' ); ?>
	<input type='text' name='kal3000_settings[kal3000_text_field_4]' value='<?php echo $options['kal3000_text_field_4']; ?>'>
<?php }

function kal3000_text_field_5_render(  ) { 
	$options = get_option( 'kal3000_settings' ); ?>
	<input type='text' name='kal3000_settings[kal3000_text_field_5]' value='<?php echo $options['kal3000_text_field_5']; ?>'>
<?php }

function kal3000_text_field_6_render(  ) { 
	$options = get_option( 'kal3000_settings' ); ?>
	<input type='text' name='kal3000_settings[kal3000_text_field_6]' value='<?php echo $options['kal3000_text_field_6']; ?>'>
<?php }

function kal3000_settings_section_callback(  ) { 
	echo __( '<p>Hier könnt ihr Standardwerte für die Einstellungen pro Termin vergeben. Wenn also ein neuer Termin erstellt wird, werden diese Felder entsprechen vorausgefüllt werden.</p><p>Die Werte für Breitengrad und Längengrad erwarten Zahlen im Format xx.xxxxxxx, die Zoomstufe eine Zahl zwischen 0 und 19. Die Werte bekommt ihr am einfachsten über eine GoogleMaps-Suche nach eurem Standort, dort stehen sie in der Adresszeile.</p>', 'kal3000_' );
}

function kal3000_options_page(  ) { ?>
	<form action='options.php' method='post'>
		<h2>Einstellungen für Kal3000</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
<?php }
	
/*
Add iCal-file generation
*/
function ical3000_render( $original_template ) {
	if(is_singular('termine') && @$_GET['ical'] == true) {
		return get_template_directory() . '/functions/kal3000/ical3000.php';
	}
	
	return $original_template;
}
add_action('template_include', 'ical3000_render');