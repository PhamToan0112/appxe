<script>
    $(document).ready(function () {
        let map, vehicleMarker;
        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer();

        let currentLat = parseFloat('{{ $order->current_lat ?? '0' }}');
        let currentLng = parseFloat('{{ $order->current_lng ?? '0' }}');

        function initMapOrder() {
            const start = new google.maps.LatLng($('input[name="lat"]').val(), $('input[name="lng"]').val());
            const end = new google.maps.LatLng($('input[name="end_lat"]').val(), $('input[name="end_lng"]').val());

            if (!map) {
                // Setting map center based on current location if available
                map = new google.maps.Map(document.getElementById('resultMap'), {
                    zoom: 14,
                    center: (currentLat !== 0 && currentLng !== 0) ? new google.maps.LatLng(currentLat, currentLng) : start
                });
                directionsRenderer.setMap(map);
            }

            // Only add marker if valid current location coordinates exist
            if (currentLat !== 0 && currentLng !== 0) {
                const icon = {
                    url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                    size: new google.maps.Size(40, 40),
                    scaledSize: new google.maps.Size(40, 40),
                    anchor: new google.maps.Point(20, 20)
                };

                vehicleMarker = new google.maps.Marker({
                    position: new google.maps.LatLng(currentLat, currentLng),
                    map: map,
                    icon: icon
                });
            }

            updateRoute(start, end);
        }

        function updateRoute(start, end) {
            const request = {
                origin: start,
                destination: end,
                travelMode: 'DRIVING'
            };

            directionsService.route(request, function (response, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(response);
                    const legs = response.routes[0].legs;
                    let detailsHtml = "";
                    legs.forEach((leg, index) => {
                        const detailsId = `details${index}`;
                        detailsHtml += createSegmentHtml(`Segment ${index + 1}`, leg, detailsId);
                    });
                    document.getElementById('directions-panel').innerHTML = detailsHtml;
                } else {
                    console.error("Cannot fetch directions: " + status);
                }
            });
        }

        function updateVehiclePosition() {
            if (vehicleMarker && currentLat !== 0 && currentLng !== 0) {
                vehicleMarker.setPosition(new google.maps.LatLng(currentLat, currentLng));
                map.setCenter(new google.maps.LatLng(currentLat, currentLng));
                console.log("Updated position to Latitude: ", currentLat, " Longitude: ", currentLng);
            }
        }

        setInterval(updateVehiclePosition, 5000);

        initMapOrder();

        $('input[name="lat"], input[name="lng"], input[name="end_lat"], input[name="end_lng"]').change(function () {
            const newStart = new google.maps.LatLng($('input[name="lat"]').val(), $('input[name="lng"]').val());
            const newEnd = new google.maps.LatLng($('input[name="end_lat"]').val(), $('input[name="end_lng"]').val());
            updateRoute(newStart, newEnd);
        });

        function createSegmentHtml(routeSegment, leg, detailsId) {
            var html = `<div class="d-flex align-items-center mt-3 mb-3">`;
            html += `<b class="me-3">Đoạn đường: </b>`;
            html += `<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#${detailsId}" aria-expanded="false" aria-controls="${detailsId}">
            Chi tiết
         </button></div>`;
            html += `<div class="collapse" id="${detailsId}">
            <div class="card card-body">
                <strong>Các chặng:</strong> ${leg.start_address} → ${leg.end_address}<br>
                <strong>Khoảng cách:</strong> ${leg.distance.text}<br>
                <strong>Thời gian dự kiến:</strong> ${leg.duration.text}
            </div>
         </div>`;
            return html;
        }
    });
</script>
