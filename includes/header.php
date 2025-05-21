<?php 
// Ensure session.php is included first on all pages that use header.php
// If not already included by the calling page, include it here.
if (session_status() === PHP_SESSION_NONE && !function_exists('is_user_logged_in')) {
    //This is a fallback. Ideally, each page (index.php, about.php, etc.) should include session.php itself.
    if (file_exists(dirname(__FILE__) . '/session.php')) {
        require_once dirname(__FILE__) . '/session.php';
    }
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - Bright Bite Care' : 'Bright Bite Care'; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <style>
    .desktop-nav a.active,
    .mobile-nav a.active {
      font-weight: bold;
      color: #33C3F0; /* Or your primary color */
      text-decoration: underline;
    }

    /* Styles for aligning welcome message and logout button */
    .mobile-auth-buttons {
      display: flex; /* Use flexbox for alignment */
      align-items: center; /* Vertically center items */
      gap: 0.75rem; /* Add some space between items, adjust as needed */
    }

    .welcome-user {
      /* Optional: Add specific styling for the welcome text if needed */
      /* e.g., margin-right: 0.5rem; if gap isn't sufficient or for older browsers */
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="header">
    <div class="container">
      <div class="header-content">
        <a href="index.php" class="logo-container">
          <div class="logo-icon">
            <img src="logo.png" alt="Bright Bite Care Logo" class="logo-image">
          </div>
          <div class="logo-text">
            <h1>Bright Bite Care</h1>
            <p>Healthy Smile begins with care.</p>
          </div>
        </a>

        <!-- Desktop Navigation -->
        <nav class="desktop-nav">
          <a href="index.php" <?php if($current_page == 'index.php') echo 'class="active"'; ?>>Home</a>
          <a href="about.php" <?php if($current_page == 'about.php') echo 'class="active"'; ?>>About Us</a>
          <a href="services.php" <?php if($current_page == 'services.php') echo 'class="active"'; ?>>Services</a>
          <a href="products.php" <?php if($current_page == 'products.php') echo 'class="active"'; ?>>Products</a>
          <a href="gallery.php" <?php if($current_page == 'gallery.php') echo 'class="active"'; ?>>Gallery</a>
          <a href="contactus.php" <?php if($current_page == 'contactus.php') echo 'class="active"'; ?>>Contact</a>
        </nav>

        <div class="auth-buttons">
          <?php 
          // Ensure session is started. If not already started by the page, start it here.
          // This is a fallback. Pages themselves should ideally call session_start().
          if (session_status() === PHP_SESSION_NONE) {
              session_start();
          }
          
          if (isset($_SESSION['user_id'])): ?>
            <span class="welcome-user">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
            <a href="logout.php" class="btn btn-outline">Logout</a>
          <?php else: ?>
            <a href="login.php" class="btn btn-outline <?php if($current_page == 'login.php') echo 'active'; ?>">Login</a>
            <a href="register.php" class="btn btn-primary <?php if($current_page == 'register.php') echo 'active'; ?>">Register</a>
          <?php endif; ?>
        </div>

        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" aria-label="Toggle menu">
          <svg xmlns="http://www.w3.org/2000/svg" class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
          </svg>
          <svg xmlns="http://www.w3.org/2000/svg" class="close-icon hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
      </div>

      <!-- Mobile Navigation -->
      <nav class="mobile-nav hidden">
        <a href="index.php" <?php if($current_page == 'index.php') echo 'class="active"'; ?>>Home</a>
        <a href="about.php" <?php if($current_page == 'about.php') echo 'class="active"'; ?>>About Us</a>
        <a href="services.php" <?php if($current_page == 'services.php') echo 'class="active"'; ?>>Services</a>
        <a href="products.php" <?php if($current_page == 'products.php') echo 'class="active"'; ?>>Products</a>
        <a href="gallery.php" <?php if($current_page == 'gallery.php') echo 'class="active"'; ?>>Gallery</a>
        <a href="contactus.php" <?php if($current_page == 'contactus.php') echo 'class="active"'; ?>>Contact</a>
        <div class="mobile-auth-buttons">
          <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="btn btn-outline">Logout</a>
          <?php else: ?>
            <a href="login.php" class="btn btn-outline <?php if($current_page == 'login.php') echo 'active'; ?>">Login</a>
            <a href="register.php" class="btn btn-primary <?php if($current_page == 'register.php') echo 'active'; ?>">Register</a>
          <?php endif; ?>
        </div>
      </nav>
    </div>
  </header>
  <div class="main-container container">
    <!-- This container is for the main content of each page -->
    <!-- Flash messages can be displayed here -->
    <?php 
      /* // Temporarily commented out flash messages as they rely on session functions
      if (function_exists('get_success_message')) echo get_success_message('general');
      if (function_exists('get_error_message')) echo get_error_message('general');
      */
    ?> 