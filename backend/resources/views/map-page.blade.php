<!DOCTYPE html>

	<head>
		<link rel="stylesheet" href="./css/style.css">
		<title>Vodafone Shops</title>
		<meta name="viewport" content="initial-scale=1.0">
    	<meta charset="utf-8">
	</head>

	<body>
		<!-- <div id="right-panel">
			<div>
				<strong>Distances</strong>
			</div>
			<div id="output"></div>
		</div>


		<input id="origin-input" class="controls" type="text" placeholder="Enter origin location">
		<input id="destination-input" class="controls" type="text" placeholder="Enter destination location">

		<div id="mode-selector" class="controls">
			<input type="radio" name="type" id="changemode-walking" checked="checked">
			<label for="changemode-walking">Walking</label>

			<input type="radio" name="type" id="changemode-transit">
			<label for="changemode-transit">Transit</label>

			<input type="radio" name="type" id="changemode-driving">
			<label for="changemode-driving">Driving</label>
		</div> -->

		<div id="map">
		</div>
	</body>

	<footer>		
		<script>
		    var shops = {!! isset($shops['data']) ? json_encode($shops['data']) : json_encode([]) !!};
		    console.log(shops);
		</script>
		<script src="./js/map2.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBg9gmYPF8l0gIW9FGOdLpqH4LvUByYbTQ&libraries=places&callback=initMap"
        async defer></script>
	</footer>

</html>
