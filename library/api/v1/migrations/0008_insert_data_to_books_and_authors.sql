INSERT IGNORE INTO books_and_authors (book_id, author_id) SELECT books.book_id, authors.id FROM authors JOIN books
WHERE authors.author = books.authors;