<?php
// Start the session to access session variables
session_start();

// Include the database connection file
include 'includes/db.php';

// Check if the request method is POST, indicating form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in, and required POST variables are not empty
    if (isset($_SESSION['user_id']) && !empty($_POST['reviewText']) && !empty($_POST['auction_id'])) {
        // Retrieve the review text and auction ID from the POST data
        $reviewText = $_POST['reviewText'];
        $auction_id = $_POST['auction_id'];
        // Get the user ID from the session
        $user_id = $_SESSION['user_id'];

        // Fetch the user's name from the users table
        $user_query = $pdo->prepare("SELECT name FROM users WHERE id = ?");
        $user_query->execute([$user_id]);
        $user = $user_query->fetch();

        // Insert the review into the reviews table in the database
        $review_query = $pdo->prepare("INSERT INTO reviews (auction_id, user_id, user_name, reviewText, review_date) VALUES (?, ?, ?, ?, NOW())");
        $review_query->execute([$auction_id, $user_id, $user['name'], $reviewText]);

        // Redirect to the auction page with the given auction ID
        header("Location: auction.php?id=" . $auction_id);
        exit();
    } else {
        // If validation fails, redirect back to the auction page with the given auction ID
        header("Location: auction.php?id=" . $_POST['auction_id']);
        exit();
    }
}
?>
