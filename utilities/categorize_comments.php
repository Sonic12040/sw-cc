<?php

function categorizeComments(
    string $normalized,
    string $safeComment,
    array &$categorizedComments,
): void {
    $keywordsByCategory = [
        'Candy Comments' => ['candy', 'chocolate', 'lollipop', 'taffy', 'sweets', 'bit o honey'],
        "Call Me / Don't Call Me Comments" => ['call me', 'dont call', 'do not call', 'text me', 'phone', 'mobile', 'ring'],
        'Referral Comments' => ['internet search', 'heard about', 'referred', 'googled', 'referral', 'recommended by', 'friend told me', 'sent me'],
        'Signature Requirements Comments' => ['signature', 'sign for', 'adult signature'],
    ];

    $matchedAnyCategory = false;

    foreach ($keywordsByCategory as $category => $keywords) {
        foreach ($keywords as $keyword) {
            if (stripos($normalized, $keyword) !== false) {
                $categorizedComments[$category][] = $safeComment;
                $matchedAnyCategory = true;
                break;
            }
        }
    }

    if (!$matchedAnyCategory) {
        $categorizedComments['Miscellaneous Comments'][] = $safeComment;
    }
}
