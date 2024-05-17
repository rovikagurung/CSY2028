<?php
include 'includes/header.php';

$search = $_GET['search'] ?? '';

$stmt = $pdo->prepare('SELECT * FROM auctions WHERE title LIKE ? OR description LIKE ?');
$stmt->execute(['%' . $search . '%', '%' . $search . '%']);
$auctions = $stmt->fetchAll();
?>

<section>
    <h1>Search Results</h1>
    <ul class="carList">
        <?php foreach ($auctions as $auction): ?>
            <li class="car">
                <h2><?= htmlspecialchars($auction['title']) ?></h2>
                <p><?= htmlspecialchars($auction['description']) ?></p>
                <a class="more auctionLink" href="auction.php?id=<?= $auction['id'] ?>">More</a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<?php
include 'includes/footer.php';
?>
