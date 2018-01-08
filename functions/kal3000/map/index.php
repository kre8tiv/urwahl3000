<!DOCTYPE html>
<html style="height:100%">
<head>
	<title>wpCalendar</title>
	<meta charset="utf-8" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/leaflet.js"></script>
	<script src="js/leaflet-search.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false"></script>
	<link rel="stylesheet" href="css/leaflet.css" />
	<link rel="stylesheet" href="css/leaflet-search.css" />
</head>
<body style="padding:0;margin:0;height:100%">
	<div id="map" style="width: 100%; height: 100%"></div>

	<script>

		var maptiles;
		var markers = new Array();
		maptiles = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
		//  'https://{s}.tiles.mapbox.com/v3/examples.map-i87786ca/{z}/{x}/{y}.png';
   		var title; // Usereingaben

<?php
if(isset($_GET['lat']) AND $_GET['lat'] != '' ){
	$lat = $_GET['lat'];
	$lng = $_GET['lng'];
	$zoom = $_GET['zoom'];
}else{
	$lat = 48;
	$lng = 11;
	$zoom = 8;
}
?>
	var map = L.map('map').setView([<?=$lat?>,<?=$lng?>],<?=$zoom?> );





	L.tileLayer(maptiles, {
		maxZoom: 18,
		attribution: '',
		id: 'mymap957'
	}).addTo(map);

	var geocoder = new google.maps.Geocoder();

	function googleGeocoding(text, callResponse)
	{
		geocoder.geocode({address: text}, callResponse);
		
	}

	function filterJSONCall(rawjson)
	{
		var json = {},
			key, loc, disp = [];

		for(var i in rawjson){
			key = rawjson[i].formatted_address;		
			loc = L.latLng( rawjson[i].geometry.location.lat(), rawjson[i].geometry.location.lng() );			
			json[ key ]= loc;	//key,value format			
		}

		return json;
	}

	map.addControl( new L.Control.Search({
			callData: googleGeocoding,
			filterJSON: filterJSONCall,
			markerLocation: false,
			autoType: false,
			autoCollapse: true,
			minLength: 2,
			zoom: 16,
			text: 'Suchen',
			animateLocation: true,
			collapsed: false
		}) );



var draggableIcon = L.icon({
	iconUrl: 'images/draggable.png',	    
	iconSize:     [32, 32], 
	iconAnchor:   [16, 32], 
	popupAnchor:  [0, -32] 
});






var marker = L.marker(	map.getCenter(),	{icon:draggableIcon,draggable:true}).addTo(map);

marker.on('dragend', draggable_popup );

//map.doubleClickZoom.disable(); 
map.on('click',        function (e) {
	marker.setLatLng(e.latlng);
	draggable_popup();
});


function draggable_popup(){
	$('#termine_new_field6', opener.document).val( marker.getLatLng().lat );
	$('#termine_new_field9', opener.document).val( marker.getLatLng().lng );
	$('#termine_new_field10', opener.document).val( map.getZoom() );

	console.log('Lat=' +  marker.getLatLng().lat);
	console.log('Lon=' +  marker.getLatLng().lng);
	console.log('Zoom=' +  map.getZoom());
}


map.on('zoomend', function() {
	draggable_popup();
} );


</script>
</body>
</html>