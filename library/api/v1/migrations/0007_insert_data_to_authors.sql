﻿INSERT IGNORE INTO authors (author) SELECT authors FROM books WHERE (authors IS NOT NULL);