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
<script src="{{ asset('assets/Leaflet.RotatedMarker-master/leaflet.rotatedMarker.js') }}"></script>

<script>
    $(document).ready(function() {
        var map = L.map('map', { zoomControl: false }).setView([-1.6526113935473765, 103.60736014023293], 20);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var greenIcon = L.icon({
            iconUrl: '{{ asset('assets/images/vt.png') }}',
            iconSize: [70, 70],
            iconAnchor: [35, 35],
        });

        var marker = [];

        function updateMarker() {
            $.ajax({
                url: 'https://gpsstaging.findingoillosses.com/api/getLatestRecord',
                // url: '{{ url('getLatestRecord') }}',
                method: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.records.length > 0) {
                        response.records.forEach(r => {
                            console.log(r.idDevice);

                            var id = r.idDevice;
                            var newLat = r.lat;
                            var newLng = r.long;
                            var angle = r.dir;

                            if (!marker[id]) {
                                marker[id] = L.marker([newLat, newLng], { icon: greenIcon, rotationAngle: angle }).addTo(map);
                            } else {
                                var currentLatLng = marker[id].getLatLng();
                                gsap.to(currentLatLng, {
                                    duration: 1.5,
                                    lat: newLat,
                                    lng: newLng,
                                    onUpdate: function() {
                                        marker[id].setLatLng([currentLatLng.lat, currentLatLng.lng]);
                                    }
                                });
                            }

                            // var rotatedIcon = L.icon({
                            //     iconUrl: '{{ asset('assets/images/vt.png') }}',
                            //     iconSize: [70, 70],
                            //     iconAnchor: [35, 35], // Anchor tetap di tengah
                            //     iconAngle: angle,  // Rotasi berdasarkan data angle
                            // });

                            // marker[id].setIcon(rotatedIcon);

                            marker[id].bindTooltip(r.speed + " KM/h<br>tes").openTooltip();
                        });
                    }
                },
                error: function(error) {
                    console.log("Error fetching data: ", error);
                }
            });
        }

        updateMarker();

        setInterval(updateMarker, 3000);
    });
</script>
</html>