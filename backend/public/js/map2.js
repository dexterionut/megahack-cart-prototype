function initMap() {
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer();

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: new google.maps.LatLng(44.439663, 26.096306),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    directionsDisplay.setMap(map);
    var request = {
        travelMode: google.maps.TravelMode.DRIVING,
    };

    var locations = shops;

    // deseneaza markere
    for (var i = 0; i < locations.length; i++) {

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i].latitudine, locations[i].longitudine),
        });

        if (i == 0) {
            request.origin = marker.getPosition()
        } else if (i == locations.length - 1) {
            request.destination = marker.getPosition();
        } else {
            if (!request.waypoints) {
                request.waypoints = []
            }
            request.waypoints.push({
                location: marker.getPosition(),
                stopover: true
            });
        }
    }
    directionsService.route(request, function (result, status) {
        console.log(result);
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(result);
        }
    });

}
