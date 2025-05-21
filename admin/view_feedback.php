<?php 
$pageTitle = "View Feedback";
include 'admin_header.php'; 

// Fetch feedback from the database
$feedback_sql = "SELECT f.id, u.username, u.email, f.rating, f.comment, f.created_at FROM feedback f JOIN users u ON f.user_id = u.id ORDER BY f.created_at DESC";
$feedback_result = $conn->query($feedback_sql);
?>

<h2>View Feedback</h2>
<?php if ($feedback_result && $feedback_result->num_rows > 0): ?>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($feedback = $feedback_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($feedback['id']); ?></td>
                        <td><?php echo htmlspecialchars($feedback['username']); ?></td>
                        <td><?php echo htmlspecialchars($feedback['email']); ?></td>
                        <td><?php echo htmlspecialchars($feedback['rating']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($feedback['comment'] ?? 'N/A')); ?></td>
                        <td><?php echo date('M j, Y, g:i a', strtotime($feedback['created_at'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>No feedback found.</p>
<?php endif; ?>

<?php include 'admin_footer.php'; ?> 