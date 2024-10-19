let isAddingCard = false; // Flag to track if the addCard button was clicked

// Set the minimum date for the start date input to today
const today = new Date().toISOString().split('T')[0];
document.getElementById('startDate').min = today;
document.getElementById('endDate').min = today;

// Object to store place-specific images and descriptions
const attractionData = {
    "Tokyo": {
        imageUrl: "images/tokyo.jpg",
        description: "Tokyo offers a wide array of attractions including Shibuya Crossing, the Imperial Palace, and the famous Tokyo Skytree."
    },
    "Kyoto": {
        imageUrl: "images/kyoto.jpg",
        description: "Key attractions include Fushimi Inari Shrine, Kinkaku-ji (Golden Pavilion), and Gion, the geisha district."
    },
    "Osaka": {
        imageUrl: "images/osaka.jpg",
        description: "Main highlights include Osaka Castle, the bustling Dotonbori district, and Universal Studios Japan."
    },
    // Add more places as needed
};

// Load previously saved dates and attractions
window.onload = function() {
    const savedStartDate = localStorage.getItem('startDate');
    const savedEndDate = localStorage.getItem('endDate');

    if (savedStartDate) {
        document.getElementById('startDate').value = savedStartDate;
    }
    if (savedEndDate) {
        document.getElementById('endDate').value = savedEndDate;
    }

    // Generate planner days if both dates are available
    if (savedStartDate && savedEndDate) {
        generateDays(savedStartDate, savedEndDate);
    }

    // Load saved attractions from localStorage
    loadSavedAttractions();
    
    // After generating days, check for any attraction added from add_to_planner.php
    const chosenAttraction = localStorage.getItem('chosenAttraction');
    const userSelectedDate = localStorage.getItem('userSelectedDate');
    const activityStartTime = localStorage.getItem('activityStartTime');
    const activityEndTime = localStorage.getItem('activityEndTime');

    if (chosenAttraction && userSelectedDate && activityStartTime && activityEndTime) {
        // Find the day box for the selected date
        const dayBox = document.querySelector(`.planner-day[data-day="${userSelectedDate}"]`);

        if (dayBox) {
            addAttractionCard(dayBox, chosenAttraction, activityStartTime, activityEndTime);

            // Clear the local storage after adding to the planner
            localStorage.removeItem('chosenAttraction');
            localStorage.removeItem('userSelectedDate');
            localStorage.removeItem('activityStartTime');
            localStorage.removeItem('activityEndTime');
        }
    }
};

function loadSavedAttractions() {
    const savedAttractions = JSON.parse(localStorage.getItem('plannerAttractions') || '{}');

    // Loop through all saved dates and their attractions
    Object.keys(savedAttractions).forEach(date => {
        const dayBox = document.querySelector(`.planner-day[data-day="${date}"]`);

        // If the day box exists, add all saved attractions for that date
        if (dayBox) {
            const uniqueAttractions = [];  // Track unique attractions

            savedAttractions[date].forEach(attraction => {
                // Check for duplicates in UI before adding
                const existsInUI = uniqueAttractions.some(addedAttraction =>
                    addedAttraction.place === attraction.place &&
                    addedAttraction.startTime === attraction.startTime &&
                    addedAttraction.endTime === attraction.endTime
                );

                if (!existsInUI) {
                    uniqueAttractions.push(attraction);  // Track this attraction
                    addAttractionCard(dayBox, attraction.place, attraction.startTime, attraction.endTime);
                }
            });
        }
    });
}

// Event listener for start date change
document.getElementById('startDate').addEventListener('change', function() {
    const startDateValue = this.value;

    // Allow the end date to be the same day as the start date
    document.getElementById('endDate').min = startDateValue; // Set min to the same day

    localStorage.setItem('startDate', startDateValue);  // Save to localStorage

    const endDateValue = document.getElementById('endDate').value;

    // Clear the end date if it's earlier than the start date
    if (endDateValue && new Date(startDateValue) > new Date(endDateValue)) {
        document.getElementById('endDate').value = '';  // Clear invalid end date
    }

    generateDays(startDateValue, endDateValue);  // Generate days based on the dates
});

// Event listener for end date change
document.getElementById('endDate').addEventListener('change', function() {
    const endDateValue = this.value;
    const startDateValue = document.getElementById('startDate').value;

    // Validate that the end date is not before the start date
    if (new Date(endDateValue) < new Date(startDateValue)) {
        alert("End date must be the same or after the start date.");
        this.value = '';  // Reset invalid end date
    } else {
        localStorage.setItem('endDate', endDateValue);  // Save to localStorage
        generateDays(startDateValue, endDateValue);  // Generate days
    }
});

// Function to generate days between start and end date
function generateDays(startDate, endDate) {
    const daysSlider = document.getElementById('daysSlider');
    daysSlider.innerHTML = '';  // Clear existing content

    if (startDate && endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        const daysCount = (end - start) / (1000 * 3600 * 24);  // Calculate day difference

        // Loop through each day and create a day box
        for (let i = 0; i <= daysCount; i++) {
            const currentDay = new Date(start);
            currentDay.setDate(currentDay.getDate() + i);

            // Format day title (e.g., "2024-10-16 (Wednesday)")
            const dayTitle = `${currentDay.toISOString().split('T')[0]} (${currentDay.toLocaleString('en-US', { weekday: 'long' })})`;

            // Create day box
            const dayBox = document.createElement('div');
            dayBox.classList.add('planner-day');
            dayBox.dataset.day = currentDay.toISOString().split('T')[0];
            dayBox.innerHTML = `<h3>${dayTitle}</h3>
                <div class="attraction-container"></div>
                <button class="add-card-btn" onclick="addCard('${currentDay.toISOString().split('T')[0]}')">+ New Attraction</button>`;

            daysSlider.appendChild(dayBox);  // Add the day box to the slider
        }

        // After generating all days, load attractions for the new date range
        loadSavedAttractions();
    }
}

// Redirect to search.php to search for a new attraction and store the selected date
function addCard(day) {
    isAddingCard = true; // Set the flag to true
    // Save the selected day in localStorage, ensuring it's in YYYY-MM-DD format
    localStorage.setItem('selectedDay', day);

    // Redirect to search.php
    window.location.href = 'search.php';
}

// Function to add an attraction card to the specified day
function addAttractionCard(dayBox, place, startTime, endTime) {
    const date = dayBox.dataset.day;

    // Add the new attraction to localStorage
    saveAttractionToLocalStorage(date, place, startTime, endTime);

    // Create the new attraction card
    const newCard = document.createElement('div');
    newCard.classList.add('attraction-card');
    newCard.innerHTML = `
        <p><strong>Place:</strong> ${place}</p>
        <p><strong>Start Time:</strong> ${startTime}</p>
        <p><strong>End Time:</strong> ${endTime}</p>
    `;

    // Add the click event to update the attraction details
    newCard.addEventListener('click', function() {
        updateAttractionDetails(place, startTime, endTime);
    });

    // Add the new card to the attractions container
    const attractionContainer = dayBox.querySelector('.attraction-container');
    attractionContainer.appendChild(newCard);

    // Sort and render attractions
    renderSortedAttractions(dayBox);
}

// Function to render sorted attractions
function renderSortedAttractions(dayBox) {
    const date = dayBox.dataset.day;
    const attractions = JSON.parse(localStorage.getItem('plannerAttractions') || '{}')[date] || [];

    // Sort attractions by start time
    attractions.sort((a, b) => {
        return new Date(`1970-01-01T${a.startTime}:00`) - new Date(`1970-01-01T${b.startTime}:00`);
    });

    // Clear the existing cards in the day box
    const attractionContainer = dayBox.querySelector('.attraction-container');
    attractionContainer.innerHTML = ''; // Clear existing attractions

    // Re-render the sorted attractions
    attractions.forEach(attraction => {
        const newCard = document.createElement('div');
        newCard.classList.add('attraction-card');
        newCard.innerHTML = `
            <p><strong>Place:</strong> ${attraction.place}</p>
            <p><strong>Start Time:</strong> ${attraction.startTime}</p>
            <p><strong>End Time:</strong> ${attraction.endTime}</p>
        `;

        // Attach the click event to update the attraction details
        newCard.addEventListener('click', function() {
            updateAttractionDetails(attraction.place, attraction.startTime, attraction.endTime);
        });

        attractionContainer.appendChild(newCard); // Add the sorted card
    });
}

// Function to save an attraction to localStorage
function saveAttractionToLocalStorage(date, place, startTime, endTime) {
    let plannerAttractions = JSON.parse(localStorage.getItem('plannerAttractions') || '{}');

    // If there's no entry for the date, create an empty array for that date
    if (!plannerAttractions[date]) {
        plannerAttractions[date] = [];
    }

    // Check for duplicates before adding
    const exists = plannerAttractions[date].some(attraction => 
        attraction.place === place && attraction.startTime === startTime && attraction.endTime === endTime
    );

    if (!exists) {
        // Add the new attraction to the array for the date
        plannerAttractions[date].push({ place, startTime, endTime });

        // Save the updated plannerAttractions object back to localStorage
        localStorage.setItem('plannerAttractions', JSON.stringify(plannerAttractions));
    } else {
        console.log(`Attraction already exists for ${date}: ${place}, ${startTime} - ${endTime}`);
    }
}

function updateAttractionDetails(place, startTime, endTime) {
    document.getElementById('attractionPlace').innerText = place;
    document.getElementById('attractionStartTime').innerText = startTime;
    document.getElementById('attractionEndTime').innerText = endTime;

    // Get the image and description based on the place
    const attractionInfo = attractionData[place];

    // Check if we have data for this place, otherwise show default
    if (attractionInfo) {
        document.getElementById('attractionImage').src = attractionInfo.imageUrl;
        document.getElementById('attractionDescription').innerText = attractionInfo.description;
    } else {
        document.getElementById('attractionImage').src = 'images/missing.jpg';
        document.getElementById('attractionDescription').innerText = 'Description not available for this place.';
    }
}

window.addEventListener('beforeunload', function() {
    if (!isAddingCard) {
        localStorage.removeItem('selectedDay'); // Remove selectedDay if addCard wasn't clicked
    }
});
