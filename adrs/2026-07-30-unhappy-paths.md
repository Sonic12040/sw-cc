# Consideration of Unhappy Paths

## Problem Statement

In the email to Jamey, I iterated my initial decision to learn the languages being worked with instead of relying 100% on AI for the code challenge. I also asked about coding for the "unhappy paths". Specifically, I was thinking about a message which might fall into more than one category, such as a message which may fall into both candy and call-me / don't call me. As I reviewed the messages, I noted a message may also NOT be in English (lines 45, 223).

## Decisions

- Messages which match multiple categories should show up in each category it matches.
- Support messages in other languages than English in the solutions.

## Rationale

Messages which only show up in the first category they match may not show up if someone is actioning on a report which isn't for that category. It may make sense to print them with an output which includes (in categories: <CATEGORIES>) so that the acknowledgment of duplication is available to the reader of the report.

Reporting should support multiple languages because not everyone speaks English, and everyone should be able to interact with the system. I don't speak Spanish, so Google Translate will serve for my understanding for messages on lines 45 and 223. Other languages may surface while writing the script.
