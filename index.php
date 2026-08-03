<?php

// database variables
$host = 'localhost';
$db = 'sweetwater';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$charset = 'utf8mb4';
$data_source_name = "mysql:host=$host;dbname=$db;charset=$charset";
// comment categories
$categorizedComments = [
    'Candy Comments' => [],
    "Call Me / Don't Call Me Comments" => [],
    'Referral Comments' => [],
    'Signature Requirements Comments' => [],
    'Miscellaneous Comments' => [],
];
require_once __DIR__ . '/utilities/categorize_comments.php';

// options for the PDO connection
$options = [
    // error mode - stricter checking
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // fetch mode - memory efficiency
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // emulation off - security
    PDO::ATTR_EMULATE_PREPARES => false,
];

echo "<h1>Sweetwater Comments</h1>";
try {
    $pdo = new PDO($data_source_name, $user, $pass, $options);
    $stmt = $pdo->query("SELECT * FROM sweetwater_test");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $comment = (string) ($row['comments'] ?? '');
        // normalization of characters and whitespace
        $safeComment = nl2br(htmlspecialchars(trim($comment), ENT_QUOTES, 'UTF-8'));
        $normalized = strtolower($comment);
        categorizeComments(
            $normalized,
            $safeComment,
            $categorizedComments,
        );
    }
    

    foreach ($categorizedComments as $heading => $comments) {
        echo '<h2>' . htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') . '</h2>';

        if (empty($comments)) {
            echo '<p><em>No comments in this category.</em></p>';
            continue;
        }

        foreach ($comments as $commentHtml) {
            echo '<p>' . $commentHtml . '</p>';
        }
    }

} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}






