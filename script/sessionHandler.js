// session_tracker.js

// Function to check session status
function checkSession() {
    fetch('/saibsCode/action/sessionHandler.php') // Adjust the path as needed
        .then(response => response.json())
        .then(data => {
            if (data.status === "active") {
                console.log(`User ${data.username} is logged in.`);
                // User is still logged in, update UI or perform necessary actions
            } else if (data.status === "expired") {
                console.log("Session has expired. Logging out...");
                alert("Session expired. You will be logged out.");
                logoutUser(); // Call logout function
            } else if (data.status === "not_logged_in") {
                console.log("No user logged in.");
                alert("Please log in to continue.");
                window.location.href = "/saibsCode/login.html"; // Redirect to login
            }
        })
        .catch(error => console.error('Error:', error));
}

// Function to logout the user
function logoutUser() {
    fetch('/saibsCode/action/logout.php') // Adjust the path as needed
        .then(response => response.json())
        .then(data => {
            if (data.status === "logged_out") {
                console.log("User logged out.");
                window.location.href = "/saibsCode/login.html"; // Redirect to login page
            }
        })
        .catch(error => console.error('Error:', error));
}

// Set interval to check the session status periodically (every 5 minutes)
setInterval(checkSession, 5 * 60 * 1000); // 5 minutes interval

// You can also check the session status on page load
window.onload = checkSession;
