/*
______________________________Patch Information________________________________
Description: Add title column to posts table
Data Integrity: Safe
Required: Yes
*/

ALTER TABLE posts ADD title VARCHAR(128);
