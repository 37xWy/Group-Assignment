<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unveiled Japan - Search</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div id="header">
        <h2><b><a href="index.html">Unveiled Japan</a></b></h2>
        <p><a href="login.html">Login/Register</a></p>
    </div>

    <hr>

    <div id="nav-container">
        <a href="index.php" class="button">Homepage</a>
        <a href="planner.php" class="button">Planner</a>
        <a href="search.php" class="button">Search</a>
    </div>
    
    <hr>

    <div id="search-section">
        <input type="text" id="searchbar" placeholder="Search for attractions..." />
        <div class="filters">
            <select id="genre">
                <option value="any">Genre: Any</option>
                <option value="culture">Culture</option>
                <option value="nature">Nature</option>
                <option value="adventure">Adventure</option>
                <!-- Add more genre options as needed -->
            </select>
            <select id="year">
                <option value="any">Year: Any</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
                <!-- Add more year options as needed -->
            </select>
            <select id="sort-by">
                <option value="popular">Sort By: Most Popular</option>
                <option value="rating">Sort By: Highest Rating</option>
                <option value="alphabetical">Sort By: Alphabetical</option>
                <!-- Add more sorting options as needed -->
            </select>
            <select id="country">
                <option value="any">Country: Any</option>
                <option value="japan">Japan</option>
                <option value="usa">USA</option>
                <option value="france">France</option>
                <!-- Add more country options as needed -->
            </select>
        </div>
    </div>

    <div id="results">
        <!-- Example of search result item -->
        <div class="result-item" onclick="redirectToPlace('Tokyo')">
            <h4>Tokyo</h4>
            <p>Tokyo is Japan’s busy capital, known for its skyscrapers, shopping, and vibrant nightlife.</p>
        </div>
        <div class="result-item" onclick="redirectToPlace('Kyoto')">
            <h4>Kyoto</h4>
            <p>Kyoto is known for its classical Buddhist temples, as well as gardens, imperial palaces, Shinto shrines, and traditional wooden houses.</p>
        </div>
        <div class="result-item" onclick="redirectToPlace('Osaka')">
            <h4>Osaka</h4>
            <p>Osaka is a large port city and commercial center on the Japanese island of Honshu.</p>
        </div>
    </div>

    <h3>Trending Attractions</h3>
    <div id="trending">
        <!-- Example of trending item -->
        <div class="trending-item" onclick="redirectToPlace('Nara')">
            <h4>Nara</h4>
            <p>Nara is famous for its tame deer and historic temples.</p>
        </div>
        <div class="trending-item" onclick="redirectToPlace('Hiroshima')">
            <h4>Hiroshima</h4>
            <p>Hiroshima is known for its historical significance and beautiful gardens.</p>
        </div>
    </div>

    <script>
        function redirectToPlace(place) {
            // Store the selected place in sessionStorage
            localStorage.setItem('selectedPlace', place);
            window.location.href = 'place.php';
        }
    </script>

    <hr>

</body>
</html>
