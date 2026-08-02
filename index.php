<?php

// database variables
$host = 'localhost';
$db = 'sweetwater';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$charset = 'utf8mb4';
$data_source_name = "mysql:host=$host;dbname=$db;charset=$charset";

// options for the PDO connection
$options = [
    // error mode - stricter checking
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // fetch mode - memory efficiency
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // emulation off - security
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($data_source_name, $user, $pass, $options);
    echo "Connected to the database successfully.";
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

// Start a connection to the MySQL database, prompting for credentials.

// Query the database for the rows in the sweetwater table.
// Following the readme, the table should be known.

// Display an <h1> header with the text "Sweetwater Comments".

echo "<h1>Sweetwater Comments</h1>";

// Generate an <h2> header for each comment, displaying the comment's category.
// Categories are "comments about candy", comments about call me / don't call me, comments about who referred me, comments about signature requirements on delivery, and miscellaneous comments (comments that don't match other categories).

