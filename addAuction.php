<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $categoryId = $_POST['category'];
    $endDate = $_POST['endDate'];
    $userId = $_SESSION['user_id'];

    // Handle the image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // Check file size (5MB limit)
    if ($_FILES["image"]["size"] > 5000000) {
        die("Sorry, your file is too large.");
    }

    // Allow certain file formats
    $allowedFormats = array("jpg", "png", "jpeg", "gif");
    if (!in_array($imageFileType, $allowedFormats)) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Move the file to the target directory
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
    }

    try {
        // Insert the auction details along with the image path
        $stmt = $pdo->prepare('INSERT INTO auction (title, description, categoryId, endDate, userId, imagePath) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$title, $description, $categoryId, $endDate, $userId, $target_file]);
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Auction</title>
    <link rel="stylesheet" href="carbuy.css">
</head>
<body>
    <h2>Add Auction</h2>
    <form action="addAuction.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>
        
        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <?php
            $stmt = $pdo->query('SELECT * FROM category');
            while ($row = $stmt->fetch()) {
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
            ?>
        </select>
        
        <label for="endDate">End Date:</label>
        <input type="date" id="endDate" name="endDate" required><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br>
        
        <button type="submit">Add Auction</button>
    </form>
</body>
</html>

<?php
include 'includes/footer.php';
?>
