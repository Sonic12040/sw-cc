<?php

function tokenAwarePhraseMatch(string $normalized, string $keyword): bool {
    $keyword = trim($keyword);
    if ($keyword === '') {
        return false;
    }

    $escapedKeyword = preg_quote($keyword, '/');
    $pattern = '/(?:^|[^a-z0-9])' . $escapedKeyword . '(?=$|[^a-z0-9])/i';

    return preg_match($pattern, $normalized) === 1;
}

function keywordIsExcluded(string $normalized, string $keyword, array $keywordExclusions): bool {
    if (!isset($keywordExclusions[$keyword])) {
        return false;
    }

    foreach ($keywordExclusions[$keyword] as $excludedPhrase) {
        if (tokenAwarePhraseMatch($normalized, $excludedPhrase)) {
            return true;
        }
    }

    return false;
}

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
            'smarties',
            'tootsie',
            'bit o honey',
            'cinnamon candy',
            'send more candy',
            'extra bags of candy',
            'hard candy',
            'gummy candy',
            'peppermints',
            'candy bar',
            'sweet treat',
            'sweet tooth',
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
            'comunicarse',
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

    $keywordExclusions = [
        'sweet' => ['sweetwater', "that'd be sweet", 'that would be sweet', 'it would be sweet', 'be sweet'],
        'candy' => ['promo', 'sticker', 'stickers'],
    ];

    $matchedAnyCategory = false;

    foreach ($keywordsByCategory as $category => $keywords) {
        foreach ($keywords as $keyword) {
            if (keywordIsExcluded($normalized, $keyword, $keywordExclusions)) {
                continue;
            }

            if (tokenAwarePhraseMatch($normalized, $keyword)) {
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
