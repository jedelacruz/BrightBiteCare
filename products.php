<?php
session_start(); // Start session at the very top
require_once "includes/config.php"; // Include config (e.g., for BASE_URL, though not directly used for query here)
require_once "includes/db_connection.php"; // Include database connection: defines $conn

$pageTitle = "Our Products";
include "includes/header.php"; // Include header

// Display session messages from create_order.php
if (isset($_SESSION['success_message_products'])) {
    echo '<div class="container" style="margin-top: 1rem; margin-bottom: 1rem;"><div class="alert alert-success" style="padding: 1rem; background-color: #d4edda; border-color: #c3e6cb; color: #155724; border-radius: .25rem;">' . htmlspecialchars($_SESSION['success_message_products']) . '</div></div>';
    unset($_SESSION['success_message_products']); // Clear message after displaying
}
if (isset($_SESSION['error_message_products'])) {
    echo '<div class="container" style="margin-top: 1rem; margin-bottom: 1rem;"><div class="alert alert-danger" style="padding: 1rem; background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; border-radius: .25rem;">' . htmlspecialchars($_SESSION['error_message_products']) . '</div></div>';
    unset($_SESSION['error_message_products']); // Clear message after displaying
}

// Fetch products from the database
$products_sql = "SELECT id, name, price, image_url, description FROM products";
$products_result = null; // Initialize to null
if ($conn) { // Check if $conn is not null
    $products_result = $conn->query($products_sql);
} else {
    // Log error or display a message if $conn is null
    error_log("Database connection is not available in products.php");
    echo '<div class="container" style="margin-top: 1rem; margin-bottom: 1rem;"><div class="alert alert-danger">Could not connect to the product catalog. Please try again later.</div></div>';
}

$products = [];
if ($products_result && $products_result->num_rows > 0) {
    while ($row = $products_result->fetch_assoc()) {
        $products[] = $row;
    }
}

?>

<main>
  <!-- Hero Section -->
  <section class="products-hero">
    <div class="container">
      <h1>Dental Products</h1>
      <p>Explore our carefully selected range of high-quality dental care products to maintain your oral health between visits.</p>
    </div>
  </section>

  <!-- Products Grid -->
  <section class="products-grid">
    <div class="container">
      <div class="products-list" id="productsContainer">
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $product): ?>
            <div class="product-card">
              <div class="product-image-container">
                <img src="<?php echo htmlspecialchars(!empty($product['image_url']) ? $product['image_url'] : 'https://via.placeholder.com/300x200.png?text=No+Image'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                <!-- You can add badges if you have logic for them -->
              </div>
              <div class="product-content">
                <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                <p class="product-description"><?php echo htmlspecialchars(!empty($product['description']) ? $product['description'] : 'High-quality dental product.'); ?></p>
                <div class="product-footer">
                  <span class="product-price">₱<?php echo number_format($product['price'], 2); ?></span>
                  <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="create_order.php" method="POST" style="display: inline;">
                      <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                      <button type="submit" class="btn add-to-cart-btn">Order Now</button>
                    </form>
                  <?php else: ?>
                    <a href="login.php" class="btn add-to-cart-btn">Login to Order</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php elseif ($conn): // Only show no products if DB connection was okay but no products found ?>
          <p>No products found in the catalog at this time.</p>
        <?php else: // Message if DB connection failed earlier ?>
          <p>There was an issue loading products. Please try refreshing the page.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>
</main>

<style>
.products-hero {
  background: linear-gradient(to bottom right, rgba(51, 195, 240, 0.1), rgba(161, 222, 255, 0.5));
  padding: 4rem 0;
  text-align: center;
}

.products-hero h1 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.products-hero p {
  max-width: 800px;
  margin: 0 auto;
  font-size: 1.125rem;
  color: #555;
}

.products-grid {
  padding: 4rem 0;
}

.products-list {
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  gap: 1.5rem;
}

@media (min-width: 640px) {
  .products-list {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 1024px) {
  .products-list {
    grid-template-columns: repeat(4, 1fr);
  }
}

.product-card {
  background: #fff;
  border-radius: 0.75rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border: 1px solid #e5e7eb;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  height: 100%;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.product-image-container {
  height: 12rem;
  position: relative;
  overflow: hidden;
}

.product-badge {
  position: absolute;
  top: 0.5rem;
  right: 0.5rem;
  background-color: #33C3F0;
  color: white;
  font-size: 0.75rem;
  font-weight: 600;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  z-index: 1;
}

.product-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.product-card:hover .product-image {
  transform: scale(1.05);
}

.product-content {
  padding: 1.5rem 1rem;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

.product-title {
  font-size: 1.125rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.product-description {
  color: #666;
  font-size: 0.875rem;
  margin-bottom: 1.5rem;
  flex-grow: 1;
}

.product-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: auto;
}

.product-price {
  font-weight: 700;
  font-size: 1.125rem;
}

.add-to-cart-btn {
  border-radius: 9999px !important;
}

.shipping-info {
  padding: 3rem 0;
  background-color: #f9fafb;
}

.info-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
  text-align: center;
}

@media (min-width: 768px) {
  .info-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

.info-item h3 {
  font-size: 1.25rem;
  margin-bottom: 0.5rem;
}

.info-item p {
  color: #666;
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

</style>

<script>
// Removed JavaScript for modal and AJAX order processing.
// The "Order Now" button is now a direct form submission.

// Close modal when clicking outside - This is no longer needed as modal is removed.
/*
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
        currentProduct = null;
    }
}
*/
</script>

<?php include "includes/footer.php"; ?>