var map, infoWindow;
function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: 44.439663,
				 lng: 26.096306},
		zoom: 12
	});
	infoWindow = new google.maps.InfoWindow;

	// HTML5 geolocation
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};

			infoWindow.setPosition(pos);
			infoWindow.setContent("Location found!");
			infoWindow.open(map);
			map.setCenter(pos);
		}, function() {
			handleLocationError(true, infoWindow, map.getCenter());
		});
	}
	else {
		handleLocationError(false, infoWindow, map.getCenter());
	}

	new AutocompleteDirectionsHandler(map);
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
	infoWindow.setPosition(pos);
	infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
	infoWindow.open(map);
} 

function AutocompleteDirectionsHandler(map) {
	this.map = map;
	if(navigator.geolocation) { 
		var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
		this.originPlaceId = pos;
	}
	this.destinationPlaceId = null;
	this.travelMode = 'WALKING';

	var originInput = document.getElementById('origin-input');
	var destinationInput = document.getElementById('destination-input');
	var modeSelector = document.getElementById('mode-selector');

	this.directionsService = new google.maps.DirectionsService;
	this.directionsDisplay = new google.maps.DirectionsRenderer;
	this.directionsDisplay.setMap(map);

	var originAutocomplete = new google.maps.places.Autocomplete(originInput, {placeIdOnly: true});
	var destinationAutocomplete = new google.maps.places.Autocomplete(destinationInput, {placeIdOnly: true});

	this.setupClickListener('changemode-walking', 'WALKING');
	this.setupClickListener('changemode-transit', 'TRANSIT');
	this.setupClickListener('changemode-driving', 'Driving');

	this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
	this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');

	this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(originInput);
	this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(destinationInput);
	this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(modeSelector);
}

// Listener on a radio button to change the filter type on Place Autocomplete
AutocompleteDirectionsHandler.prototype.setupClickListener = function(id, mode) {
	var radioButton = document.getElementById(id);
	var me = this;
	radioButton.addEventListener('click', function() {
		me.travelMode = mode;
		me.route();
	});
};

AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(autocomplete, mode) {
	var me = this;
	autocomplete.bindTo('bounds', this.map);
	autocomplete.addListener('place_changed', function() {
		var place = autocomplete.getPlace();
		if(!place.place_id) {
			window.alert("Please select an option!");
			return;
		}
		if(mode == 'ORIG') {
			me.originPlaceId = place.place_id;
		}
		else {
			me.destinationPlaceId = place.place_id;
		}
		me.route();
	});
};

AutocompleteDirectionsHandler.prototype.route = function() {
	if(!this.originPlaceId || !this.destinationPlaceId) {
		return;
	}
	var me = this;

	this.directionsService.route({
		origin: {
			'placeId': this.originPlaceId
		},
		destination: {
			'placeId': this.destinationPlaceId
		},
		travelMode: this.travelMode
	}, function(response, status) {
		if(status == 'OK') {
			me.directionsDisplay.setDirections(response);
		}
		else {
			window.alert('Directions request failed due to ' + status);
		}
	});
};

