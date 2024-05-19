<?php
include 'includes/db.php'; // Ensure this includes your database connection

// Check if category ID is provided in the URL
if (!isset($_GET['id'])) {
    echo '<p>Category ID not provided.</p>';
    include 'includes/footer.php';
    exit;
}

$category_id = $_GET['id']; // Retrieve category ID from URL parameter

try {
    // Delete category from database
    $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
    $stmt->execute([$category_id]);

    // Check if deletion was successful
    if ($stmt->rowCount() > 0) {
        echo '<p>Category deleted successfully!</p>';
    } else {
        echo '<p>No category found with ID ' . $category_id . '</p>';
    }
} catch (PDOException $e) {
    // Handle database errors
    echo 'Error deleting category: ' . $e->getMessage();
}

// Redirect back to addCategory.php after deletion
header('Location: addCategory.php');
exit;
?>
