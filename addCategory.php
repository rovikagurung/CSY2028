<?php
include 'includes/header.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
    $stmt->execute([$name]);
    header('Location: adminCategories.php');
    exit;
}
?>

<section>
    <h1>Add Category</h1>
    <form action="addCategory.php" method="post">
        <label for="name">Category Name:</label>
        <input type="text" id="name" name="name" required>
        <input type="submit" value="Add Category">
    </form>
</section>

<?php
include 'includes/footer.php';
?>
