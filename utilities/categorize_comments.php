<?php

function categorizeComments(
    string $normalized,
    string $safeComment,
    array &$categorizedComments,
): void {
    $keywordsByCategory = [
        'Candy Comments' => [
            'candy',
            'chocolate',
            'lollipop',
            'taffy',
            'sweets',
            'sweet',
            'smarties',
            'tootsie',
            'bit o honey',
            'cinnamon candy',
            'send more candy',
            'extra bags of candy',
        ],
        "Call Me / Don't Call Me Comments" => [
            'call me',
            'call me on this number',
            'please call',
            'phone',
            'phone call',
            'no phone call',
            'dont call',
            'do not call',
            'do not cancel',
            'text me',
            'mobile',
            'ring',
            'call when',
            'contact me',
            'please contact me',
            'email is sufficient',
            'do not call me',
            'no sales calls',
            'comunicarse'
        ],
        'Referral Comments' => [
            'internet search',
            'heard about',
            'heard about you',
            'referred',
            'referral',
            'googled',
            'google',
            'recommended by',
            'friend told me',
            'sent me',
            'my sales rep',
            'sales engineer',
            'sales rep',
            'sales person',
            'my professor',
            'my friend',
            'my music instructor',
            'customer of',
            'long time customer',
            'previous customer',
            'through the discord server',
            'reddit',
            'youtube',
            'church',
        ],
        'Signature Requirements Comments' => [
            'signature',
            'sign for',
            'adult signature',
            'no signature',
            'signature required',
            'waive signature',
            'do not require signature',
            'signature requirement',
            'leave at the door',
            'do not need a signature',
            'no signature required',
            'please waive the signature',
            'signature is required',
            'no signature is required',
        ],
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
