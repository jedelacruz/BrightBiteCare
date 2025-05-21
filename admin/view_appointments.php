<?php 
$pageTitle = "View Appointments";
include 'admin_header.php'; 

// Fetch appointments with user and service details
$appointments_sql = "SELECT 
                        a.id AS appointment_id,
                        a.appointment_date,
                        a.appointment_time,
                        a.status AS appointment_status,
                        a.created_at AS request_date,
                        u.full_name AS customer_name,
                        u.email AS customer_email,
                        u.phone AS customer_phone,
                        s.name AS service_name,
                        s.price AS service_price
                    FROM appointments a
                    JOIN users u ON a.user_id = u.id
                    JOIN services s ON a.service_id = s.id
                    ORDER BY a.created_at DESC";

$appointments_result = $conn->query($appointments_sql);

if (!$appointments_result) {
    echo "Error fetching appointments: " . $conn->error;
}

?>

<h2>Appointment Management</h2>

<?php if ($appointments_result && $appointments_result->num_rows > 0): ?>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Appt. ID</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Service Name</th>
                    <th>Service Price</th>
                    <th>Appt. Date</th>
                    <th>Appt. Time</th>
                    <th>Status</th>
                    <th>Requested On</th>
                    <!-- <th>Actions</th> -->
                </tr>
            </thead>
            <tbody>
                <?php while ($appt = $appointments_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $appt['appointment_id']; ?></td>
                        <td><?php echo htmlspecialchars($appt['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($appt['customer_email']); ?></td>
                        <td><?php echo htmlspecialchars($appt['customer_phone'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($appt['service_name']); ?></td>
                        <td>₱<?php echo number_format($appt['service_price'], 2); ?></td>
                        <td><?php echo date('M j, Y', strtotime($appt['appointment_date'])); ?></td>
                        <td><?php echo date('g:i a', strtotime($appt['appointment_time'])); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($appt['appointment_status'])); ?></td>
                        <td><?php echo date('M j, Y, g:i a', strtotime($appt['request_date'])); ?></td>
                        <!-- <td class="admin-actions"> -->
                            <?php // echo "<a href='edit_appointment.php?id={$appt['appointment_id']}'>Edit Status</a>"; ?>
                        <!-- </td> -->
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php elseif ($appointments_result): ?>
    <p>No appointments found.</p>
<?php else: ?>
    <p>Could not retrieve appointments at this time.</p>
<?php endif; ?>

<?php include 'admin_footer.php'; ?> 