<?php
include 'includes/header.php';

// Redirect non-admin users to index.php
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}

// Fetch categories for management
$stmt = $pdo->query('SELECT * FROM categories');
$categories = $stmt->fetchAll();
?>

<section>
    <h1>Manage Categories</h1>
    <a href="addCategory.php">Add Category</a> <!-- Link to addCategory.php for adding new categories -->
    <ul>
        <?php foreach ($categories as $category): ?>
            <li>
                <?= htmlspecialchars($category['name']) ?> <!-- Display category name safely -->
                <a href="editCategory.php?id=<?= $category['id'] ?>">Edit</a> <!-- Link to editCategory.php with category ID for editing -->
                <a href="deleteCategory.php?id=<?= $category['id'] ?>">Delete</a> <!-- Link to deleteCategory.php with category ID for deletion -->
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<?php
include 'includes/footer.php';
?>
