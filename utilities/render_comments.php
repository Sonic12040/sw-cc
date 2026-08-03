<?php

function renderComments(array $categorizedComments): void {
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
}
