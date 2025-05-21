<?php
session_start();
require_once "includes/db_connection.php";
require_once "includes/config.php"; // For base URL or other configs if needed

$base_url = BASE_URL; // Assuming BASE_URL is defined in config.php

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // User not logged in, redirect to login page with an error message
    $_SESSION['error_message'] = "You need to login to place an order.";
    header("Location: {$base_url}login.php");
    exit();
}

// Check if product_id is POSTed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);

    if (!$product_id) {
        $_SESSION['error_message_products'] = "Invalid product selected.";
        header("Location: {$base_url}products.php");
        exit();
    }

    // Fetch product details from the database
    $stmt_product = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
    if (!$stmt_product) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        $_SESSION['error_message_products'] = "Error preparing product query. Please try again.";
        header("Location: {$base_url}products.php");
        exit();
    }
    $stmt_product->bind_param("i", $product_id);
    $stmt_product->execute();
    $result_product = $stmt_product->get_result();

    if ($result_product->num_rows === 1) {
        $product = $result_product->fetch_assoc();
        $product_price = $product['price'];
        $quantity = 1; // For simplicity, order quantity is 1
        $total_amount = $product_price * $quantity;

        // Start transaction (optional, but good for atomicity)
        $conn->begin_transaction();

        try {
            // Insert into orders table
            $stmt_order = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'pending')");
            if (!$stmt_order) {
                throw new Exception("Error preparing order insert query: " . $conn->error);
            }
            $stmt_order->bind_param("id", $user_id, $total_amount);
            $stmt_order->execute();
            $order_id = $conn->insert_id; // Get the ID of the newly inserted order

            if (!$order_id) {
                throw new Exception("Failed to create order.");
            }
            $stmt_order->close();

            // Insert into order_items table
            $stmt_order_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            if (!$stmt_order_item) {
                throw new Exception("Error preparing order item insert query: " . $conn->error);
            }
            $stmt_order_item->bind_param("iiid", $order_id, $product_id, $quantity, $product_price);
            $stmt_order_item->execute();
            
            if ($stmt_order_item->affected_rows <= 0) {
                throw new Exception("Failed to add item to order.");
            }
            $stmt_order_item->close();

            // Commit transaction
            $conn->commit();

            $_SESSION['success_message_products'] = "Order placed successfully! Your order ID is " . $order_id;
            header("Location: {$base_url}products.php");
            exit();

        } catch (Exception $e) {
            $conn->rollback(); // Rollback transaction on error
            error_log("Order creation failed: " . $e->getMessage());
            $_SESSION['error_message_products'] = "Could not place your order. Please try again. Error: " . $e->getMessage();
            header("Location: {$base_url}products.php");
            exit();
        }

    } else {
        // Product not found
        $_SESSION['error_message_products'] = "Product not found.";
        header("Location: {$base_url}products.php");
        exit();
    }
    $stmt_product->close();
} else {
    // Invalid request (not POST or product_id not set)
    $_SESSION['error_message_products'] = "Invalid request.";
    header("Location: {$base_url}products.php");
    exit();
}

$conn->close();
?> 