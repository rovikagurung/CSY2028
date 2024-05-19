<?php
// Database connection settings
$host = '127.0.0.1'; // The hostname of the database server
$db = 'assignment1'; // The name of the database
$user = 'root'; // The database username
$pass = ''; // The database password (empty in this case)
$charset = 'utf8mb4'; // The character set for the database connection

// Data Source Name (DSN) specifying the database to connect to
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Options for the PDO connection
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions for error handling
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Set default fetch mode to associative array
    PDO::ATTR_EMULATE_PREPARES   => false, // Disable emulation of prepared statements for security
];

try {
    // Create a new PDO instance (database connection)
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Handle any errors during connection by throwing an exception with the error message and code
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
