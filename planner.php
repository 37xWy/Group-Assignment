<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unveiled Japan - Planner</title>
    <link rel="stylesheet" href="style.css">
    <script src="planner.js" defer></script> <!-- Include the planner.js file -->
</head>
<body>

    <div id="header">
        <h2><b><a href="index.html">Unveiled Japan</a></b></h2>
        <p align="right"><a href="login.html">Login/Register</a></p>
    </div>

    <hr>

    <div id="nav-container">
        <a href="index.php" class="button">Homepage</a>
        <a href="planner.php" class="button">Planner</a>
        <a href="search.php" class="button">Search</a>
    </div>

    <hr>

    <div id="container">
        <h2 align="center">Planner</h2>

        <div id="plannerContainer">
            <div class="plannerSection">
                <label for="startDate">Start Date:</label>
                <input type="date" id="startDate" placeholder="dd/mm/yyyy">
            </div>
            <div class="plannerSection">
                <label for="endDate">End Date:</label>
                <input type="date" id="endDate" placeholder="dd/mm/yyyy">
            </div>
        </div>

        <div id="planner-container">
            <div class="days-slider" id="daysSlider">
                <!-- Days will be dynamically added here -->
            </div>

            <div id="attractionDetailsPanel">
                <h2>Attraction Details</h2>
                <div id="attractionImageContainer">
                    <img id="attractionImage" src="images/missing.jpg" alt="Attraction Image" />
                </div>
                <p><strong>Place:</strong> <span id="attractionPlace"></span></p>
                <p><strong>Start Time:</strong> <span id="attractionStartTime"></span></p>
                <p><strong>End Time:</strong> <span id="attractionEndTime"></span></p>
                <p><strong>Description:</strong> <span id="attractionDescription">Select an attraction to see details</span></p>
            </div>
        </div>
    </div>

    <script>
        // Any additional inline scripts related to the planner can go here
    </script>

</body>
</html>
