<?php 
$pageTitle = "Manage Services";
include 'admin_header.php'; 

// Fetch services from the database
$services_sql = "SELECT id, name, price FROM services ORDER BY id ASC";
$services_result = $conn->query($services_sql);
?>

<h2>Service Management</h2>

<?php if ($services_result && $services_result->num_rows > 0): ?>
    <div class="admin-table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <!-- <th>Actions</th> --> <?php // Future placeholder ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($service = $services_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $service['id']; ?></td>
                    <td><?php echo htmlspecialchars($service['name']); ?></td>
                    <td>₱<?php echo number_format($service['price'], 2); ?></td>
                    <!-- <td class="admin-actions"> -->
                        <?php // echo "<a href='edit_service.php?id={$service['id']}'>Edit</a>"; ?>
                    <!-- </td> -->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
<?php else: ?>
    <p>No services found.</p>
<?php endif; ?>

<?php include 'admin_footer.php'; ?> 