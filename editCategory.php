<?php
// Include the header file to maintain consistent UI
include 'includes/header.php';

// Include the database connection file
include 'includes/db.php'; // Ensure this includes your database connection

// Check if category ID is provided in the URL
if (!isset($_GET['id'])) {
    echo '<p>Category ID not provided.</p>';
    include 'includes/footer.php';
    exit; // Stop further execution if category ID is not provided
}

$category_id = $_GET['id']; // Retrieve category ID from URL parameter

// Fetch category details from the database
$stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
$stmt->execute([$category_id]);
$category = $stmt->fetch(); // Fetch the category row

// Check if category exists
if (!$category) {
    echo '<p>Category not found.</p>';
    include 'includes/footer.php';
    exit; // Stop further execution if category is not found
}

// Update category if form is submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name']; // Retrieve and sanitize category name from form input

    // Validate and sanitize input (you can add more validation as needed)
    $name = htmlspecialchars(trim($name));

    // Update category in the database
    try {
        $stmt = $pdo->prepare('UPDATE categories SET name = ? WHERE id = ?');
        $stmt->execute([$name, $category_id]);
        echo '<p>Category updated successfully!</p>'; // Display success message upon successful update
    } catch (PDOException $e) {
        // Handle database errors
        echo 'Error: ' . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Category - <?php echo htmlspecialchars($category['name']); ?></title>
    <link rel="stylesheet" href="css/form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<section>
    <h1>Edit Category</h1>
    <!-- Form to edit category details -->
    <form action="editCategory.php?id=<?php echo $category_id; ?>" method="post">
        <div class="input-group">
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
        </div>
        <div class="input-group">
            <input type="submit" value="Update Category">
        </div>
    </form>
</section>
</body>
</html>

<?php
// Include the footer file to maintain consistent UI
include 'includes/footer.php';
?>
