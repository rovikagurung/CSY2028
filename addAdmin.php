<?php
session_start();
include 'includes/db.php'; // Ensure this includes your database connection

// Ensure only authenticated admins can access
// if (!isset($_SESSION['admin_id'])) {
//     header('Location: login.php'); // Redirect to login page if not logged in as admin
//     exit();
// }

// Handle form submission to add new admin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs (you can add more validation as needed)
    $username = htmlspecialchars(trim($username));
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    try {
        $stmt = $pdo->prepare('INSERT INTO admins (username, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$username, $email, $hashedPassword]);
        
        // Optionally, you can add a success message or redirect to another page
        echo '<p>Admin added successfully!</p>';
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <link rel="stylesheet" href="css/form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php 
    include 'includes/header.php';
    ?>
    <section>
    <h1>Add Admin</h1>
    
    <!-- Add Admin Form -->
    <form action="addAdmin.php" method="post">
        <div class="input-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
        </div>
        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
        </div>
        <div class="input-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
        </div>
        <div class="input-group">
            <input type="submit" value="Add Admin">
        </div>
    </form>
    
    <p><a href="manageAdmin.php">Back to Manage Admins</a></p>
    </section>
    
    <?php 
    include 'includes/footer.php';
    ?>
</body>
</html>
