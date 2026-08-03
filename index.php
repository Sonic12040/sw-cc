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
require_once __DIR__ . '/utilities/render_comments.php';

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
        // parse if a comment has an expected shipping date
        $date_pattern = '/\b(?:expected ship date)\s*[:\-]?\s*(\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4})\b/i';
        // if there is a date, parse the date out and update the SQL database with the expected shipping date
        if (preg_match($date_pattern, $normalized, $matches)) {
            $expectedShipDate = $matches[1];
            // added logic because the original date format was submitting everything as showing from 2001 instead of 2018).
            $dateParts = preg_split('/[\/\-]/', $expectedShipDate);

            if (count($dateParts) === 3) {
                [$month, $day, $year] = $dateParts;

                if (strlen($year) === 2) {
                    $year = '20' . $year;
                }

                $expectedShipDate = sprintf('%04d-%02d-%02d', (int) $year, (int) $month, (int) $day);
            }

            // update the database with the expected shipping date
            $updateStmt = $pdo->prepare("UPDATE sweetwater_test SET shipdate_expected = :shipdate_expected WHERE orderid = :orderid");
            $updateStmt->execute([
                ':shipdate_expected' => $expectedShipDate,
                ':orderid' => $row['orderid'],
            ]);
        }
    }
    

    renderComments($categorizedComments);

} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}






