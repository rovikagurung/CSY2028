<?php
session_start();
include 'includes/db.php'; // Include your database connection file

// Check if auction ID is provided in the URL
if (!isset($_GET['id'])) {
    echo '<p>Auction ID not provided.</p>';
    include 'includes/footer.php';
    exit;
}

$auction_id = $_GET['id']; // Retrieve auction ID from URL parameter

// Fetch auction details from database
$stmt = $pdo->prepare('SELECT * FROM auctions WHERE id = ?');
$stmt->execute([$auction_id]);
$auction = $stmt->fetch(); // Fetch the auction details

// Check if auction exists
if (!$auction) {
    echo '<p>Auction not found.</p>';
    include 'includes/footer.php';
    exit;
}

// Check if logged-in user is the owner of the auction
if ($_SESSION['user_id'] !== $auction['user_id']) {
    echo '<p>You do not have permission to edit this auction.</p>';
    include 'includes/footer.php';
    exit;
}

// Handle form submission to update auction details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title']; // Retrieve and sanitize title from form input
    $description = $_POST['description']; // Retrieve and sanitize description from form input
    $current_price = $_POST['current_price']; // Retrieve and sanitize current_price from form input

    // Update the auction in the database
    $stmt = $pdo->prepare('UPDATE auctions SET title = ?, description = ?, current_price = ? WHERE id = ?');
    $stmt->execute([$title, $description, $current_price, $auction_id]);

    // Redirect to auction.php after update
    header('Location: auction.php?id=' . $auction_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Auction - <?php echo htmlspecialchars($auction['title']); ?></title>
    <link rel="stylesheet" href="css/form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <article class="car">
        <section>
            <h1>Edit Auction - <?php echo htmlspecialchars($auction['title']); ?></h1>
            <!-- Form to edit auction details -->
            <form action="editAuction.php?id=<?php echo $auction_id; ?>" method="post">
                <div class="input-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($auction['title']); ?>" required>
                </div>
                <div class="input-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($auction['description']); ?></textarea>
                </div>
                <div class="input-group">
                    <label for="current_price">Current Price:</label>
                    <input type="text" id="current_price" name="current_price" value="<?php echo htmlspecialchars($auction['current_price']); ?>" required>
                    <!-- Add more fields as needed for editing -->
                </div>
                <div class="input-group">
                    <input type="submit" value="Update Auction">
                </div>
            </form>
        </section>
    </article>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
