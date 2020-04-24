INSERT IGNORE INTO books_and_authors (book_id, author_id)
SELECT authors.book_id, authors.id FROM authors JOIN books
WHERE (authors.book_id = books.book_id AND books.delflag = 0);