<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unveiled Japan - Place Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div id="header">
        <h2><b><a href="index.html">Unveiled Japan</a></b></h2>
        <p align="right"><a href="login.html">Login/Register</a></p>
    </div>

    <hr>

    <div id="nav-container">
        <a href="index.html" class="button">Homepage</a>
        <a href="planner.html" class="button">Planner</a>
        <a href="search.html" class="button">Search</a>
    </div>

    <hr>

    <div id="banner">
        <h2 align="center" id="placeTitle">Place Details</h2>
    </div>

    <div id="placeDetails" style="padding: 20px;">
        <img id="placeImage" src="" alt="Place Image" style="width:100%; height:300px; object-fit:cover; border-radius: 10px; margin-bottom: 20px;">
        <p id="placeDescription" style="font-size: 1.2em; margin-bottom: 20px;"></p>
        <p id="placeDetailsText" style="font-size: 1.1em; color: #555;"></p>
        <button id="addToPlannerBtn" class="button">Add to Planner</button>
    </div>

    <script>
        // Function to load place data from localStorage
        function loadPlaceDetails() {
            // Get the selected place and day from localStorage
            const selectedPlace = localStorage.getItem('selectedPlace');
            const selectedDay = localStorage.getItem('selectedDay');

            // Data for places, can be expanded easily
            const placeData = {
                "Tokyo": {
                    "description": "Tokyo is Japan’s busy capital, known for its skyscrapers, shopping, and vibrant nightlife.",
                    "details": "Tokyo offers a wide array of attractions including Shibuya Crossing, the Imperial Palace, and the famous Tokyo Skytree.",
                    "imgSrc": "images/tokyo.jpg"
                },
                "Kyoto": {
                    "description": "Kyoto is known for its classical Buddhist temples, as well as gardens, imperial palaces, Shinto shrines, and traditional wooden houses.",
                    "details": "Key attractions include Fushimi Inari Shrine, Kinkaku-ji (Golden Pavilion), and Gion, the geisha district.",
                    "imgSrc": "images/kyoto.jpg"
                },
                "Osaka": {
                    "description": "Osaka is a large port city and commercial center on the Japanese island of Honshu.",
                    "details": "Main highlights include Osaka Castle, the bustling Dotonbori district, and Universal Studios Japan.",
                    "imgSrc": "images/osaka.jpg"
                }
            };

            // Check if selectedPlace exists in the data
            if (placeData[selectedPlace]) {
                document.getElementById('placeTitle').innerText = selectedPlace;
                document.getElementById('placeDescription').innerText = placeData[selectedPlace].description;
                document.getElementById('placeDetailsText').innerText = placeData[selectedPlace].details;
                document.getElementById('placeImage').src = placeData[selectedPlace].imgSrc;

                // Add to planner button functionality
                document.getElementById('addToPlannerBtn').onclick = function() {
                    if (selectedPlace) {
                        // Store the selected place in localStorage and redirect to add_to_planner.php
                        localStorage.setItem('selectedPlace', selectedPlace);
                        window.location.href = "add_to_planner.php"; // Redirect to add_to_planner.php
                    } else {
                        alert("Please select a place before adding this attraction.");
                    }
                };
            } else {
                // Error handling if place is not found
                document.getElementById('placeTitle').innerText = "Place Not Found";
                document.getElementById('placeDescription').innerText = "We couldn't find the place you're looking for. Please try again.";
                document.getElementById('addToPlannerBtn').style.display = "none";
            }
        }

        // Initialize on page load
        window.onload = loadPlaceDetails;
    </script>

    <hr>

</body>
</html>
