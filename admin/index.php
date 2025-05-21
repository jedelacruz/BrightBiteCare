<?php 
$pageTitle = "Dashboard";
include 'admin_header.php'; 
?>

<h2>Welcome, <?php 
    if (isset($_SESSION['full_name'])) {
        echo htmlspecialchars($_SESSION['full_name']);
    } elseif (isset($_SESSION['user_name'])) {
        echo htmlspecialchars($_SESSION['user_name']); // Fallback to username if full_name isn't set
    } else {
        echo 'Admin'; // Generic fallback
    }
?>!</h2>
<p>This is your admin dashboard. From here, you can manage users, products, services, and view orders and appointments.</p>
<p>Please use the navigation menu above to access different sections.</p>

<?php 
// In the future, you could add some summary statistics here, like:
// - Number of registered users
// - Number of products/services
// - Recent orders/appointments count
?>

<?php include 'admin_footer.php'; ?> 