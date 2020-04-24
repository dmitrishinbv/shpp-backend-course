<?php
require_once 'bootstrap.php';
require_once SITE_PATH . 'views/panel/header.php';
?>

<section>
    <form id="bookEntries" action="deleteBook.php" method="post">
        <div class="container-fluid marginRight">
            <div class="row">
                <div class="col-lg-7">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Название книги</th>
                            <th>Авторы</th>
                            <th>Год</th>
                            <th>Действия*</th>
                            <th>Visits/ Clicks</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data as $book) {
                            $book_img = base64_encode($book['image']);
                            $id = htmlentities($book['book_id']);

                            if (htmlentities($book['delflag']) != 1) { ?>
                                <tr>
                                <td><img style="margin-right: 5px;"
                                         src='data:image/jpeg;base64, <?= $book_img; ?>' alt='' width=30px>
                                    <?= htmlentities($book['name']); ?></td>
                                <td> <?= htmlentities($book['authors']); ?></td>
                                <td> <?= htmlentities($book['year']); ?></td>
                                <td><input class="form-check-input"
                                           onclick="if (window.confirm('Delete book?')) {confirmDelete(<?= $id; ?>)}"
                                           type="checkbox" name="checkForDel/<?= $id; ?>" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1"> Удалить </label></td>
                                <td> <?= htmlentities($book['visits']); ?> / <?= htmlentities($book['clicks']); ?></td>

                            <?php } else { ?>
                                <td class='colDelBook'><img style="margin-right: 5px;"
                                                            src='data:image/jpeg;base64, <?= $book_img; ?>' alt=''
                                                            width=30px>
                                    <del><?= htmlentities($book['name']); ?></del>
                                </td>
                                <td class='colDelBook'>
                                    <del> <?= htmlentities($book['authors']); ?></del>
                                </td>
                                <td class='colDelBook'>
                                    <del> <?= htmlentities($book['year']); ?></del>
                                </td>
                                <td class='colDelBook'>Будет удалено <br><input class="form-check-input"
                                                                                onclick="confirmDelete(<?= $id; ?>)"
                                                                                type="checkbox"
                                                                                name="checkForDel/<?= $id; ?>"
                                                                                id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1"><b>Отменить</b></label></td>
                                <td class='colDelBook'>
                                    <del> <?= htmlentities($book['visits']); ?> /
                                        <?= htmlentities($book['clicks']); ?></del>
                                </td>
                            <?php } ?>

                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                    <nav>
                        <form name=myform method="post">
                            <ul class="pagination justify-content-center">
                                <?php if ($totalPages > 1) {
                                    if ($pages['current'] != 1) { ?>
                                        <li class="page-item"><input name="page/<?= $pages['prev']; ?>" type="hidden"/>
                                            <a class="page-link" onclick="page(<?= $pages['prev']; ?>)"
                                               href="#">Предыдущая</a></li>
                                    <?php }

                                    for ($page = 1; $page <= $totalPages; $page++) {
                                        if ($page == $pages['current']) { ?>
                                            <li class="page-item"><input name="page/<?= $page; ?>" type="hidden"/>
                                                <a onclick="page(<?= $page; ?>)" href="#"
                                                   class="page-link alert-dark"> <?= $page; ?></a></li>
                                            <?php continue;
                                        } else { ?>
                                            <li class="page-item"><input name="page/<?= $page; ?>" type="hidden"/>
                                                <a onclick="page(<?= $page; ?>)" href="#"
                                                   class="page-link"> <?= $page; ?></a></li>
                                        <?php }
                                    }
                                    if ($totalPages > 1 && $pages['current'] < $totalPages) { ?>
                                        <li class="page-item"><input name="page/<?= $pages['next']; ?>" type="hidden"/>
                                            <a class="page-link" onclick="page(<?= $pages['next']; ?>)"
                                               href="#">Следущая</a></li>
                                    <?php }
                                } ?>
                            </ul>
                        </form>
                    </nav>
                    <p></p>
                    <p> * записи будут удалены при следуюущем обновлении базы данных </p>
                    <br/>

                </div>
                <div class="col-lg-5 addNewBook">Добавить новую книгу
                    <br>
                    <br>
                    <form id="bookInfo" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col">
                                <input type="text" name="bookName" class="form-control" onkeyup="checkInput();"
                                       id="input" placeholder="название книги (обязательно)">
                            </div>
                            <div class="col">
                                <input type="text" id="bookAuthor1" name="bookAuthor1" class="form-control"
                                       placeholder="автор1">
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col">
                                <input type="number" min="1900" max="2020" maxlength="4" name="bookYear"
                                       class="form-control" id="bookYear" placeholder="год издания">
                            </div>
                            <div class="col">
                                <input type="text" id="bookAuthor2" name="bookAuthor2" class="form-control"
                                       placeholder="автор2*">
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col">
                                <label>загрузить картинку (не более 2 Мб)</label>
                                <input type="file" class="form-control-file" name="bookImage" id="file"/>
                            </div>
                            <div class="col">
                                <input type="text" id="bookAuthor3" name="bookAuthor3" class="form-control"
                                       placeholder="автор3*">
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-6">
                                <span id="output"></span>
                            </div>

                            <div class="col-6">
                            <textarea rows="5" class="form-control" name="bookDescription" id="bookDescription"
                                      placeholder="описание книги"></textarea>
                            </div>
                        </div>

                        <p></p>
                        <div class="row">
                            <div class="col">
                                <input type="submit" value="ДОБАВИТЬ" onclick="addNewBook()" id="submit"
                                       class="btn btn-primary" disabled/>
                                <p></p>
                                <button form="bookInfo" id="button" type="reset"
                                        class="btn btn-primary">ВВЕСТИ ВСЕ ЗАНОВО
                                </button>
                                <p></p>
                            </div>

                            <div class="col-6">
                                * оставьте поля пустыми если авторов < 3
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <img style="margin-right: 5px;"
                         src="/public/images/cron.png" width="20%"
                         alt="cron_image">
                    <a href="/library/public/underConstruction.html"><b>Изменить настройки
                            cron</b></a> <br/>
                    <p></p>
                    <img style="margin-right: 5px;"
                         src="/public/images/backup.jpg" width="20%"
                         alt="backup_image">
                    <a href="#" onclick="initBackup()"><b>Выполнить полный бэкап сайта сейчас</b></a>
                </div>
</section>

<script>
    document.getElementById('file').addEventListener('change', handleFileSelect, false);
</script>

<footer class="footer-wrapper">
    <div class="col-lg-4">
        <br/> © 2020 Bohdan Dmytryshyn
    </div>
</footer>
</body>
</html>