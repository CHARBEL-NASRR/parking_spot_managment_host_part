<!DOCTYPE html>
<html>
<head>
    <title>Select Parking Location</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAUWpOFgtmsToV5nEndIDegEbzNf78O_tg&libraries=places&callback=initMap" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

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

        h1 {
            font-size: 30px;
            margin-bottom: 10px;
            color: #333;
            text-align: center;
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
        }

        #search-bar {
            width: 90%;
            max-width: 800px;
            margin: 70px auto;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        #map {
            flex: 1;
            height: 50vh;
            width: 90%;
            max-width: 800px;
            margin: 40px auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        footer {
            padding: 10px 20px;
            display: flex;
            justify-content: flex-end;
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

        header {
            position: absolute;
            top: 40px;
            left: 40px;
        }

        header img {
            width: 120px;
            height: auto;
            margin-left: 70px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <img src="{{ asset('images/logo_parkingspot.png') }}" alt="Logo">
        </div>
    </header>

    <h1>Is the Pin in the Right Spot?</h1>

    <!-- Search Bar -->
    <input id="search-bar" type="text" placeholder="Search for a location" />

    <!-- Map Section -->
    <div id="map"></div>

    <!-- Footer -->
    <footer>
        <form action="{{ route('save-location', ['spot_id' => $spot->spot_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="spot_id" value="{{ $spot->spot_id }}">
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <input type="hidden" id="city" name="city">
            <input type="hidden" id="address" name="address">
            <input type="hidden" id="district" name="district">

            <button type="submit">Next</button>
        </form>
    </footer>

    <script>
        let map, marker;

        function initMap() {
            const defaultLocation = { lat: 33.8938, lng: 35.5018 }; // Default to Beirut, Lebanon

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: defaultLocation,
            });

            marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true,
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const currentLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };

                        map.setCenter(currentLocation);
                        marker.setPosition(currentLocation);
                        updateHiddenFields(currentLocation.lat, currentLocation.lng);
                    },
                    () => {
                        alert("Could not get your location. Please place the marker manually.");
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser. Please place the marker manually.");
            }

            google.maps.event.addListener(marker, 'dragend', (event) => {
                const lat = event.latLng.lat();
                const lng = event.latLng.lng();
                updateHiddenFields(lat, lng);
                reverseGeocode(lat, lng);
            });

            initAutocomplete();
        }

        function updateHiddenFields(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        function reverseGeocode(lat, lng) {
    const apiKey = "AIzaSyAUWpOFgtmsToV5nEndIDegEbzNf78O_tg";
    const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${apiKey}`;

    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            if (data.status === "OK") {
                const results = data.results[0].address_components;
                let address = data.results[0].formatted_address;
                let city = "";
                let district = "";

                // Check if the address is a Plus Code and decode it into a readable address
                if (address.includes("PLUS_CODE")) {
                    const plusCode = address.split(" ")[0];
                    const plusCodeUrl = `https://maps.googleapis.com/maps/api/geocode/json?address=${plusCode}&key=${apiKey}`;

                    fetch(plusCodeUrl)
                        .then((response) => response.json())
                        .then((plusCodeData) => {
                            if (plusCodeData.status === "OK") {
                                const readableAddress = plusCodeData.results[0].formatted_address;
                                document.getElementById("address").value = readableAddress;
                            }
                        })
                        .catch(() => {
                            alert("Error decoding the Plus Code.");
                        });
                } else {
                    // Normal geocoding results processing
                    results.forEach((component) => {
                        if (component.types.includes("locality")) {
                            city = component.long_name;
                        }
                        if (component.types.includes("sublocality") || component.types.includes("administrative_area_level_2")) {
                            district = component.long_name;
                        }
                    });

                    document.getElementById("city").value = city;
                    document.getElementById("district").value = district;
                    document.getElementById("address").value = address;
                }
            } else {
                console.error("Reverse geocoding failed:", data.status);
                alert("Could not retrieve location details.");
            }
        })
        .catch(() => {
            alert("Error fetching reverse geocoding data.");
        });
}


        function initAutocomplete() {
            const input = document.getElementById("search-bar");
            const autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                console.log(place);
                
                if (!place.geometry || !place.geometry.location) {
                    alert("No details available for the input location.");
                    return;
                }

                const location = place.geometry.location;
                map.setCenter(location);
                map.setZoom(14);
                marker.setPosition(location);

                updateHiddenFields(location.lat(), location.lng());
                reverseGeocode(location.lat(), location.lng());
            });
        }

        // Initialize the map once the script is loaded
        window.initMap = initMap;
    </script>
</body>
</html>
