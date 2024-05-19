<?php
// Start the session to manage user sessions
session_start();

// Include the database connection file
include 'includes/db.php';

// Check if the form is submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve email and password from POST data
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Prepare SQL statement to retrieve user information based on email
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Verify if user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            // Check if the user is an admin
            if ($user['is_admin'] == 1) {
                // Set session variables for admin
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['is_admin'] = true; // Store admin status in session

                // Redirect to admin panel or dashboard
                header('Location: manageAdmin.php');
                exit();
            } else {
                // Regular user login logic
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['name'];

                // Redirect to regular user dashboard or homepage
                header('Location: index.php');
                exit();
            }
        } else {
            // Display error message for invalid email or password
            $errorMessage = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        // Display error message if there's an issue with database operations
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <form action="login.php" method="post">
            <div class="logo">
                <a href="index.php">
                    <h1><span class="c">C</span><span class="a">a</span><span class="r">r</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
                </a>
            </div>
            <?php if (isset($errorMessage)): ?>
            <!-- Display error message if login fails -->
            <p style="color: red;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
            <div class="welcome">
                <h2>Welcome Back</h2>
                <h5>Enter your details</h5>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="input-group">
                <button type="submit">Log In</button>
            </div>

            <div class="input-group">
                <a href="register.php">Don't have an account? Register</a>
            </div>
        </form>
    </div>
</body>
</html>
