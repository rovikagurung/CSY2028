<?php
include 'includes/header.php';

// Fetch the 10 most recently added auctions
$stmt = $pdo->query('SELECT * FROM auctions ORDER BY end_date DESC LIMIT 10');
$auctions = $stmt->fetchAll();
?>

<section>
    <h1>Latest Car Listings</h1>
    <ul class="carList">
        <?php foreach ($auctions as $auction): ?>
            <li>
                <img src="images/auctions/<?= htmlspecialchars($auction['image']) ?>" alt="<?= htmlspecialchars($auction['title']) ?>">
                <article>
                    <h2><?= htmlspecialchars($auction['title']) ?></h2>
                    <h3><?= htmlspecialchars($auction['description']) ?></h3>
                    <p class="price">Ends on: <?= htmlspecialchars($auction['end_date']) ?></p>
                    <a class="more auctionLink" href="auction.php?id=<?= $auction['id'] ?>">More >></a>
                </article>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<?php
include 'includes/footer.php';
?>
