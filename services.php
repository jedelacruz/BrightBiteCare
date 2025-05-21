<?php
session_start(); // Start session at the very top
require_once "includes/config.php"; 
require_once "includes/db_connection.php"; // Defines $conn

$pageTitle = "Our Services";
include "includes/header.php";

// Display session messages from create_appointment.php
if (isset($_SESSION['success_message_services'])) {
    echo '<div class="container" style="margin-top: 1rem; margin-bottom: 1rem;"><div class="alert alert-success" style="padding: 1rem; background-color: #d4edda; border-color: #c3e6cb; color: #155724; border-radius: .25rem;">' . htmlspecialchars($_SESSION['success_message_services']) . '</div></div>';
    unset($_SESSION['success_message_services']);
}
if (isset($_SESSION['error_message_services'])) {
    echo '<div class="container" style="margin-top: 1rem; margin-bottom: 1rem;"><div class="alert alert-danger" style="padding: 1rem; background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; border-radius: .25rem;">' . htmlspecialchars($_SESSION['error_message_services']) . '</div></div>';
    unset($_SESSION['error_message_services']);
}

// Fetch services from the database
$services_sql = "SELECT id, name, price FROM services"; 
$services_result = null; 
if ($conn) { 
    $services_result = $conn->query($services_sql);
} else {
    error_log("Database connection is not available in services.php");
    echo '<div class="container" style="margin-top: 1rem; margin-bottom: 1rem;"><div class="alert alert-danger">Could not connect to the services catalog. Please try again later.</div></div>';
}

$services_data = [];
if ($services_result && $services_result->num_rows > 0) {
    while ($row = $services_result->fetch_assoc()) {
        $services_data[] = $row;
    }
}

?>

<style>
  .services-hero {
  background: linear-gradient(to bottom right, rgba(51, 195, 240, 0.1), rgba(161, 222, 255, 0.5));
  padding: 4rem 0;
  text-align: center;
}

.services-hero h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.services-hero p {
  max-width: 800px;
  margin: 0 auto;
  font-size: 1.125rem;
  color: #555;
}

.services-grid {
  padding: 4rem 0;
}

.services-list {
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  gap: 2rem;
}

@media (min-width: 640px) {
  .services-list {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .services-list {
    grid-template-columns: repeat(4, 1fr);
  }
}

.service-card {
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  padding: 1.5rem;
  text-align: center;
  height: 100%;
  display: flex;
  flex-direction: column;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.service-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.service-icon {
  display: flex;
  justify-content: center;
  margin-bottom: 1rem;
}

.service-icon svg {
  width: 3rem;
  height: 3rem;
  color: #33C3F0;
}

.service-card h3 {
  font-size: 1.25rem;
  margin-bottom: 0.75rem;
}

.service-card p {
  font-size: 0.875rem;
  color: #666;
  margin-bottom: 1.5rem;
  flex-grow: 1;
}

.service-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: auto;
  width: 100%;
}

.why-choose-us {
  padding: 4rem 0;
  background-color: #f9fafb;
}

.why-choose-us h2 {
  font-size: 2rem;
  text-align: center;
  margin-bottom: 3rem;
}

.benefits-grid {
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  gap: 2rem;
}

@media (min-width: 640px) {
  .benefits-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .benefits-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

.benefit-card {
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  padding: 1.5rem;
  text-align: center;
  height: 100%;
  display: flex;
  flex-direction: column;
  transition: transform 0.3s ease;
}

.benefit-card:hover {
  transform: translateY(-5px);
}

.benefit-icon {
  display: flex;
  justify-content: center;
  margin-bottom: 1rem;
}

.benefit-icon svg {
  width: 3rem;
  height: 3rem;
  color: #33C3F0;
}

.benefit-card h3 {
  font-size: 1.25rem;
  margin-bottom: 0.75rem;
}

.benefit-card p {
  font-size: 0.875rem;
  color: #666;
}

/* Modal Styles */
.modal {
  display: none;
  position: fixed;
  z-index: 100;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
}

.modal.show-modal {
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 1;
  visibility: visible;
}

.modal-content {
  background-color: #fff;
  margin: 2rem;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  max-width: 600px;
  width: 100%;
  position: relative;
  transform: scale(0.8);
  transition: transform 0.3s ease;
}

.show-modal .modal-content {
  transform: scale(1);
}

.close-modal {
  position: absolute;
  right: 1.5rem;
  top: 1rem;
  font-size: 1.5rem;
  font-weight: bold;
  color: #aaa;
  cursor: pointer;
}

.close-modal:hover {
  color: #33C3F0;
}

.modal h2 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.modal p {
  margin-bottom: 1.5rem;
  color: #555;
}

.benefits-list h4 {
  font-size: 1.125rem;
  margin-bottom: 0.5rem;
  font-weight: 600;
}

#serviceBenefits {
  list-style-type: disc;
  padding-left: 1.5rem;
  margin-bottom: 1.5rem;
}

#serviceBenefits li {
  margin-bottom: 0.5rem;
  color: #555;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
  margin-top: 2rem;
}

</style>

<section class="services-hero">
            <div class="container">
                <h1>Our Services</h1>
                <p>We offer a comprehensive range of dental services to meet all your oral health needs. Review our services below and book an appointment.</p>
            </div>
        </section>

        <!-- Services Grid -->
<section class="services-grid">
    <div class="container">
        <div class="services-list">

            <?php if (!empty($services_data)): ?>
                <?php foreach ($services_data as $service): ?>
                    <div class="service-card">
                        <!-- SVG icon removed for simplicity, can be added back if stored in DB -->
                        <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                        <!-- Static description removed, can be added if stored in DB -->
                        <p>A high-quality dental service to meet your needs.</p> 
                        <p><strong>Price:</strong> ₱<?php echo number_format($service['price'], 2); ?></p>
                        <div class="service-btn">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <form action="create_appointment.php" method="POST">
                                    <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
                                    <button type="submit" name="book_service" class="btn btn-primary">Book Us Now</button>
                                </form>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-primary">Login to Book</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php elseif ($conn): ?>
                <p>No services found in the catalog at this time.</p>
            <?php else: ?>
                 <p>There was an issue loading services. Please try refreshing the page.</p>
            <?php endif; ?>

        </div>
    </div>
</section>


        <!-- Why Choose Us -->
        <section class="why-choose-us">
            <div class="container">
                <h2>Why Choose Our Services</h2>
                <div class="benefits-grid">
                    <!-- Benefit 1 -->
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <h3>Convenient Scheduling</h3>
                        <p>We offer flexible appointment times to accommodate your busy schedule.</p>
                    </div>

                    <!-- Benefit 2 -->
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                        <h3>State-of-the-Art Equipment</h3>
                        <p>We utilize the latest dental technology for more comfortable and effective treatments.</p>
                    </div>

                    <!-- Benefit 3 -->
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M16 8h-6a2 2 0 100 4h4a2 2 0 110 4H8"></path>
                                <line x1="12" y1="6" x2="12" y2="8"></line>
                                <line x1="12" y1="16" x2="12" y2="18"></line>
                            </svg>
                        </div>
                        <h3>Transparent Pricing</h3>
                        <p>We provide clear cost information before beginning any treatment.</p>
                    </div>

                    <!-- Benefit 4 -->
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                <line x1="15" y1="9" x2="15.01" y2="9"></line>
                            </svg>
                        </div>
                        <h3>Gentle Approach</h3>
                        <p>Our team is known for providing compassionate, gentle dental care.</p>
                    </div>
                </div>
            </div>
        </section>

<?php include "includes/footer.php"; ?> 