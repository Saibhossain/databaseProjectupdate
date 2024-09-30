<?php
// session_handler.php

// Start session
session_start();

// Define session expiration time (e.g., 30 minutes)
$session_duration = 30 * 60; // 30 minutes in seconds

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // Check if the session has expired
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $session_duration) {
        // Session has expired
        session_unset();     // Unset session variables
        session_destroy();   // Destroy the session
        echo json_encode(["status" => "expired"]);
        exit;
    } else {
        // Session is still valid
        $_SESSION['last_activity'] = time(); // Update last activity time
        echo json_encode([
            "status" => "active",
            "user_id" => $_SESSION['user_id'],
            "username" => $_SESSION['username']
        ]);
        exit;
    }
} else {
    // No user is logged in
    echo json_encode(["status" => "not_logged_in"]);
    exit;
}
