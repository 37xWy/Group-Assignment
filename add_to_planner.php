<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Attraction to Planner</title>
    <link rel="stylesheet" href="style.css">
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

<div id="banner">
    <h2 align="center">Add to Your Planner</h2>
</div>

<div id="attractionDetails">
    <h4 id="selectedPlace"></h4>
    <form id="plannerForm">

        <div class="form-group">
            <label for="selectedDate">Selected Date:</label>
            <input type="date" id="selectedDate" required>
        </div>

        <div class="form-group">
            <label for="startTime">Start Time:</label>
            <input type="time" id="startTime" required step="900"> <!-- 15 minutes -->
        </div>

        <div class="form-group">
            <label for="endTime">End Time:</label>
            <input type="time" id="endTime" required step="900"> <!-- 15 minutes -->
        </div>

        <button type="submit" class="planner-button">Add to Planner</button>
    </form>
</div>

<script>
    window.onload = function() {
        // Retrieve values from localStorage
        const place = localStorage.getItem('selectedPlace');
        const startDate = localStorage.getItem('startDate');
        const endDate = localStorage.getItem('endDate');
        const selectedDay = localStorage.getItem('selectedDay'); // Check for selectedDay

        // Ensure both startDate and endDate are available
        if (!startDate || !endDate) {
            alert("Please select a date range in the planner before adding an attraction.");
            window.location.href = "planner.php"; // Redirect if no date range set
            return;
        }

        // Display the selected place
        if (place) {
            document.getElementById('selectedPlace').innerText = place; // Display selected place
        } else {
            alert("Please search and select a place before adding to the planner.");
            window.location.href = "search.php"; // Redirect if no place selected
            return;
        }

        // Set the input for the selected date
        const dateInput = document.getElementById('selectedDate');

        // Check if selectedDay exists and set it properly
        if (selectedDay) {
            dateInput.value = selectedDay; // Set the date input to the selected day in YYYY-MM-DD format
            dateInput.disabled = true; // Make it uneditable
        } else {
            // If no specific date is selected, enable date range
            dateInput.min = startDate; // Set the min to start date
            dateInput.max = endDate;   // Set the max to end date
        }

        // Function to validate overlapping times
        function validateTimes(finalSelectedDay, startTime, endTime) {
            const savedAttractions = JSON.parse(localStorage.getItem('plannerAttractions') || '{}');
            const attractionsForDate = savedAttractions[finalSelectedDay] || [];

            for (const attraction of attractionsForDate) {
                const existingStartTime = attraction.startTime;
                const existingEndTime = attraction.endTime;

                // Check for overlap
                if (
                    (startTime >= existingStartTime && startTime < existingEndTime) ||
                    (endTime > existingStartTime && endTime <= existingEndTime) ||
                    (startTime <= existingStartTime && endTime >= existingEndTime)
                ) {
                    return false; // Overlap detected
                }
            }
            return true; // No overlap
        }

        // Handle form submission
        document.getElementById('plannerForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            const finalSelectedDay = dateInput.value; // Use the selected date from the input
            const startTime = document.getElementById('startTime').value;
            const endTime = document.getElementById('endTime').value;

            // Validate the time inputs
            if (startTime >= endTime) {
                alert("End time must be after start time.");
                return;
            }

            // Validate for overlapping times
            if (!validateTimes(finalSelectedDay, startTime, endTime)) {
                alert("Selected time overlaps with an existing attraction.");
                return;
            }

            // Save to localStorage (since we want data to persist across sessions)
            localStorage.setItem('chosenAttraction', place);
            localStorage.setItem('userSelectedDate', finalSelectedDay);
            localStorage.setItem('activityStartTime', startTime);
            localStorage.setItem('activityEndTime', endTime);

            // Redirect back to the planner page with the details
            window.location.href = 'planner.php';
        });
    };
</script>

<hr>

</body>
</html>
