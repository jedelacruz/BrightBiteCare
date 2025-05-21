<?php 
$pageTitle = "View Messages";
include 'admin_header.php'; 

// Fetch messages from the database
$messages_sql = "SELECT id, name, email, subject, message, status, created_at FROM messages ORDER BY created_at DESC";
$messages_result = $conn->query($messages_sql);
?>

<h2>View Messages</h2>
<?php if ($messages_result && $messages_result->num_rows > 0): ?>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Received At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($message = $messages_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($message['id']); ?></td>
                        <td><?php echo htmlspecialchars($message['name']); ?></td>
                        <td><?php echo htmlspecialchars($message['email']); ?></td>
                        <td><?php echo htmlspecialchars($message['subject'] ?? 'N/A'); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
                        <td><?php echo htmlspecialchars($message['status']); ?></td>
                        <td><?php echo date('M j, Y, g:i a', strtotime($message['created_at'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>No messages found.</p>
<?php endif; ?>

<?php include 'admin_footer.php'; ?> 