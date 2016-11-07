/*
______________________________Patch Information________________________________
Description: Post retrieval procedure
Data Integrity: Destroy get_post_by_ref
Required: Yes
*/


DROP PROCEDURE IF EXISTS get_post_by_ref;

CREATE PROCEDURE get_post_by_ref ( post_ref_in VARCHAR(32) )
BEGIN

	SELECT posts.post_ref, posts.datetime_posted, posts.post_data, posts.title
	FROM posts WHERE posts.post_ref = post_ref_in;

END ;
