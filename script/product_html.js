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
//End