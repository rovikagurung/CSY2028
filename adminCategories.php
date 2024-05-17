<?php
include 'includes/header.php';

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
    <a href="addCategory.php">Add Category</a>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li>
                <?= htmlspecialchars($category['name']) ?>
                <a href="editCategory.php?id=<?= $category['id'] ?>">Edit</a>
                <a href="deleteCategory.php?id=<?= $category['id'] ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<?php
include 'includes/footer.php';
?>
