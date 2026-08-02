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
// category regex patterns
$candy_regex = '/\\b(candy|chocolate|lollipop|taffy|sweet|bit o honey)\\b/i';
$call_regex = '/\\b(call me|dont call|do not call|text me|phone|mobile|ring)\\b/i';
$referral_regex = '/\\b(internet search|heard about|referred|googled|referral|recommended by|friend told me|sent me)\\b/i';
$signature_regex = '/\\b(signature|sign for|adult signature)\\b/i';

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
        $matchedAnyCategory = false;

        if (preg_match($candy_regex, $normalized) === 1) {
            $categorizedComments['Candy Comments'][] = $safeComment;
            $matchedAnyCategory = true;
        }
        // no else because a comment can match multiple categories
        if (preg_match($call_regex, $normalized) === 1) {
            $categorizedComments["Call Me / Don't Call Me Comments"][] = $safeComment;
            $matchedAnyCategory = true;
        }

        if (preg_match($referral_regex, $normalized) === 1) {
            $categorizedComments['Referral Comments'][] = $safeComment;
            $matchedAnyCategory = true;
        }

        if (preg_match($signature_regex, $normalized) === 1) {
            $categorizedComments['Signature Requirements Comments'][] = $safeComment;
            $matchedAnyCategory = true;
        }

        if (!$matchedAnyCategory) {
            $categorizedComments['Miscellaneous Comments'][] = $safeComment;
        }
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






