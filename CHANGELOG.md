# Changelog

## 2026-08-01

Initial commit. Week was spent learning PHP and MySQL while going over the initial data in the Sweetwater Test. Added ADR from 07-30.

## 2026-08-02

Added ADRs I will be researching for today, along with a comment outline for the first task. I suspect the ADR on how to read in the MySQL effectively will impact how I implement the second task in the script. Then again, Task 2 serves a different intent, and could be an entirely different script to perform its duties.

Added the database connection, using the exported environment variables to handle the connection while not sharing or including secrets in the repository.

Added the logic for the comment sorting. I didn't know how to echo out the different headings then send the comments to those headings like I might with appendChild in JavaScript, so I had to do a double loop for now to get the comments working. Next is to look into extracting the categorization logic into a utility function in another file, so that it is clear what's going on without needing to read the function internals. Then doing the same for the print out categories function would make the logic readable for a human with relative ease.
