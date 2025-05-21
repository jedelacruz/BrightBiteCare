<?php
session_start(); // Start the session at the very beginning
require_once 'includes/config.php'; // Reverted to use config.php for mysqli connection
require_once 'includes/db_connection.php'; // Defines $conn

$base_url = BASE_URL;
$pageTitle = "Login";
$error_message = ""; // Variable to store error messages
$username_value = ""; // To repopulate username field on error

// Check if the user is already logged in, if so, redirect to index.php
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Display registration success message if available
if (isset($_SESSION['registration_success'])) {
    $success_message_from_register = $_SESSION['registration_success'];
    unset($_SESSION['registration_success']); // Clear it after retrieving
}

// Display messages from other pages (e.g., create_appointment if user wasn't logged in)
if (isset($_SESSION['error_message_login'])) {
    $error_message = $_SESSION['error_message_login'];
    unset($_SESSION['error_message_login']);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $username_value = $username; // Keep username in form if error

        if (empty($username) || empty($password)) {
            $error_message = "Username and password are required.";
        } else {
            // Prepare statement to prevent SQL injection
            // Check if $conn is valid before using it
            if ($conn) {
                $sql = "SELECT id, username, password, full_name, is_admin FROM users WHERE username = ?";
                if ($stmt = $conn->prepare($sql)) { // Use object-oriented style: $conn->prepare
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows == 1) {
                        $user = $result->fetch_assoc();
                        // Verify password (assuming plain text passwords as per initial user setup, which is NOT secure)
                        // For a production system, you MUST use hashed passwords with password_verify()
                        if ($password === $user['password']) { // Direct comparison (NOT SECURE FOR PRODUCTION)
                            // Password is correct, start session
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['user_name'] = $user['username']; // Or $user['full_name']
                            $_SESSION['full_name'] = $user['full_name'];
                            $_SESSION['is_admin'] = $user['is_admin'];

                            // Redirect based on admin status
                            if ($_SESSION['is_admin'] == 1) {
                                header("Location: admin/index.php");
                            } else {
                                header("Location: index.php");
                            }
                            exit();
                        } else {
                            $error_message = "Invalid username or password.";
                        }
                    } else {
                        $error_message = "Invalid username or password.";
                    }
                    $stmt->close();
                } else {
                    // Error preparing statement
                    $error_message = "Login failed due to a server error. Please try again later.";
                    error_log("Login prepare error: " . $conn->error);
                }
            } else {
                $error_message = "Database connection error. Please try again later.";
                error_log("Login error: $conn is not available.");
            }
        }
    } else {
        $error_message = "Username and password are required.";
    }
}

include "includes/header.php"; 
?>

<div class="login-container">
    
    <div class="auth-card">
        <div class="auth-card-header">
            <h2>Login</h2>
            <p>Please fill in your credentials to login</p>
        </div>

        <div class="auth-card-content">
            <?php if (!empty($success_message_from_register)): ?>
                <div class="auth-success-message" style="color: green; background-color: #e8f5e9; border: 1px solid #a5d6a7; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                    <?php echo htmlspecialchars($success_message_from_register); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div class="auth-error-message" style="color: red; background-color: #ffebee; border: 1px solid #ef9a9a; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" action="login.php" method="post" novalidate>
                <div class="form-row">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username_value); ?>" required>
                </div>    

                <div class="form-row">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-row">
                    <button type="submit" class="btn btn-primary btn-full">Login</button>
                </div>
            </form>

            <div class="auth-alt-action">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>