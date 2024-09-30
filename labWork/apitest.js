function toggleMenu() {
    var menu = document.getElementById("menu");
    menu.classList.toggle("show");
}
// use of weather API

document.addEventListener("DOMContentLoaded", function() {
    const weatherLink = document.getElementById("weather-link");

    // Function to get weather data using Open-Meteo API
    function getWeather(latitude, longitude) {
        const apiUrl = `https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current_weather=true`;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                const weather = data.current_weather;
                const temperature = weather.temperature;
                const weatherDesc = weather.weathercode;
                weatherLink.textContent = `Temp: ${temperature}°C, Code: ${weatherDesc}`;
            })
            .catch(error => {
                console.error('Error fetching weather data:', error);
                weatherLink.textContent = "Weather info not available";
            });
    }
    // Get user's location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                getWeather(latitude, longitude);
            },
            error => {
                console.error('Error getting location:', error);
                weatherLink.textContent = "Weather info not available";
            }
        );
    } else {
        weatherLink.textContent = "Geolocation not supported";
    }
});


document.addEventListener("DOMContentLoaded", function() {
    const regionLink = document.getElementById("region-link");
    const mapContainer = document.getElementById("map-container");
    let map;

    regionLink.addEventListener("click", function(event) {
        event.preventDefault();  // Prevent the default link behavior

        // Toggle the map visibility
        mapContainer.style.display = (mapContainer.style.display === "none" || mapContainer.style.display === "") ? "block" : "none";

        // Initialize map if it's not already initialized
        if (!map) {
            initMap();  // Call the map initialization function
        }
    });

    async function initMap() {
        const { Map } = await google.maps.importLibrary("maps");

        map = new Map(document.getElementById("map"), {
            center: { lat: -34.397, lng: 150.644 },  // Set default map coordinates
            zoom: 8,
        });
    }
});
