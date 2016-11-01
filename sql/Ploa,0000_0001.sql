/*
______________________________Patch Information________________________________
Description: Post retrieval procedure
Data Integrity: Destroy get_posts
Required: Yes
*/


DROP PROCEDURE IF EXISTS get_posts;

CREATE PROCEDURE get_posts ( offset_in INTEGER, count_in INTEGER )
BEGIN

	SELECT posts.post_ref, posts.datetime_posted, posts.post_data 
	FROM posts WHERE posts.published = 1 LIMIT offset_in, count_in;

END ;
