<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php
            $adminUrl = "/" . ADMIN_URL;
            $query = $_SESSION['searchText'];
            $res = count($results);
            if ($res === 0) {
                echo " <h2 style=\"color:#26A041\">К сожалению по вашему запросу <I>'$query'</I> ничего не нашлось :(</h2>";
            } else {
                echo " <h2 style=\"color:#26A041\">По запросу <I>'$query'</I> нашлось $res совпадений</h2>";
                foreach ($results as $base_key => $book) {
                    $book_delfalg = htmlentities($book['delflag']);
                    if ($book_delfalg == 1) continue;
                    $book_id = htmlentities($book['book_id']);
                    $book_name = htmlentities($book['name']);
                    $book_authors = htmlentities($book['authors']);
                    $book_img_src = ($book['image'] == NULL) ? "/public/images/No-Image-Available.png"
                        : "data:image/jpeg;base64, " . base64_encode($book['image']);
                    echo "<div class='book_item col-xs-6 col-sm-3 col-md-2 col-lg-2'>
            <div class='book'>
                <a href='book/$book_id'><img src='$book_img_src' alt='$book_name'>
                    <div data-title='$book_name' class='blockI' style='height: 46px;'>
                        <div data-book-title='$book_name' class='title size_text'>$book_name</div>
                        <div data-book-author='$book_authors' class='author'>$book_authors</div>
                    </div>
                </a>
                  <input id='adminUrl' value = '$adminUrl' hidden>
                  <button type='submit' class='btnBookID btn-lg btn btn-success' onclick='searchPageClick($book_id)' id='btnBook'>Читать</button>
            </div>
        </div>";
                }
            }
            ?>
        </div>
    </div>
</section>