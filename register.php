<?php
session_start(); // Start the session at the very beginning
require_once 'includes/config.php'; // Defines constants
require_once 'includes/db_connection.php'; // Creates $conn

$pageTitle = "Register";

// Variables to store form input and error messages
$full_name_val = "";
$username_val = "";
$email_val = "";
$phone_val = "";
$address_val = ""; // Added for address
$error_messages = [];

// Check if the user is already logged in, if so, redirect (e.g., to index or a dashboard)
if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Or dashboard.php if you have it
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data directly
    $full_name = $_POST['full_name'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? ''; // Optional
    $address = $_POST['address'] ?? ''; // Added for address
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $terms_agreed = isset($_POST['terms']);

    // Store values to repopulate form
    $full_name_val = $full_name;
    $username_val = $username;
    $email_val = $email;
    $phone_val = $phone;
    $address_val = $address; // Added for address

    // Simplified Validation
    if (empty($full_name)) {
        $error_messages[] = "Full Name is required.";
    }
    if (empty($username)) {
        $error_messages[] = "Username is required.";
    }
    if (empty($email)) {
        $error_messages[] = "Email is required.";
    }
    // Basic email format check (optional, can be removed if too complex)
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_messages[] = "Invalid email format.";
    }
    if (empty($password)) {
        $error_messages[] = "Password is required.";
    }
    if ($password !== $confirm_password) {
        $error_messages[] = "Passwords do not match.";
    }
    if (!$terms_agreed) {
        $error_messages[] = "You must agree to the Terms and Conditions.";
    }

    // If no validation errors, proceed to check database
    if (empty($error_messages)) {
        // Check if username or email already exists in DB using mysqli
        $stmt_check = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ? OR email = ?");
        mysqli_stmt_bind_param($stmt_check, "ss", $username, $email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $error_messages[] = "Username or Email already exists. Please choose different credentials.";
        }
        mysqli_stmt_close($stmt_check);

        // If still no errors (i.e., username/email is unique), proceed to insert
        if (empty($error_messages)) {
            $plain_password_to_store = $password; 

            $sql_insert = "INSERT INTO users (full_name, username, email, phone, address, password) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($conn, $sql_insert);
            
            if ($stmt_insert) {
                mysqli_stmt_bind_param($stmt_insert, "ssssss", $full_name, $username, $email, $phone, $address, $plain_password_to_store);
                if (mysqli_stmt_execute($stmt_insert)) {
                    $_SESSION['registration_success'] = 'Registration successful! Please log in with your new account.';
                    mysqli_stmt_close($stmt_insert);
                    mysqli_close($conn);
                    header("Location: login.php");
                    exit;
                } else {
                    // Log detailed error: error_log("MySQLi execute error: " . mysqli_stmt_error($stmt_insert));
                    $error_messages[] = "Registration failed due to a server error. Please try again later."; 
                }
                mysqli_stmt_close($stmt_insert);
            } else {
                 // Log detailed error: error_log("MySQLi prepare error: " . mysqli_error($conn));
                $error_messages[] = "Registration failed due to a server configuration error. Please try again later.";
            }
        }
    }
    if (isset($conn) && $conn) { // Ensure connection is closed if not closed by successful redirect path
        mysqli_close($conn);
    }
}

include "includes/header.php"; 
?>

<div class="login-container"> <!-- Using login-container for similar styling -->
   

    <div class="auth-card">
        <div class="auth-card-header">
            <h2>Create Account</h2>
            <p>Please fill this form to create an account.</p>
        </div>

        <div class="auth-card-content">
            <?php if (!empty($error_messages)): ?>
                <div class="auth-error-message" style="color: red; background-color: #ffebee; border: 1px solid #ef9a9a; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                    <strong>Please correct the following errors:</strong><br>
                    <?php foreach ($error_messages as $error): ?>
                        - <?php echo htmlspecialchars($error); ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" action="register.php" method="post" id="registerForm" novalidate>
                <div class="form-row">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name_val); ?>" required>
                </div>

                <div class="form-row">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username_val); ?>" required pattern="^[a-zA-Z0-9_]+$" title="Username can only contain letters, numbers, and underscores.">
                </div>

                <div class="form-row">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email_val); ?>" required>
                </div>

                <div class="form-row">
                    <label for="phone">Phone Number (Optional)</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone_val); ?>">
                </div>

                <div class="form-row">
                    <label for="address">Address (Optional)</label>
                    <textarea id="address" name="address" rows="3" placeholder="Your Street Address, City, Province, Postal Code"><?php echo htmlspecialchars($address_val); ?></textarea>
                </div>

                <div class="form-row">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required minlength="8" title="Password must be at least 8 characters long.">
                </div>

                <div class="form-row">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="terms" name="terms" required <?php if(isset($_POST['terms'])) echo 'checked'; ?>>
                    <label for="terms">I agree to the <a href="#" target="_blank">Terms and Conditions</a></label>
                </div>

                <div class="form-row">
                    <button type="submit" class="btn btn-primary btn-full" id="registerButton">Register</button>
                </div>
            </form>

            <div class="auth-alt-action">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
