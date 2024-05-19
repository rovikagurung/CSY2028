<?php
// Start the session and destroy it to log the user out
session_start();
session_destroy();

// Redirect the user to the index.php page after logout
header('Location: index.php');
exit; // Ensure no further code is executed after redirection
?>
