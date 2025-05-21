<?php
session_start();
require_once "includes/db_connection.php";
require_once "includes/config.php"; 

$base_url = BASE_URL; 

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message_login'] = "You need to login to book a service."; // Use a specific message key for login page
    header("Location: {$base_url}login.php");
    exit();
}

// Check if service_id is POSTed and the button was clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['service_id']) && isset($_POST['book_service'])) {
    $user_id = $_SESSION['user_id'];
    $service_id = filter_var($_POST['service_id'], FILTER_SANITIZE_NUMBER_INT);

    if (!$service_id) {
        $_SESSION['error_message_services'] = "Invalid service selected.";
        header("Location: {$base_url}services.php");
        exit();
    }

    // For simplicity, we'll set a placeholder date and time.
    // The clinic would then contact the user to finalize the actual appointment slot.
    $appointment_date = date('Y-m-d'); // Current date
    $appointment_time = '00:00:00';    // Placeholder time
    $status = 'pending';              // Default status from your ENUM

    // Insert into appointments table
    $stmt = $conn->prepare("INSERT INTO appointments (user_id, service_id, appointment_date, appointment_time, status) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        error_log("Prepare failed for appointment insert: (" . $conn->errno . ") " . $conn->error);
        $_SESSION['error_message_services'] = "Error preparing your appointment request. Please try again.";
        header("Location: {$base_url}services.php");
        exit();
    }

    $stmt->bind_param("iisss", $user_id, $service_id, $appointment_date, $appointment_time, $status);

    if ($stmt->execute()) {
        $_SESSION['success_message_services'] = "Your appointment request has been submitted! We will contact you shortly to confirm the date and time.";
    } else {
        error_log("Execute failed for appointment insert: (" . $stmt->errno . ") " . $stmt->error);
        $_SESSION['error_message_services'] = "Could not submit your appointment request due to a server error. Please try again.";
    }
    $stmt->close();
    header("Location: {$base_url}services.php");
    exit();

} else {
    // Invalid request (not POST, service_id not set, or button not clicked)
    $_SESSION['error_message_services'] = "Invalid request to book service.";
    header("Location: {$base_url}services.php");
    exit();
}

$conn->close(); // Should not be reached if redirects happen, but good practice.
?> 