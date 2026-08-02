# How to connect to MySQL

## Problem Statement

As a novice, I need to know what the optimal way is to connect to MySQL. PHP Data Objects and MySQLi are the Google Search results in terms of options.

## Decision

PHP Data Objects seems to be the way to go. Using manual exporting of the environment variables for user and pass, since using the package that seems to be recommended for handling .env files would fall outside the write your own code edict. May write a utility function for convenience later to optimize for UX.

## Rationale

While MySQLi is written for MySQL particularly, PHP Data Objects' utility extends beyond the exercise here, and if receiving an offer, would apply to Postgres, Oracle, MSSQL, and many others, since it is database agnostic according to the searching.
