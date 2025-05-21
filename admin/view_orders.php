<?php 
$pageTitle = "View Orders";
include 'admin_header.php'; 

// Fetch orders with user details and order items with product details
$orders_sql = "SELECT 
                    o.id AS order_id,
                    o.total_amount,
                    o.status AS order_status,
                    o.created_at AS order_date,
                    u.full_name AS customer_name,
                    u.email AS customer_email,
                    u.phone AS customer_phone,
                    GROUP_CONCAT(CONCAT(p.name, ' (Qty: ', oi.quantity, ', Price: ₱', FORMAT(oi.price, 2), ')') SEPARATOR '<br>') AS order_items_details
                FROM orders o
                JOIN users u ON o.user_id = u.id
                JOIN order_items oi ON o.id = oi.order_id
                JOIN products p ON oi.product_id = p.id
                GROUP BY o.id
                ORDER BY o.created_at DESC";

$orders_result = $conn->query($orders_sql);

if (!$orders_result) {
    // Handle query error
    echo "Error fetching orders: " . $conn->error;
    // You might want to log this error and display a user-friendly message
}

?>

<h2>Order Management</h2>

<?php if ($orders_result && $orders_result->num_rows > 0): ?>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Items</th>
                    <!-- <th>Actions</th> -->
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $order['order_id']; ?></td>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                        <td><?php echo htmlspecialchars($order['customer_phone'] ?? 'N/A'); ?></td>
                        <td><?php echo date('M j, Y, g:i a', strtotime($order['order_date'])); ?></td>
                        <td>₱<?php echo number_format($order['total_amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($order['order_status'])); ?></td>
                        <td><?php echo $order['order_items_details']; // This contains HTML (<br>), so no htmlspecialchars here ?></td> 
                        <!-- <td class="admin-actions"> -->
                            <?php // echo "<a href='view_order_detail.php?id={$order['order_id']}'>Details</a>"; ?>
                        <!-- </td> -->
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php elseif ($orders_result): // Query was successful but no rows ?>
    <p>No orders found.</p>
<?php else: // Query failed (error message already echoed or would be handled) ?>
    <p>Could not retrieve orders at this time.</p>
<?php endif; ?>

<?php include 'admin_footer.php'; ?> 