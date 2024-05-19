<?php
include 'includes/header.php';
include 'includes/db.php'; // Ensure this includes your database connection

// Function to fetch all categories from the database
function getAllCategories($pdo) {
    $stmt = $pdo->query('SELECT * FROM categories');
    return $stmt->fetchAll();
}

// Add category if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    // Validate and sanitize input (you can add more validation as needed)
    $name = htmlspecialchars(trim($name));

    // Insert into database
    try {
        $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
        $stmt->execute([$name]);
        // Optionally, you can add a success message or redirect to another page
        echo '<p>Category added successfully!</p>';
    } catch (PDOException $e) {
        // Handle database errors
        echo 'Error: ' . $e->getMessage();
    }
}

// Fetch all categories from the database
$categories = getAllCategories($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
    <link rel="stylesheet" href="css/form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<section>
    <h1>Add Category</h1>
    <form action="addCategory.php" method="post">
        <div class="input-group">
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" required><br><br>
            <input type="submit" value="Add Category">
        </div>
    </form>
</section>

<section>
    <h1>Manage Categories</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td data-label="ID"><?php echo htmlspecialchars($category['id']); ?></td>
                    <td data-label="Name"><?php echo htmlspecialchars($category['name']); ?></td>
                    <td data-label="Action">
                        <a href="editCategory.php?id=<?php echo $category['id']; ?>">Edit</a>
                        <a href="deleteCategory.php?id=<?php echo $category['id']; ?>" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
</body>
</html>

<?php
include 'includes/footer.php';
?>
