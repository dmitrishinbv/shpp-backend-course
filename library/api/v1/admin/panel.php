<?php

if (!isset($_SESSION)) {
    session_start();
}
require_once SITE_PATH . "constants.php";
require_once SITE_PATH . "models/Database.php";
?>

<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>shpp-library - Админка</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
    <script src="/public/js/panelFunctions.js"></script>
    <script src="/public/js/jquery.js"></script>

    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/main.css">
</head>

<body>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-6"><br>
                <h2><b><a href="/library">Библиотека++</a></b></h2></div>
            <div class="col-lg-6"><br>
                <p align="right"><a href="#" onclick="logout();">Log out</a> | <a href="/library/public/register.html">Register</a>
            </div>
        </div>

    </div>
</header>
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

                        <?php

                        function deleteFlag($id)
                        {
                            $label = <<<html
  <input class="form-check-input" onclick="if (window.confirm('Delete book?')) {confirmDelete($id)}"
   type="checkbox" name="checkForDel/$id" id="defaultCheck1">
  <label class="form-check-label" for="defaultCheck1"> Удалить </label>

html;
                            return $label;
                        }

                        function undoDeleteFlag($id)
                        {
                            $label = <<<html
  <input class="form-check-input" onclick="confirmDelete($id)"  type="checkbox" name="checkForDel/$id" id="defaultCheck1">
  <label class="form-check-label" for="defaultCheck1"><b>Отменить</b></label>
html;
                            return $label;
                        }


                        foreach ($entries as $row) {
                            $show_img = base64_encode($row["image"]);
                            if (htmlentities($row["delflag"]) != 1) {
                                echo "<tr><td><a href = '#'>
<img style=\"margin-right: 5px;\" src='data:image/jpeg;base64, $show_img' alt='' width = 30px></a>" . htmlentities($row["name"])
                                    . "</td><td>" . htmlentities($row["authors"])
                                    . "</td><td>" . htmlentities($row["year"])
                                    . "</td><td>" . deleteFlag(htmlentities($row["book_id"]))
                                    . "</td>
<td>" . htmlentities($row["visits"]) . ' / ' . htmlentities($row["clicks"]);
                            } else {
                                echo "<tr>
<td class='colDelBook'>
<a href = '#'>
<img style=\"margin-right: 5px;\" src='data:image/jpeg;base64, $show_img' alt='' width = 30px></a>
<del>" . htmlentities($row["name"]) . "</del>
</td><td class='colDelBook'><del>" . htmlentities($row["authors"]). "</del>
</td><td class='colDelBook'><del>" . htmlentities($row["year"]). "</td>
<td class='colDelBook'>Будет удалено </br>" . undoDeleteFlag(htmlentities($row["book_id"])) . "</td>
<td class='colDelBook'><del>" . htmlentities($row["visits"]) . ' / ' . htmlentities($row["clicks"]);
                            }
                        }

                        echo "</div>";
                        ?>
                        </tbody>
                    </table>

                    <nav>
                        <form name=myform method="post">
                            <ul class="pagination justify-content-center">
                                <?php
                                $currentpage = empty($_SESSION['page']) ? 1 : $_SESSION['page'];
                                $prevpage = ($currentpage == 1) ? 1 : $currentpage - 1;
                                $nextpage = ($currentpage == $totalPages) ? $currentpage : $currentpage + 1;
                                if ($totalPages > 1) {
                                    if ($currentpage != 1) {
                                        echo "<li class='page-item'><input name=page/$prevpage type=hidden />
<a class='page-link'  onclick='page($prevpage)' href='#'>Предыдущая</a></li>";
                                    }
                                    for ($page = 1; $page <= $totalPages; $page++) {
                                        if ($page == $currentpage) {
                                            echo "<li class='page-item'><input name=page/$page type=hidden />
<a onclick='page($page)' href='#' class='page-link alert-dark'>" . $page .
                                                "</a></li>";
                                            continue;
                                        } else {
                                            echo "<li class='page-item'><input name=page/$page type=hidden />
<a onclick='page($page)' href='#' class='page-link'>" . $page .
                                                "</a></li>";
                                        }
                                    }
                                    if ($totalPages > 1 && $currentpage < $totalPages) {
                                        echo "<li class='page-item'><input name=page/$nextpage type=hidden />
<a class='page-link'  onclick='page($nextpage)' href='#'>Следущая</a></li>";
                                    }
                                }

                                unset($_SESSION['page']);
                                ?>
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
                    <a href="/library/public/changeCron.html"><b>Изменить настройки
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