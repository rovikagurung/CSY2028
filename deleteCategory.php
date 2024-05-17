<?php
include 'includes/header.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}

$category_id = $_GET['id'];

$stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
$stmt->execute([$category_id]);

header('Location: adminCategories.php');
exit;
?>
