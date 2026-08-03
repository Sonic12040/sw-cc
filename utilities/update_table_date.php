<?php

function updateTableDate(PDO $pdo, array $row): void {
    $comment = (string) ($row['comments'] ?? '');
    $normalized = strtolower($comment);
    $datePattern = '/\b(?:expected ship date)\s*[:\-]?\s*(\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4})\b/i';

    if (!preg_match($datePattern, $normalized, $matches)) {
        return;
    }

    $expectedShipDate = $matches[1];
    $dateParts = preg_split('/[\/\-]/', $expectedShipDate);

    if (count($dateParts) === 3) {
        [$month, $day, $year] = $dateParts;

        if (strlen($year) === 2) {
            $year = '20' . $year;
        }

        $expectedShipDate = sprintf('%04d-%02d-%02d', (int) $year, (int) $month, (int) $day);
    }

    $updateStmt = $pdo->prepare(
        'UPDATE sweetwater_test SET shipdate_expected = :shipdate_expected WHERE orderid = :orderid'
    );

    $updateStmt->execute([
        ':shipdate_expected' => $expectedShipDate,
        ':orderid' => $row['orderid'],
    ]);
}
