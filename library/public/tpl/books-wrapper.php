<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <?php if (count($data) === 0) { ?>
                <h2 style="color:#26A041">Пока что в библиотеку не добавлено ни одной книги.
 Запустите процесс миграций для настройки базы данных</h2>;

            <?php } else {
                foreach ($data as $book) {
                    $book_img_src = ($book['image'] == NULL) ? "/public/images/No-Image-Available.png"
                        : "data:image/jpeg;base64, " . base64_encode($book['image']);
                    $book_id = htmlentities($book['book_id']);
                    $book_name = htmlentities($book['name']);
                    ?>
                    <div data-book-id=<?= htmlentities($book['book_id']); ?>
                         class="book_item col-xs-6 col-sm-3 col-md-2 col-lg-2">
                        <div class="book">
                            <a href="book/<?= $book_id; ?>">
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
                                    onclick="mainPageClick(<?= $book_id; ?>)" id="btnBook">Читать
                            </button>
                        </div>
                    </div>
                <?php }
            }?>
            </div>
    </div>
    <center>
            <nav>
            <form name="myform" method="post">
                <ul class="pagination justify-content-center">
                    <?php if ($totalPages > 1) {
                        if ($pages['current'] != 1) { ?>
                            <li class="page-item"><input name="page/<?= $pages['prev']; ?>" type="hidden"/>
                                <a class="btn-primary" onclick="indexpage(<?= $pages['prev']; ?>)"
                                   href="#">Предыдущая</a></li>
                        <?php }

                        for ($page = 1; $page <= $totalPages; $page++) {
                            if ($page == $pages['current']) { ?>
                                <li class="page-item"><input name="page/<?= $page; ?>" type="hidden"/>
                                    <a onclick="indexpage(<?= $page; ?>)" href="#"
                                       class="btn-primary active"> <?= $page; ?></a></li>
                                <?php continue;
                            } else { ?>
                                <li class="page-item"><input name="page/<?= $page; ?>" type="hidden"/>
                                    <a onclick="indexpage(<?= $page; ?>)" href="#"
                                       class="btn-primary"> <?= $page; ?></a></li>
                            <?php }
                        }
                        if ($totalPages > 1 && $pages['current'] < $totalPages) { ?>
                            <li class="page-item"><input name="page/<?= $pages['next']; ?>" type="hidden"/>
                                <a class="btn-primary" onclick="indexpage(<?= $pages['next']; ?>)"
                                   href="#">Следущая</a></li>
                        <?php }
                    } ?>
                </ul>
            </form>
        </nav>
    </center>
</section>