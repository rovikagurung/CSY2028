<?php
// Include the database connection file
include 'includes/db.php';

// Check if the form is submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data from POST variables
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $name = $_POST['name'];

    try {
        // Prepare SQL statement to insert user data into the users table
        $stmt = $pdo->prepare('INSERT INTO users (email, password, name) VALUES (?, ?, ?)');
        // Execute the SQL statement with the provided values
        $stmt->execute([$email, $password, $name]);

        // Registration successful message and redirection to login page
        $successMessage = "Registration successful!";
        header('Location: login.php');
        exit(); // Ensure no further code is executed after redirection
    } catch (PDOException $e) {
        // If an error occurs during database operation, display an error message
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css" />
    <title>Registration</title>
</head>
<body>
    <div class="container">
        <form action="register.php" method="post">
            <div class="logo">
                <a href="index.php">
                    <h1><span class="c">C</span>
                    <span class="a">a</span>
                    <span class="r">r</span>
                    <span class="b">b</span>
                    <span class="u">u</span>
                    <span class="y">y</span></h1>
                </a>
            </div>

            <?php if (isset($errorMessage)): ?>
            <!-- Display error message if registration fails -->
            <p style="color: red;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>

            <div class="input-group">
                <label for="name">Username</label>
                <input type="text" id="name" name="name" required>
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
                <button type="submit">Register</button>
            </div>

            <div class="input-group">
                <a href="login.php">Already have an account? Log In</a>
            </div>
        </form>
    </div>
</body>
</html>
