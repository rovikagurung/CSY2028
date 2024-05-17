<?php
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$auction_id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM auctions WHERE id = ? AND user_id = ?');
$stmt->execute([$auction_id, $_SESSION['user_id']]);
$auction = $stmt->fetch();

if (!$auction) {
    echo '<p>Auction not found or you do not have permission to edit this auction.</p>';
    include 'includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category'];
    $end_date = $_POST['end_date'];

    // Handle image upload
    $image = $auction['image'];
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "images/auctions/$image");
    }

    $stmt = $pdo->prepare('UPDATE auctions SET title = ?, description = ?, category_id = ?, end_date = ?, image = ? WHERE id = ? AND user_id = ?');
    $stmt->execute([$title, $description, $category_id, $end_date, $image, $auction_id, $_SESSION['user_id']]);

    header('Location: auction.php?id=' . $auction_id);
    exit;
}

// Fetch categories for the select dropdown
$stmt = $pdo->query('SELECT * FROM categories');
$categories = $stmt->fetchAll();
?>

<section>
    <h1>Edit Auction</h1>
    <form action="editAuction.php?id=<?= $auction_id ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($auction['title']) ?>" required>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($auction['description']) ?></textarea>
        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= $category['id'] == $auction['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <label for="end_date">End Date:</label>
        <input type="datetime-local" id="end_date" name="end_date" value="<?= date('Y-m-d\TH:i', strtotime($auction['end_date'])) ?>" required>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
        <input type="submit" value="Update Auction">
        <a href="deleteAuction.php?id=<?= $auction_id ?>" class="delete">Delete Auction</a>
    </form>
</section>

<?php
include 'includes/footer.php';
?>
