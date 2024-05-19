<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files
include 'includes/header.php';
include 'includes/db.php'; // Ensure this includes your database connection

// Specify the directory where images should be uploaded
$upload_directory = "images/auctions/";

// Handle form submission for adding an auction
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category'];
    $end_date = $_POST['end_date'];
    $current_price = $_POST['current_price'];
    $user_id = $_SESSION['user_id'];

    // Handle image upload
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = basename($_FILES['image']['name']);
        $target_file = $upload_directory . $image;

        // Move uploaded file to destination directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            chmod($target_file, 0644); // Set appropriate permissions for the uploaded file
            echo "File uploaded successfully: $target_file";
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "Error during file upload: " . $_FILES['image']['error'];
    }

    // Insert auction details into the database
    $stmt = $pdo->prepare('INSERT INTO auctions (title, description, category_id, user_id, end_date, image, current_price) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$title, $description, $category_id, $user_id, $end_date, $image, $current_price]);

    // Redirect to the homepage after adding the auction
    header('Location: index.php');
    exit;
}

// Fetch categories for the select dropdown
$stmt = $pdo->query('SELECT * FROM categories');
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Auction</title>
    <link rel="stylesheet" href="css/form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<section>
    <h1>Add Auction</h1>
    <form action="addAuction.php" method="post" enctype="multipart/form-data">
        <div class="input-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="input-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div class="input-group">
            <label for="current_price">Current Price:</label>
            <input type="text" id="current_price" name="current_price" required>
        </div>
        <div class="input-group">
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <a class="add" href="addCategory.php">+</a> <!-- Link to add new category -->
        </div>
        <div class="input-group">
            <label for="end_date">End Date:</label>
            <input type="datetime-local" id="end_date" name="end_date" required>
        </div>
        <div class="input-group">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
        <div class="input-group">
            <input type="submit" value="Add Auction">
        </div>
    </form>
</section>
</body>
</html>

<?php
include 'includes/footer.php';
?>
