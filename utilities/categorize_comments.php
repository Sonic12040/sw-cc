<?php



function categorizeComments(
    string $normalized,
    string $safeComment,
    array &$categorizedComments,
): void {
    $candy_regex = '/\\b(candy|chocolate|lollipop|taffy|sweets|bit o honey)\\b/i';
    $call_regex = '/\\b(call me|dont call|do not call|text me|phone|mobile|ring)\\b/i';
    $referral_regex = '/\\b(internet search|heard about|referred|googled|referral|recommended by|friend told me|sent me)\\b/i';
    $signature_regex = '/\\b(signature|sign for|adult signature)\\b/i';
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
