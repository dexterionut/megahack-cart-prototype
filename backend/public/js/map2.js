function initMap() {
  var geocoder;
  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer();

  var pos = {
    lat: 44.439663,
    lng: 26.096306,
    info: 'Promenada'
  }
  // var locations = [
  //   [pos.info, pos.lat, pos.lng],
  //   ['Promenada', 44.439663, 26.096306],
  //   ['Dristor', 44.539663, 26.096406],
  //   ['Timpuri Noi', 44.439563, 26.016306]
  // ];
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: new google.maps.LatLng(44.439663, 26.096306),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  directionsDisplay.setMap(map);
  var infoWindow = new google.maps.InfoWindow();
  var marker, i;
  var request = {
    travelMode: google.maps.TravelMode.DRIVING
  } 

  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      pos.lat = position.coords.latitude;
      pos.lng = position.coords.longitude;

      // map.setCenter(pos);
      //   marker = new google.maps.Marker({
      //   position: pos,
      //   map: map,
      //   info: 'Promenada'
      // });
      var locations = shops;
  //       var locations = [
  //   // [pos.info, pos.lat, pos.lng],
  //   // ['Promenada', 44.439663, 26.096306],
  //   {name: pos.info, latitudine: pos.lat, longitudine: pos.lng},
  //   {name: 'Promenada', latitudine: 44.439613, longitudine: 26.093306},
  //   // ['Dristor', 44.539663, 26.096406],
  //   // ['Timpuri Noi', 44.439563, 26.016306]
  // ];

  //directionsDisplay.setMap(map);
  
  for (i = 0; i < locations.length; i++) {
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(locations[i].latitudine, locations[i].longitudine),
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(locations[i].dealer_name);
        infowindow.open(map, marker);
      }
    })(marker, i));

    if (i == 0) request.origin = marker.getPosition();
    else if (i == locations.length - 1) request.destination = marker.getPosition();
    else {
      if (!request.waypoints) request.waypoints = [];
      request.waypoints.push({
        location: marker.getPosition(),
        stopover: true
      });
    }

  }
  directionsService.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(result);
    }
  });
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter(), map);
    });
  }
  else {
    handleLocationError(false, infoWindow, map.getCenter(), map);
  }
  function handleLocationError(input, infoWindow, center, map) {
    infoWindow.setContent("ERROR: " + input);
    //infoWindow.setPosition(center);
    infoWindow.open(map);
  }

  // var locations = [
  //   [pos.info, pos.lat, pos.lng],
  //   ['Promenada', 44.439663, 26.096306],
  //   ['Dristor', 44.539663, 26.096406],
  //   ['Timpuri Noi', 44.439563, 26.016306]
  // ];

  // //directionsDisplay.setMap(map);
  
  // for (i = 0; i < locations.length; i++) {
  //   marker = new google.maps.Marker({
  //     position: new google.maps.LatLng(locations[i][1], locations[i][2]),
  //   });

  //   google.maps.event.addListener(marker, 'click', (function(marker, i) {
  //     return function() {
  //       infowindow.setContent(locations[i][0]);
  //       infowindow.open(map, marker);
  //     }
  //   })(marker, i));

  //   if (i == 0) request.origin = marker.getPosition();
  //   else if (i == locations.length - 1) request.destination = marker.getPosition();
  //   else {
  //     if (!request.waypoints) request.waypoints = [];
  //     request.waypoints.push({
  //       location: marker.getPosition(),
  //       stopover: true
  //     });
  //   }

  // }
  // directionsService.route(request, function(result, status) {
  //   if (status == google.maps.DirectionsStatus.OK) {
  //     directionsDisplay.setDirections(result);
  //   }
  // });
}
google.maps.event.addDomListener(window, "load", initialize);