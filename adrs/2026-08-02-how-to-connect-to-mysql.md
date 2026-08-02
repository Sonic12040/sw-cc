# How to connect to MySQL

## Problem Statement

As a novice, I need to know what the optimal way is to connect to MySQL. PHP Data Objects and MySQLi are the Google Search results in terms of options.

## Decision

PHP Data Objects seems to be the way to go.

## Rationale

While MySQLi is written for MySQL particularly, PHP Data Objects' utility extends beyond the exercise here, and if receiving an offer, would apply to Postgres, Oracle, MSSQL, and many others, since it is database agnostic according to the searching.
