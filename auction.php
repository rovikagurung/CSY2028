<?php
session_start();
include 'includes/db.php'; // Include your database connection file

// Fetch auction details
if (isset($_GET['id'])) {
    $auction_id = $_GET['id'];

    // Fetch auction details from database
    $stmt = $pdo->prepare('SELECT * FROM auctions WHERE id = ?');
    $stmt->execute([$auction_id]);
    $auction = $stmt->fetch();

    // Check if auction exists
    if (!$auction) {
        die("Auction not found.");
    }

    // Fetch bids for the auction
    $bids_query = $pdo->prepare("SELECT * FROM bids WHERE auction_id = ? ORDER BY bid_amount DESC");
    $bids_query->execute([$auction_id]);
    $bids = $bids_query->fetchAll();

    // Fetch reviews for the auction
    $reviews_query = $pdo->prepare("SELECT * FROM reviews WHERE auction_id = ? ORDER BY review_date DESC");
    $reviews_query->execute([$auction_id]);
    $reviews = $reviews_query->fetchAll();

    // Check if the logged-in user is the owner of the auction
    $isOwner = isset($_SESSION['user_id']) && $_SESSION['user_id'] === $auction['user_id'];
} else {
    die("Auction ID not provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($auction['title']); ?> - Auction Details</title>
    <link rel="stylesheet" href="css/auction.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <section>
    <article class="car">
        <!-- Auction details -->
        <img class="img-car" src="images/auctions/<?php echo htmlspecialchars($auction['image']); ?>" alt="<?php echo htmlspecialchars($auction['title']); ?>">
        <div class="details">
            <h1><?php echo htmlspecialchars($auction['title']); ?></h1>
            <p><?php echo htmlspecialchars($auction['description']); ?></p>
            <?php if (isset($auction['starting_price'])): ?>
                <p class="price">Starting Price: $<?php echo htmlspecialchars($auction['starting_price']); ?></p>
            <?php endif; ?>
            <p class="price">Current Price: $<?php echo htmlspecialchars($auction['current_price']); ?></p>
            <time datetime="<?php echo htmlspecialchars($auction['end_date']); ?>">Ends on: <?php echo htmlspecialchars($auction['end_date']); ?></time>
        </div>

        <!-- Display long description if available -->
        <?php if (isset($auction['long_description'])): ?>
            <div class="description">
                <h2>Description</h2>
                <p><?php echo htmlspecialchars($auction['long_description']); ?></p>
            </div>
        <?php endif; ?>

        <!-- Display Edit Auction button if user is the owner -->
        <?php if ($isOwner): ?>
            <div class="edit">
                <form action="editAuction.php" method="get">
                    <div class="input-group">
                        <input type="hidden" name="id" value="<?php echo $auction_id; ?>">
                        <input type="submit" value="Edit Auction">
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <!-- Display bids section -->
        <div class="bids">
            <h1>Bids</h1>
            <ul>
                <?php foreach ($bids as $bid): ?>
                    <li>
                        <p>Bid Amount: $<?php echo htmlspecialchars($bid['bid_amount']); ?></p>
                        <time datetime="<?php echo htmlspecialchars($bid['bid_time']); ?>"><?php echo htmlspecialchars($bid['bid_time']); ?></time>
                        <p>By User ID: <?php echo htmlspecialchars($bid['user_id']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
            
            <!-- Allow logged-in users (not the auction owner) to place bids -->
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== $auction['user_id']): ?>
                <form action="placeBid.php" method="post">
                    <h1>Place a Bid</h1>
                    <div class="input-group">
                        <label for="bid_amount">Bid Amount:</label>
                        <input type="number" id="bid_amount" name="bid_amount" step="0.01" min="<?php echo $auction['current_price'] + 0.01; ?>" required>
                        <input type="hidden" name="auction_id" value="<?php echo $auction_id; ?>"><br><br>
                        <input type="submit" value="Place Bid">
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <!-- Display reviews section -->
        <div class="reviews">
            <h1>Reviews</h1>
            <ul>
                <?php foreach ($reviews as $review): ?>
                    <li>
                        <p><?php echo htmlspecialchars($review['reviewText']); ?></p>
                        <time datetime="<?php echo htmlspecialchars($review['review_date']); ?>"><?php echo htmlspecialchars($review['review_date']); ?></time>
                        <p>By: <?php echo htmlspecialchars($review['user_name']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Allow logged-in users to leave reviews -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="review.php" method="post">
                    <h1>Leave a Review</h1>
                    <div class="input-group">
                        <label for="reviewText">Review:</label>
                        <textarea id="reviewText" name="reviewText" required></textarea>
                        <input type="hidden" name="auction_id" value="<?php echo $auction_id; ?>">
                    </div>
                    <div class="input-group">
                        <input type="submit" value="Submit Review">
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </article>
    </section>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
