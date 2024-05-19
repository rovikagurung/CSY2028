<?php
include 'includes/header.php';
include 'includes/db.php'; // Ensure this includes your database connection

// Check if admin ID is provided in the URL
if (!isset($_GET['id'])) {
    echo '<p>Admin ID not provided.</p>';
    include 'includes/footer.php';
    exit;
}

$admin_id = $_GET['id']; // Retrieve admin ID from URL parameter

// Fetch admin details from database
$stmt = $pdo->prepare('SELECT * FROM admins WHERE id = ?');
$stmt->execute([$admin_id]);
$admin = $stmt->fetch(); // Fetch the admin details

// Check if admin exists
if (!$admin) {
    echo '<p>Admin not found.</p>';
    include 'includes/footer.php';
    exit;
}

// Update admin if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; // Retrieve and sanitize username from form input
    $password = $_POST['password']; // Retrieve password from form input

    // Validate and sanitize input (you can add more validation as needed)
    $username = htmlspecialchars(trim($username));
    // Example hashing for demonstration, use password_hash() in production
    $hashed_password = md5($password);

    // Update admin in database
    try {
        $stmt = $pdo->prepare('UPDATE admins SET username = ?, password = ? WHERE id = ?');
        $stmt->execute([$username, $hashed_password, $admin_id]);
        // Optionally, you can add a success message or redirect to another page
        echo '<p>Admin updated successfully!</p>';
    } catch (PDOException $e) {
        // Handle database errors
        echo 'Error: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin - <?php echo htmlspecialchars($admin['username']); ?></title>
    <link rel="stylesheet" href="css/form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <section>
        <h1>Edit Admin - <?php echo htmlspecialchars($admin['username']); ?></h1>
        <!-- Form to edit admin details -->
        <form action="editAdmin.php?id=<?php echo $admin_id; ?>" method="post">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="input-group">
                <input type="submit" value="Update Admin">
            </div>
        </form>
    </section>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
