ALTER TABLE books_and_authors
    ADD FOREIGN KEY (book_id) REFERENCES books(book_id) ON DELETE CASCADE;
ALTER TABLE books_and_authors
    ADD FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE CASCADE;