<?php
session_start(); // MUST BE THE VERY FIRST THING, NO WHITESPACE BEFORE.
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/db_connection.php';

$base_url = BASE_URL;
$admin_base_url = $base_url . 'admin/';

// Admin Authentication Check
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    $_SESSION['error_message_login'] = "You do not have permission to access the admin area. Please log in as an admin.";
    header("Location: " . $base_url . "login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - Admin' : 'Admin Dashboard'; ?> - Bright Bite Care</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>styles.css">
    <style>
        /* Admin Page General Styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f4f7f9; /* Lighter, cleaner background */
            color: #333;
            margin: 0;
            line-height: 1.6;
            padding: 2rem;
        }

        .admin-container {
            max-width: 1300px; /* Slightly wider for better content display */
            margin: 2rem auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); /* Softer shadow */
        }

        h1, h2, h3 {
            color: var(--primary-color, #2c3e50); /* Using CSS var from main styles as fallback */
            margin-top: 0;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        h1 { font-size: 2em; }
        h2 { font-size: 1.5em; }

        /* Admin Navigation */
        .admin-nav {
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e0e6ed;
        }

        .admin-nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 1rem; /* Adjusted gap */
            flex-wrap: wrap;
        }

        .admin-nav ul li a {
            text-decoration: none;
            color: var(--primary-color, #3498db);
            font-weight: 500;
            padding: 0.6rem 1rem; /* More padding */
            border-radius: 5px; /* Rounded corners for links */
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
        }

        .admin-nav ul li a:hover,
        .admin-nav ul li a.active {
            background-color: var(--primary-color, #3498db);
            color: #fff;
            border-bottom: none; /* Remove underline, background is enough */
        }

        /* Admin Table Styles */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-radius: 6px;
            overflow: hidden; /* For rounded corners on table */
        }

        .admin-table th, .admin-table td {
            border: 1px solid #e0e6ed; /* Lighter border */
            padding: 0.9rem 1rem; /* Increased padding */
            text-align: left;
            font-size: 0.95rem; /* Slightly larger font */
            vertical-align: middle;
        }

        .admin-table th {
            background-color: #e9ecef; /* Maintained header color */
            color: #495057;
            font-weight: 600; /* Bolder headers */
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .admin-table tr:nth-child(even) {
            background-color: #f8f9fa; /* Subtle striping */
        }
        .admin-table tr:hover {
            background-color: #f1f3f5;
        }

        .admin-table img {
            max-width: 60px; /* Slightly smaller for compactness */
            height: auto;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        /* Action Links in Tables */
        .admin-actions a {
            margin-right: 0.5rem;
            text-decoration: none;
            color: var(--primary-color, #007bff);
            padding: 0.25rem 0.5rem;
            border-radius: 3px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .admin-actions a:hover {
            color: #fff;
            background-color: var(--primary-color, #007bff);
            text-decoration: none;
        }
        .admin-actions a.edit { color: var(--secondary-color, #ffc107);}
        .admin-actions a.edit:hover { background-color: var(--secondary-color, #ffc107); color: #333;}
        .admin-actions a.delete { color: var(--danger-color, #dc3545);}
        .admin-actions a.delete:hover { background-color: var(--danger-color, #dc3545); color: #fff;}


        /* Logout Button & Header Area */
        .admin-header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e0e6ed;
        }

        .admin-header-top h1 {
            margin-bottom: 0; /* Remove margin from h1 inside this container */
        }

        .admin-logout.btn {
            padding: 0.5rem 1rem;
            font-size: 0.9em;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }
        /* Assuming .btn-outline from styles.css provides base styling */
        /* You might need to define --primary-color and --primary-hover in styles.css or here */
        /* For example: */
        :root {
            --primary-color: #007bff; /* Example: Bootstrap Primary Blue */
            --primary-hover: #0056b3;
            --danger-color: #dc3545; /* Example: Bootstrap Danger Red */
            --secondary-color: #6c757d; /* Example: Bootstrap Secondary Grey */
        }

        /* General utility */
        .text-center { text-align: center; }
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mb-1 { margin-bottom: 0.5rem; }
        .mb-2 { margin-bottom: 1rem; }

    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header-top"> <!-- Replaced inline style with class -->
            <h1>Admin Dashboard</h1>
            <a href="<?php echo $base_url; ?>logout.php" class="admin-logout btn btn-outline">Logout (<?php 
                if (isset($_SESSION['user_name'])) {
                    echo htmlspecialchars($_SESSION['user_name']);
                } else {
                    echo 'Admin';
                }
            ?>)</a>
        </div>

        <nav class="admin-nav">
            <ul>
                <li><a href="<?php echo $admin_base_url; ?>index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Dashboard Home</a></li>
                <li><a href="<?php echo $admin_base_url; ?>view_users.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'view_users.php' ? 'active' : ''; ?>">Manage Users</a></li>
                <li><a href="<?php echo $admin_base_url; ?>view_products.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'view_products.php' ? 'active' : ''; ?>">Manage Products</a></li>
                <li><a href="<?php echo $admin_base_url; ?>view_services.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'view_services.php' ? 'active' : ''; ?>">Manage Services</a></li>
                <li><a href="<?php echo $admin_base_url; ?>view_orders.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'view_orders.php' ? 'active' : ''; ?>">View Orders</a></li>
                <li><a href="<?php echo $admin_base_url; ?>view_appointments.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'view_appointments.php' ? 'active' : ''; ?>">View Appointments</a></li>
                <li><a href="<?php echo $admin_base_url; ?>view_messages.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'view_messages.php' ? 'active' : ''; ?>">View Messages</a></li>
                <li><a href="<?php echo $admin_base_url; ?>view_feedback.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'view_feedback.php' ? 'active' : ''; ?>">View Feedback</a></li>
            </ul>
        </nav>
        <main>
            <!-- Page specific content will go here -->
        </main>
    </div>
</body>
</html> 