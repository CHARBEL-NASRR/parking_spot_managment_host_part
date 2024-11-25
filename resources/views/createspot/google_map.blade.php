<!DOCTYPE html>
<html>
<head>
    <title>Select Parking Location</title>
    <script src="https://maps.gomaps.pro/maps/api/js?key=AlzaSysibLFpk-iBAIv68He16T2qccVi4Ao-WSv"></script>
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header styling */
        header {
            color: #000000;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header img {
            height: 60px;
        }

        header h1 {
            margin: 0;
            font-size: 30px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }

        /* Map container */
        #map {
            flex: 1;
            height: 500px;
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Footer styling */
        footer {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        footer p {
            color: #000000;
            margin: 0;
            font-size: 14px;
        }

        footer button {
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #000000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        footer button:hover {
            background-color: #00b396;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <img src="logo_parkingspot.png" alt="Logo">
        <h1>Is the Pin in the Right Spot?</h1>
    </header>

    <!-- Map Section -->
    <div id="map"></div>

    <!-- Footer -->
    <footer>
        <form method="POST" action="{{ route('save-location', ['spot_id' => $spot_id]) }}">
            @csrf
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <input type="hidden" id="city" name="city">
            <input type="hidden" id="district" name="district">
            <input type="hidden" name="spot_id" value="{{ $spot->spot_id }}">
            <button type="submit">Save Location</button>
        </form>
    </footer>

    <script>
        function initMap() {
            // Initialize a map with a default location
            const defaultLocation = { lat: 33.8938, lng: 35.5018 }; // Default to Beirut, Lebanon
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: defaultLocation,
            });

            // Create a draggable marker at the default location
            let marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true,
            });

            // Attempt to get the host's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const currentLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };

                        // Update the map center and marker position
                        map.setCenter(currentLocation);
                        marker.setPosition(currentLocation);

                        // Update hidden inputs with current location
                        document.getElementById('latitude').value = currentLocation.lat;
                        document.getElementById('longitude').value = currentLocation.lng;
                    },
                    (error) => {
                        console.error("Error obtaining location:", error);
                        alert("Could not get your location. Please place the marker manually.");
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser. Please place the marker manually.");
            }

            // Update the hidden input fields when the marker is dragged
            google.maps.event.addListener(marker, 'dragend', (event) => {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
                reverseGeocode(event.latLng.lat(), event.latLng.lng());
            });
        }

        function reverseGeocode(lat, lng) {
            const apiKey = "AlzaSysibLFpk-iBAIv68He16T2qccVi4Ao-WSv";
            const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${apiKey}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "OK") {
                        const results = data.results;
                        if (results.length > 0) {
                            const addressComponents = results[0].address_components;

                            let city = "";
                            let district = "";

                            addressComponents.forEach(component => {
                                if (component.types.includes("locality")) {
                                    city = component.long_name;
                                }
                                if (component.types.includes("sublocality") || component.types.includes("administrative_area_level_2")) {
                                    district = component.long_name;
                                }
                            });

                            console.log(`City: ${city}`);
                            console.log(`District: ${district}`);

                            // Set the city and district in the hidden inputs
                            document.getElementById("city").value = city;
                            document.getElementById("district").value = district;

                            // Display results
                            document.getElementById("output").textContent = `City: ${city}, District: ${district}`;
                        }
                    } else {
                        console.error("Reverse geocoding failed:", data.status);
                        alert("Could not retrieve location details.");
                    }
                })
                .catch(error => {
                    console.error("Error fetching reverse geocoding data:", error);
                });
        }

        window.onload = initMap;
    </script>
</body>
</html>