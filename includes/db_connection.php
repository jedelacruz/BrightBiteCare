<?php
// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; // If you have a password for your root user, put it here
$db_name = 'brightbitecare';

// Create database connection using mysqli
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    // For a real application, you would log this error and show a user-friendly message.
    // For now, we'll just die and show the error for debugging.
    error_log("Database Connection Error: " . mysqli_connect_error());
    die("Could not connect to the database. Please check your configuration and ensure the database server is running. Error: " . mysqli_connect_error());
}

// Set charset to utf8 (optional, but good practice)
if (!mysqli_set_charset($conn, "utf8")) {
    error_log("Error loading character set utf8: " . mysqli_error($conn));
    // Depending on your requirements, you might want to die here or just log the error
}

?> 