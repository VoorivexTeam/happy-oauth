<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();
}

// Redirect the user to the login page or home page after logout
header("Location: /"); // Adjust this path if your login page is different
exit;