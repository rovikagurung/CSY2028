<?php
include 'includes/header.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}

$category_id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
$stmt->execute([$category_id]);
$category = $stmt->fetch();

if (!$category) {
    echo '<p>Category not found.</p>';
    include 'includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $stmt = $pdo->prepare('UPDATE categories SET name = ? WHERE id = ?');
    $stmt->execute([$name, $category_id]);
    header('Location: adminCategories.php');
    exit;
}
?>

<section>
    <h1>Edit Category</h1>
    <form action="editCategory.php?id=<?= $category_id ?>" method="post">
        <label for="name">Category Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($category['name']) ?>" required>
        <input type="submit" value="Update Category">
    </form>
</section>

<?php
include 'includes/footer.php';
?>
