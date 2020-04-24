<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            $text = $_SESSION['searchText'];
            $res = count($results);

            if ($res === 0) { ?>
                <h2 style="color:#26A041">К сожалению по вашему запросу
                    <I>'<?= $text; ?>'</I> ничего не нашлось :( </h2>;

            <?php } else { ?>

                <h2 style="color:#26A041">По запросу <I>'<?= $text; ?>'</I> нашлось <?= $res; ?> совпадений</h2>

                <?php foreach ($results as $book) {
                    $book_img_src = ($book['image'] == NULL) ? "/public/images/No-Image-Available.png"
                        : "data:image/jpeg;base64, " . base64_encode($book['image']);
                    $book_id = htmlentities($book['book_id']);
                    $book_name = htmlentities($book['name']);
                    ?>

                    <div data-book-id=<?= htmlentities($book['book_id']); ?>
                         class="book_item col-xs-6 col-sm-3 col-md-2 col-lg-2">
                        <div class="book">
                            <a href="/library/book/<?= $book_id; ?>">
                                <img src="<?= htmlentities($book_img_src); ?>" alt="<?= $book_name; ?>">
                                <div data-title="<?= $book_name; ?>"
                                     class="blockI" style="height: 46px;">
                                    <div data-book-title="<?= $book_name; ?>"
                                         class="title size_text"><?= $book_name; ?></div>
                                    <div data-book-author="<?= htmlentities($book['authors']); ?>"
                                         class="author"><?= htmlentities($book['authors']); ?></div>
                                </div>
                            </a>
                            <button type="submit" class="btnBookID btn-lg btn btn-success"
                                    onclick="searchPageClick(<?= $book_id; ?>)" id="btnBook">Читать
                            </button>
                        </div>
                    </div>

                <?php }
            } ?>

        </div>
    </div>
</section>