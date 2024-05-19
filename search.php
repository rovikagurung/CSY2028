<?php
// Include the database connection file
include 'includes/db.php'; // Adjust the path as per your file structure

// Include the header file for consistent UI
include 'includes/header.php';

// Check if the search query parameter is set
$search = $_GET['search'] ?? '';

try {
    // Prepare SQL query to search in the auctions table for title or description matching the search term
    $stmt = $pdo->prepare('SELECT * FROM auctions WHERE title LIKE ? OR description LIKE ?');
    // Execute the query with the search term wrapped in wildcards for partial matching
    $stmt->execute(['%' . $search . '%', '%' . $search . '%']);
    // Fetch all matching results as an associative array
    $auctions = $stmt->fetchAll();
} catch (PDOException $e) {
    // Handle database errors by displaying an error message and exiting the script
    echo 'Error: ' . $e->getMessage();
    exit; // Exit the script on error
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="css/form.css">
</head>
<body>

<section>
    <h1>Search Results</h1>
    <ul class="carList">
        <!-- Loop through each auction and display its details if any results are found -->
        <?php foreach ($auctions as $auction): ?>
            <li class="car">
                <!-- Display the auction title -->
                <h2><?= htmlspecialchars($auction['title']) ?></h2>
                <!-- Display the auction description -->
                <p><?= htmlspecialchars($auction['description']) ?></p>
                <div class="input-group">
                    <!-- Link to the auction details page -->
                    <a class="more auctionLink" href="auction.php?id=<?= $auction['id'] ?>">More</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<!-- Include the footer file for consistent UI -->
<?php include 'includes/footer.php'; ?>

</body>
</html>
