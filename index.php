<?php

function ensureRequiredColumns(PDO $pdo, string $tableName, array $requiredColumns): void {
    $columnsStmt = $pdo->query("SHOW COLUMNS FROM `{$tableName}`");
    $existingColumns = $columnsStmt->fetchAll(PDO::FETCH_COLUMN, 0);
    $missingColumns = array_values(array_diff($requiredColumns, $existingColumns));

    if ($missingColumns !== []) {
        throw new RuntimeException(
            sprintf(
                'Schema validation failed for table "%s": missing required columns: %s',
                $tableName,
                implode(', ', $missingColumns)
            )
        );
    }
}

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
require_once __DIR__ . '/utilities/render_comments.php';
require_once __DIR__ . '/utilities/update_table_date.php';

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
    ensureRequiredColumns($pdo, 'sweetwater_test', ['orderid', 'comments', 'shipdate_expected']);

    $stmt = $pdo->query(
        'SELECT orderid, comments, shipdate_expected FROM sweetwater_test'
    );
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $comment = (string) ($row['comments'] ?? '');
        // normalization of characters and whitespace
        $safeComment = nl2br(htmlspecialchars(trim($comment), ENT_QUOTES, 'UTF-8'));
        $normalized = strtolower($comment);
        categorizeComments(
            $normalized,
            $safeComment,
            $categorizedComments,
        );
        updateTableDate($pdo, $row);
    }

    renderComments($categorizedComments);

    echo "<h2>Database Results</h2>";
    $stmt = $pdo->query(
        'SELECT orderid, comments, shipdate_expected FROM sweetwater_test'
    );
    echo "<table border='1'>";
    echo "<tr><th>Order ID</th><th>Comments</th><th>Expected Ship Date</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['orderid'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['comments'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($row['shipdate_expected'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "</tr>";
    }
    echo "</table>";

} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int) $e->getCode());
} catch (RuntimeException $e) {
    echo '<p><strong>Schema validation error:</strong> ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
    exit(1);
}






