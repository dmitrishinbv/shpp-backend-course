<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <?php
            $adminUrl = "/" . ADMIN_URL;
            if (count($books) === 0) {
                echo " <h2 style=\"color:#26A041\">Пока что в библиотеку не добавлено ни одной книги. 
 Запустите процесс миграций для настройки базы данных</h2>";

            } else {
                foreach ($books as $base_key => $base_value) {
                    $book_id = htmlentities($base_value["book_id"]);
                    $book_name = htmlentities($base_value["name"]);
                    $book_authors = htmlentities($base_value["authors"]);
                    $book_delfalg = htmlentities($base_value["delflag"]);

                    if ($book_delfalg == 1) continue;

                    if ($base_value["image"] != NULL) {
                        $book_img_64encode = base64_encode($base_value["image"]);
                        $book_img_src = "data:image/jpeg;base64, " . $book_img_64encode;
                    } else {
                        $book_img_src = "/public/images/No-Image-Available.png";
                    }

                    echo "<div data-book-id='$book_id' class='book_item col-xs-6 col-sm-3 col-md-2 col-lg-2'>
            <div class='book'>
                <a href='book/$book_id'><img src='$book_img_src' alt='$book_name'>
                    <div data-title='$book_name' class='blockI' style='height: 46px;'>
                        <div data-book-title='$book_name' class='title size_text'>$book_name</div>
                        <div data-book-author='$book_authors' class='author'>$book_authors</div>
                    </div>
                </a>
                  <input id='adminUrl' value = '$adminUrl' hidden>
                  <button type='submit' class='btnBookID btn-lg btn btn-success' onclick='mainPageClick($book_id)' id='btnBook'>Читать</button>
                      </div>
</div>";
                }
            }
            ?>

        </div>
    </div>
    <center>
        <nav>
            <form name="myform" method="post">
                <ul class="pagination justify-content-center">
                    <?php
                    $total_pages = $_SESSION['total_pages'];
                    $currentpage = empty($_SESSION['index_page']) ? 1 : $_SESSION['index_page'];
                    $prevpage = ($currentpage == 1) ? 1 : $currentpage - 1;
                    $nextpage = ($currentpage == $total_pages) ? $currentpage : $currentpage + 1;
                    if ($total_pages > 1) {
                        if ($currentpage != 1) {
                            echo "<li class='page-item'><input name=page/$prevpage type=hidden /><a class=\"btn-primary\" onclick='page($prevpage)' href='#'>Предыдущая</a></li>";
                        }

                        for ($page = 1; $page <= $total_pages; $page++) {
                            if ($page == $currentpage) {
                                echo "<li class='page-item'><input name=page/$page type=hidden /><a onclick='page($page)' href='#' class='btn-primary active'>" . $page .
                                    "</a></li>";
                                continue;
                            } else {
                                //              echo "<li class=\"page-item\"><a href='__panel.php?route=pageAdminPanel/$page' class=\"page-link\">".$page.
                                echo "<li class='page-item'><input name=page/$page type=hidden /><a onclick='page($page)' href='#' class='btn-primary '>" . $page .
                                    "</a></li>";

                            }
                        }
                        if ($total_pages > 1 && $currentpage < $total_pages) {
                            echo "<li class='page-item'><input name=page/$nextpage type=hidden /><a class='btn-primary '  onclick='page($nextpage)' href='#'>Следущая</a></li>";
                        }
                    }
                    unset($_SESSION['index_page']);
                    ?>
                </ul>
            </form>
        </nav>
    </center>
</section>
