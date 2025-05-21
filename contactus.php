<?php
session_start(); // Start session to manage messages
require_once 'includes/db_connection.php'; // Include your database connection file
require_once 'includes/config.php';      // For BASE_URL

$base_url = BASE_URL;

$message_sent = false;
$error_message = '';
$feedback_success_message = '';
$feedback_error_message = '';

// Handle Contact Message Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_message'])) {
    // Retrieve form data directly (less secure, as per request for simplicity)
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone']; // Optional field
    $message_text = $_POST['message'];

    // Basic check for required fields (minimal validation)
    if (empty($name) || empty($email) || empty($message_text)) {
        $error_message = "Please fill in Name, Email, and Message for contact form.";
    } else {
        try {
            // Prepare SQL statement to insert message
            $stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            
            // Use phone as subject, or a default if phone is empty
            $subject = !empty($phone) ? "Message from: " . $phone : "Contact Form Message";
            
            $stmt->bind_param("ssss", $name, $email, $subject, $message_text);
            if ($stmt->execute()) {
                $message_sent = true;
            } else {
                $error_message = "Sorry, there was an error sending your message. Please try again later.";
                error_log("Message send execute error: " . $stmt->error);
            }
            $stmt->close();
        } catch (PDOException $e) {
            // Log error for debugging: error_log("Database error: " . $e->getMessage());
            $error_message = "Database connection or query error. Ensure db_connection.php is correct.";
        }
    }
}

// Handle Feedback Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_feedback'])) {
    if (!isset($_SESSION['user_id'])) {
        $feedback_error_message = "You must be logged in to submit feedback. <a href='login.php'>Login here</a>.";
    } else {
        $user_id = $_SESSION['user_id'];
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

        if ($rating < 1 || $rating > 5) {
            $feedback_error_message = "Invalid rating. Please select between 1 and 5 stars.";
        } else {
            $stmt = $conn->prepare("INSERT INTO feedback (user_id, rating, comment) VALUES (?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("iis", $user_id, $rating, $comment);
                if ($stmt->execute()) {
                    $feedback_success_message = "Thank you for your feedback!";
                } else {
                    $feedback_error_message = "Sorry, there was an error submitting your feedback. Please try again later.";
                    error_log("Feedback submit execute error: " . $stmt->error);
                }
                $stmt->close();
            } else {
                $feedback_error_message = "Database error preparing feedback. Please try again later.";
                error_log("Feedback submit prepare error: " . $conn->error);
            }
        }
    }
}

$pageTitle = "Contact Us";
include "includes/header.php"; // header.php will likely error

?>

<style>
  .contact-hero {
  background: linear-gradient(to bottom right, rgba(51, 195, 240, 0.1), rgba(161, 222, 255, 0.5));
  padding: 4rem 0;
  text-align: center;
}

.contact-hero h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.contact-hero p {
  max-width: 800px;
  margin: 0 auto;
  font-size: 1.125rem;
  color: #555;
}

.contact-section {
  padding: 4rem 0;
}

.contact-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
}

@media (min-width: 768px) {
  .contact-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

.contact-info h2, 
.contact-form-container h2 {
  font-size: 2rem;
  margin-bottom: 2rem;
}

.contact-cards {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.contact-card {
  display: flex;
  gap: 1rem;
  background: #fff;
  border-radius: 0.5rem;
  padding: 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border: 1px solid #e5e7eb;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.contact-card-icon {
  width: 3rem;
  height: 3rem;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(51, 195, 240, 0.1);
  border-radius: 50%;
  flex-shrink: 0;
}

.contact-card-icon svg {
  width: 1.5rem;
  height: 1.5rem;
  color: #33C3F0;
}

.contact-card-content {
  flex: 1;
}

.contact-card h3 {
  font-size: 1.25rem;
  margin-bottom: 0.5rem;
}

.contact-card p {
  color: #666;
}

.text-small {
  font-size: 0.875rem;
  color: #8E9196;
  margin-top: 0.5rem;
}

.hours-grid {
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 0.5rem;
  font-size: 0.875rem;
}

.contact-form-card {
  background: #fff;
  border-radius: 0.5rem;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border: 1px solid #e5e7eb;
}

.contact-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
}

@media (min-width: 640px) {
  .form-row {
    grid-template-columns: repeat(2, 1fr);
  }
}

.contact-form label {
  font-size: 0.875rem;
  font-weight: 500;
}

.contact-form input,
.contact-form textarea {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  font-family: 'Open Sans', sans-serif;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.contact-form input:focus,
.contact-form textarea:focus {
  border-color: #33C3F0;
  outline: none;
}

.submit-btn {
  width: 100%;
  padding: 0.75rem;
  font-size: 1rem;
}

/* Map Section */
.map-section {
  padding: 3rem 0;
  background-color: #f9fafb;
  text-align: center;
}

.map-section h2 {
  font-size: 2rem;
  margin-bottom: 2rem;
}

.map-container {
  height: 400px;
  border-radius: 0.5rem;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.map-container iframe {
  width: 100%;
  height: 100%;
  border: none;
}

/* Team Section */
.team-section {
  padding: 4rem 0;
  text-align: center;
}

.team-section h2 {
  font-size: 2rem;
  margin-bottom: 3rem;
}

.team-grid {
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  gap: 2rem;
}

@media (min-width: 640px) {
  .team-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .team-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

.team-card {
  background: #fff;
  border-radius: 0.5rem;
  padding: 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border: 1px solid #e5e7eb;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.team-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.team-image {
  width: 8rem;
  height: 8rem;
  border-radius: 50%;
  overflow: hidden;
  margin: 0 auto 1rem;
}

.team-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.team-card h3 {
  font-size: 1.25rem;
  margin-bottom: 0.25rem;
}

.team-card p {
  color: #33C3F0;
  font-weight: 500;
}

/* Feedback Section */
.feedback-section {
  padding: 4rem 0;
  background-color: #f9fafb;
  text-align: center;
}

.feedback-section h2 {
  font-size: 2rem;
  margin-bottom: 2rem;
}

.feedback-card {
  background: #fff;
  border-radius: 0.5rem;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border: 1px solid #e5e7eb;
  max-width: 700px;
  margin: 0 auto;
}

.feedback-form {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.rating-label {
  font-size: 1.125rem;
  font-weight: 500;
  margin-bottom: 1rem;
  display: block;
}

.star-rating {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
  font-size: 2.5rem;
  color: #33C3F0;
  cursor: pointer;
}

.star:hover,
.star:hover ~ .star {
  color: #1EAEDB;
}

/* Toast Notifications */
.toast-container {
  position: fixed;
  bottom: 2rem;
  right: 2rem;
  z-index: 1000;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.toast {
  background-color: white;
  border-radius: 0.5rem;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  padding: 1rem;
  min-width: 300px;
  max-width: 400px;
  opacity: 0;
  transform: translateY(1rem);
  transition: all 0.3s ease;
}

.toast.show {
  opacity: 1;
  transform: translateY(0);
}

.toast-content span {
  font-weight: 600;
  display: block;
  margin-bottom: 0.25rem;
}

.toast-content p {
  font-size: 0.875rem;
  color: #666;
}

.toast.success {
    border-left: 4px solid #4CAF50; /* Green for success */
}

.toast.error {
    border-left: 4px solid #F44336; /* Red for error */
}
</style>

<main>
    <!-- Hero Section -->
    <section class="contact-hero">
      <div class="container">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you! Reach out with any questions about our services or to schedule an appointment.</p>
      </div>
    </section>

    <!-- Contact Info & Form -->
    <section class="contact-section">
      <div class="container">
        <div class="contact-grid">
          <!-- Contact Information -->
          <div class="contact-info">
            <h2>Get In Touch</h2>
            
            <div class="contact-cards">
              <div class="contact-card">
                <div class="contact-card-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                  </svg>
                </div>
                <div class="contact-card-content">
                  <h3>Phone</h3>
                  <p>09811753921</p>
                  <p class="text-small">Available Monday-Saturday, 9AM-5PM</p>
                </div>
              </div>
              
              <div class="contact-card">
                <div class="contact-card-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                  </svg>
                </div>
                <div class="contact-card-content">
                  <h3>Email</h3>
                  <p>brightbitecare@gmail.com</p>
                  <p class="text-small">We typically respond within 24 hours</p>
                </div>
              </div>
              
              <div class="contact-card">
                <div class="contact-card-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                  </svg>
                </div>
                <div class="contact-card-content">
                  <h3>Address</h3>
                  <p>Pamantasan ng Lungsod ng Muntinlupa City, Metro Manila</p>
                </div>
              </div>

              <div class="contact-card">
                <div class="contact-card-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                  </svg>
                </div>
                <div class="contact-card-content">
                  <h3>Hours of Operation</h3>
                  <div class="hours-grid">
                    <p>Monday - Friday:</p>
                    <p>9:00 AM - 5:00 PM</p>
                    <p>Saturday:</p>
                    <p>9:00 AM - 3:00 PM</p>
                    <p>Sunday:</p>
                    <p>Closed</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Contact Form -->
          <div class="contact-form-container">
            <h2>Send a Message</h2>
            <div class="contact-form-card">
              <form id="contactForm" class="contact-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                  <label for="name">Full Name</label>
                  <input type="text" id="name" name="name" placeholder="Your Name" required>
                </div>
                
                <div class="form-row">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Your Email" required>
                  </div>
                  <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Your Phone">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="message">Message</label>
                  <textarea id="message" name="message" placeholder="How can we help you?" rows="5" required></textarea>
                </div>
                
                <button type="submit" name="send_message" class="btn btn-primary submit-btn">Submit Message</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Map -->
    <section class="map-section">
      <div class="container">
        <h2>Find Us</h2>
        <div class="map-container">
          <iframe 
            title="Clinic Location"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3864.1988403770627!2d121.0321513!3d14.404739699999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d0bcad49834f%3A0x73184055e25a52d8!2sPamantasan%20ng%20Lungsod%20ng%20Muntinlupa!5e0!3m2!1sen!2sph!4v1624561234567!5m2!1sen!2sph" 
            loading="lazy">
          </iframe>
        </div>
      </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
      <div class="container">
        <h2>Meet Our Team</h2>
        <div class="team-grid">
          <div class="team-card">
            <div class="team-image">
              <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Dr. Jecca Argame">
            </div>
            <h3>Dr. Jecca Argame</h3>
            <p>Chief Dental Officer</p>
          </div>
          
          <div class="team-card">
            <div class="team-image">
              <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Dr. Jiggy Suva">
            </div>
            <h3>Dr. Jiggy Suva</h3>
            <p>Clinical Director</p>
          </div>
          
          <div class="team-card">
            <div class="team-image">
              <img src="https://images.unsplash.com/photo-1594824476967-48c8b964273f?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Dr. Maria Santos">
            </div>
            <h3>Dr. Maria Santos</h3>
            <p>Orthodontist</p>
          </div>
          
          <div class="team-card">
            <div class="team-image">
              <img src="https://images.unsplash.com/photo-1614608682850-e0d6ed316d47?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80" alt="Anna Rivera">
            </div>
            <h3>Anna Rivera</h3>
            <p>Dental Hygienist</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Feedback Section -->
    <section class="feedback-section">
      <div class="container">
        <h2>Leave Your Feedback</h2>
        <?php if (isset($_SESSION['user_id'])): ?>
          <div class="feedback-card">
            <form id="feedbackForm" class="feedback-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <input type="hidden" name="rating" id="hiddenRatingInput" value="0">
              <div class="form-group">
                <label class="rating-label">How would you rate your experience?</label>
                <div class="star-rating">
                  <span class="star" data-rating="1">☆</span>
                  <span class="star" data-rating="2">☆</span>
                  <span class="star" data-rating="3">☆</span>
                  <span class="star" data-rating="4">☆</span>
                  <span class="star" data-rating="5">☆</span>
                </div>
              </div>
              
              <div class="form-group">
                <label for="comment">Comments or Suggestions</label>
                <textarea id="comment" name="comment" placeholder="Tell us about your experience" rows="4"></textarea>
              </div>
              
              <button type="submit" name="submit_feedback" class="btn btn-primary submit-btn" id="feedbackSubmitBtn" disabled>Submit Feedback</button>
            </form>
          </div>
        <?php else: ?>
          <div class="feedback-card">
            <p style="text-align: center;">Please <a href="login.php">log in</a> to leave feedback.</p>
          </div>
        <?php endif; ?>
      </div>
    </section>
  </main>

<div class="toast-container" id="toastContainer">
  <!-- Toasts will be appended here by JavaScript -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const toastContainer = document.getElementById('toastContainer');

    function showToast(type, title, message) {
        const toast = document.createElement('div');
        toast.classList.add('toast', type); // type can be 'success' or 'error'
        
        toast.innerHTML = `
            <div class="toast-content">
                <span>${title}</span>
                <p>${message}</p>
            </div>
        `;
        toastContainer.appendChild(toast);

        // Trigger reflow to enable animation
        toast.offsetHeight; 

        toast.classList.add('show');

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 300); // Wait for fade out animation
        }, 5000); // Show toast for 5 seconds
    }

    <?php if ($message_sent): ?>
        showToast('success', 'Message Sent!', 'Thank you for contacting us. We will get back to you shortly.');
        if (contactForm) {
            contactForm.reset(); // Clear the form
        }
    <?php elseif (!empty($error_message)): ?>
        showToast('error', 'Message Error!', '<?php echo addslashes($error_message); ?>');
    <?php endif; ?>

    <?php if (!empty($feedback_success_message)): ?>
        showToast('success', 'Feedback Submitted!', '<?php echo addslashes($feedback_success_message); ?>');
        // Optionally reset feedback form if it exists and user is logged in
        const feedbackFormForReset = document.getElementById('feedbackForm');
        if (feedbackFormForReset) {
            feedbackFormForReset.reset();
            document.querySelectorAll('.star-rating .star').forEach(s => s.textContent = '☆');
            document.getElementById('hiddenRatingInput').value = '0';
            if(document.getElementById('feedbackSubmitBtn')) {
                 document.getElementById('feedbackSubmitBtn').disabled = true;
            }
        }
    <?php elseif (!empty($feedback_error_message)): ?>
        showToast('error', 'Feedback Error!', '<?php echo addslashes($feedback_error_message); ?>');
    <?php endif; ?>

    const feedbackForm = document.getElementById('feedbackForm');
    const stars = document.querySelectorAll('.star-rating .star');
    const feedbackSubmitBtn = document.getElementById('feedbackSubmitBtn');
    const hiddenRatingInput = document.getElementById('hiddenRatingInput');
    let currentRating = 0;

    if (stars.length > 0 && feedbackSubmitBtn && hiddenRatingInput) {
        stars.forEach(star => {
            star.addEventListener('click', () => {
                currentRating = parseInt(star.dataset.rating);
                hiddenRatingInput.value = currentRating; // Update hidden input
                stars.forEach(s => {
                    s.textContent = parseInt(s.dataset.rating) <= currentRating ? '★' : '☆';
                });
                feedbackSubmitBtn.disabled = false;
            });
        });
    }
});
</script>

<?php include "includes/footer.php"; ?> 
<?php include "includes/footer.php"; ?> 