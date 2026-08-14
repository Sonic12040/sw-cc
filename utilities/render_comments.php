<?php

function renderComments(array $categorizedComments): void {
    foreach ($categorizedComments as $heading => $comments) {
        echo '<details>';
        echo '<summary>' . htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') . '</summary>';

        if (empty($comments)) {
            echo '<p><em>No comments in this category.</em></p>';
            echo '</details>';
            continue;
        }

        foreach ($comments as $commentHtml) {
            echo '<p>' . $commentHtml . '</p>';
        }

        echo '</details>';
    }
}
