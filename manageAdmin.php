<?php
// Include the header file to maintain consistent UI
include 'includes/header.php';

// Include the database connection file
include 'includes/db.php'; // Ensure this includes your database connection

// Function to fetch all admins from the database
function getAllAdmins($pdo) {
    $stmt = $pdo->query('SELECT * FROM admins');
    return $stmt->fetchAll(); // Return all admins as an associative array
}

// Fetch all admins using the defined function
$admins = getAllAdmins($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admin</title>
    <link rel="stylesheet" href="css/form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<section>
    <h1>Manage Admins</h1>
    <!-- Display admins in a table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <!-- Display admin ID and username -->
                    <td><?php echo htmlspecialchars($admin['id']); ?></td>
                    <td><?php echo htmlspecialchars($admin['username']); ?></td>
                    <td>
                        <!-- Link to edit admin page -->
                        <a href="editAdmin.php?id=<?php echo $admin['id']; ?>">Edit</a>
                        <!-- Example link to delete admin (with confirmation) -->
                        <a href="deleteAdmin.php?id=<?php echo $admin['id']; ?>" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Link to add new admin page -->
    <a href="addAdmin.php">Add Admin</a>
</section>
</body>
</html>

<?php
// Include the footer file to maintain consistent UI
include 'includes/footer.php';
?>
