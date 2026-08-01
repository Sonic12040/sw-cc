# Invalid Datetime Value in SQL data

## Problem Statement

The SQL data for date time value includes an invalid default, throwing the error: ERROR 1292 (22007) at line 11: Incorrect datetime value: '0000-00-00 00:00:00' for column 'shipdate_expected' at row 1

There seem to be at least two choices: Relax the SQL mode so that the value is allowed (ZERO IN DATE). It would also be possible to modify the data so that the dates are valid in SQL's strict mode via some sanitization of the data.

## Decision

Use relaxed rules for importing the data into the database.

## Rationale

Because this is a coding challenge, and the objectives are on:

- How I think
- How I structure my code
- How I make reasonable engineering decisions
- Thought process

It makes sense, given the one-off nature of the script to focus on the qualities of the script itself rather than the inputting of the data. If this were a production system, we would sanitize the data as it comes in so that we could maintain strict mode on the SQL database, but spending time there in a short coding exercise can cost the time spent elsewhere and build a utility that isn't necessary for the short duration and use.
