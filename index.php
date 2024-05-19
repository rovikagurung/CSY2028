<?php
// Include the database connection file
include 'includes/db.php';

// Include the header file
include 'includes/header.php';

// Fetch the 10 most recently added auctions from the database
$stmt = $pdo->query('SELECT * FROM auctions ORDER BY end_date DESC LIMIT 10');
$auctions = $stmt->fetchAll(); // Fetch all results as an associative array
?>
<main>
<section class="section">
    <h1>Latest Car Listings</h1>
    <ul class="carList">
        <!-- Loop through each auction and display its details -->
        <?php foreach ($auctions as $auction): ?>
            <li>
                <!-- Display the auction image -->
                <img src="images/auctions/<?= htmlspecialchars($auction['image']) ?>" alt="<?= htmlspecialchars($auction['title']) ?>">
                <article>
                    <!-- Display the auction title -->
                    <h2><?= htmlspecialchars($auction['title']) ?></h2>
                    <!-- Display the auction description -->
                    <h3><?= htmlspecialchars($auction['description']) ?></h3>
                    <!-- Display the auction end date -->
                    <p class="price">Ends on: <?= htmlspecialchars($auction['end_date']) ?></p><br>
                    <!-- Link to the auction details page -->
                    <a class="more auctionLink" href="auction.php?id=<?= $auction['id'] ?>">More</a><br>
                </article>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
</main>

<?php
// Include the footer file
include 'includes/footer.php';
?>
