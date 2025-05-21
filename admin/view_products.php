<?php 
$pageTitle = "Manage Products";
include 'admin_header.php'; 

// Fetch products from the database
$products_sql = "SELECT id, name, price, image_url, description FROM products ORDER BY id ASC";
$products_result = $conn->query($products_sql);
?>

<h2>Product Management</h2>

<?php if ($products_result && $products_result->num_rows > 0): ?>
    <div class="admin-table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <!-- <th>Actions</th> --> <?php // Future placeholder ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($product = $products_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td>
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 50px; height: auto; border-radius: 4px;">
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td>₱<?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo htmlspecialchars(substr($product['description'] ?? '', 0, 100)); ?><?php echo strlen($product['description'] ?? '') > 100 ? '...' : ''; ?></td>
                    <!-- <td class="admin-actions"> -->
                        <?php // echo "<a href='edit_product.php?id={$product['id']}'>Edit</a>"; ?>
                    <!-- </td> -->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>

<?php include 'admin_footer.php'; ?> 