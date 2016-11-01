/*
______________________________Patch Information________________________________
Description: Initial database creation
Data Integrity: Destroy posts
Required: Yes
*/


DROP TABLE IF EXISTS posts;
		
CREATE TABLE posts 
(
	id_post INTEGER NULL AUTO_INCREMENT DEFAULT NULL,
	post_ref VARCHAR(32) NULL DEFAULT NULL,
	timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	datetime_posted DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	post_data TEXT NULL DEFAULT NULL,
	published INTEGER NOT NULL DEFAULT 0,
	PRIMARY KEY (id_post)
);
