<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>

    <style>
        body {
            padding: 0;
            margin: 0;
        }

        #map {
            position: fixed;
            height: 100vh;
            width: 100vw;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    @include('navbar')
</body>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<script>
    $(document).ready(function() {
        var map = L.map('map', { zoomControl: false });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var greenIcon = L.icon({
            iconUrl: '{{ asset('assets/images/vt.png') }}',
            iconSize: [70, 70],
        });

        var marker = [];

        var poly = [];

        function updateMarker() {
            $.ajax({
                url: 'https://gpsstaging.findingoillosses.com/api/getRecordByDevice',
                // url: '{{ url('getRecordByDevice') }}',
                method: 'POST',
                dataType: 'json',
                data: {
                    date: "2025-02-20",
                    idDevice: 1
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.record.length > 0) {
                        response.record.forEach(r => {
                            poly.push([r.lat, r.long]);
                        });
                        var polyline = L.polyline(poly, {color: 'red'}).addTo(map);
                        map.fitBounds(polyline.getBounds());
                    }
                },
                error: function(error) {
                    console.log("Error fetching data: ", error);
                }
            });
        }

        updateMarker();

        // setInterval(updateMarker, 3000);
    });
</script>
</html>