<?php
// Start the session to access session variables
session_start();
include 'includes/header.php';
// Include the database connection file
include 'includes/db.php'; // Ensure this includes your database connection

// Check if the request method is POST and user is logged in
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    // Retrieve auction ID, bid amount, and user ID from POST data
    $auction_id = $_POST['auction_id'];
    $bid_amount = $_POST['bid_amount'];
    $user_id = $_SESSION['user_id'];
    $current_time = date('Y-m-d H:i:s'); // Current date and time

    try {
        // Check if the auction exists in the database
        $auction_query = $pdo->prepare("SELECT * FROM auctions WHERE id = ?");
        $auction_query->execute([$auction_id]);
        $auction = $auction_query->fetch();

        // If auction not found, terminate with an error message
        if (!$auction) {
            die("Auction not found.");
        }

        // Check if bid amount is higher than the current price (if current_price column exists)
        if (isset($auction['current_price']) && $bid_amount > $auction['current_price']) {
            // Insert bid into bids table
            $stmt = $pdo->prepare('INSERT INTO bids (auction_id, user_id, bid_amount, bid_time) VALUES (?, ?, ?, ?)');
            $stmt->execute([$auction_id, $user_id, $bid_amount, $current_time]);

            // Update auction current price
            $stmt_update = $pdo->prepare('UPDATE auctions SET current_price = ? WHERE id = ?');
            $stmt_update->execute([$bid_amount, $auction_id]);

            // Display success message
            echo '<p>Bid placed successfully!</p>';
        } else {
            // Display error message if bid amount is not higher than current price
            echo '<p>Bid amount must be higher than current price.</p>';
        }
    } catch (PDOException $e) {
        // Display error message if there's an issue with database operations
        echo 'Error placing bid: ' . $e->getMessage();
    }
} else {
    // Display error message for unauthorized access or missing parameters
    echo '<p>Unauthorized access or missing parameters.</p>';
}
?>
