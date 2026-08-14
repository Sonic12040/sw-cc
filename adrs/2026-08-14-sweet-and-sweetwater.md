# Sweet matching Sweetwater

## Problem Statement

When sweet matches sweetwater, sweetwater results in a comment being categorized as candy when it is, in fact, not a candy at all.

## Decision

Add an exclude list to exclude Sweetwater from the categorization.

## Rationale

Until a more complete system is put in place for comment matching (phrase matches only, or some other form of tokenization), includes and excludes can create a reasonable completeness of comment categorization and boost the accuracy rate without extensive implementation effort.
