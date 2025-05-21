<?php 
$pageTitle = "Manage Users";
include 'admin_header.php'; 

// Fetch users from the database
$users_sql = "SELECT id, username, email, full_name, phone, address, is_admin, created_at FROM users ORDER BY created_at DESC";
$users_result = $conn->query($users_sql);
?>

<h2>User Management</h2>

<?php if ($users_result && $users_result->num_rows > 0): ?>
    <div class="admin-table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Admin?</th>
                <th>Registered At</th>
                <!-- <th>Actions</th> --> <?php // Future placeholder for edit/delete ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $users_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($user['address'] ?? 'N/A'); ?></td>
                    <td><?php echo $user['is_admin'] ? 'Yes' : 'No'; ?></td>
                    <td><?php echo date('M j, Y, g:i a', strtotime($user['created_at'])); ?></td>
                    <!-- <td class="admin-actions"> -->
                        <?php // echo "<a href='edit_user.php?id={$user['id']}'>Edit</a>"; ?>
                        <?php // echo "<a href='delete_user.php?id={$user['id']}' onclick=\"return confirm('Are you sure?')\">Delete</a>"; ?>
                    <!-- </td> -->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
<?php else: ?>
    <p>No users found.</p>
<?php endif; ?>

<?php include 'admin_footer.php'; ?> 