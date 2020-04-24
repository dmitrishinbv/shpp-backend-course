INSERT IGNORE INTO authors (book_id, author) SELECT book_id,
SUBSTRING_INDEX(SUBSTRING_INDEX(books.authors, ', ', numbers.n), ', ', -1)
authors   from (select 1 n union all select 2 union all select 3)
 numbers INNER JOIN books on CHAR_LENGTH(books.authors)
-CHAR_LENGTH(REPLACE(books.authors, ', ', '')) >=numbers.n-1 WHERE books.delflag = 0;