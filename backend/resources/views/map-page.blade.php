<!DOCTYPE html>


<head>
    <title>Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">

    <link rel="stylesheet" href="./css/style.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

{{--<!-- Styles -->--}}
{{--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
{{--<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>--}}
{{--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>--}}
{{--<!------ Include the above in your HEAD tag ---------->--}}

{{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>--}}
{{--<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>--}}





<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <style>

    </style>
</head>

<body>
<div id="right-panel">
    <div>
        <strong>Distances</strong>
    </div>
    <div id="output"></div>
</div>


{{--<input id="origin-input" class="controls" type="text" placeholder="Enter origin location">--}}
{{--<input id="destination-input" class="controls" type="text" placeholder="Enter destination location">--}}

{{--<div id="mode-selector" class="controls">--}}
{{--<input type="radio" name="type" id="changemode-walking" checked="checked">--}}
{{--<label for="changemode-walking">Walking</label>--}}

{{--<input type="radio" name="type" id="changemode-transit">--}}
{{--<label for="changemode-transit">Transit</label>--}}

{{--<input type="radio" name="type" id="changemode-driving">--}}
{{--<label for="changemode-driving">Driving</label>--}}
{{--</div>--}}

<div id="map">
</div>
</body>

<footer>
    <script>
        var shops = {!! isset($shops['data']) ? json_encode($shops['data']) : json_encode([]) !!};
        var shopsType = {!! json_encode($shops['type']) !!};
    </script>
    <script src="./js/map2.js"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBg9gmYPF8l0gIW9FGOdLpqH4LvUByYbTQ&libraries=geometry&callback=initMap"
        async defer></script>
</footer>

</html>
