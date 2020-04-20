<?php

$body = <<<HTML
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Админка</title>
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/main.css">
</head>

<body>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-6"><br>
                <h2><b>Библиотека++</b></h2></div>
            <div class="col-6"><br>
                <p align="right"><a href="../../app/components/logout.php">Выход</a></p></div>
        </div>

    </div>
</header>
<section>
    <div class="container-fluid marginRight">
        <div class="row">
            <div class="col-6">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Название книги</th>
                        <th>Авторы</th>
                        <th>Год</th>
                        <th>Действия</th>
                        <th>Кликов</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                        <td>@mdo</td>
                    </tr>

                    </tbody>
                </table>

                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" href="#">Предыдущая</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item"><a class="page-link" href="#">Следующая</a></li>
                    </ul>
                </nav>

            </div>
            <div class="col-6 addNewBook">Добавить новую книгу
                <br>
                <br>
                <form>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="название книги">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="автор1">
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="год издания">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="автор2*">
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col">
                                <label>загрузить картинку</label>
                                <input type="file" class="form-control-file" id="file" />
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="автор3*">
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-6">
                            <span id="output"></span>
                        </div>

                        <div class="col-6">
                            <textarea rows="5" class="form-control" id="bookDefinition"
                                      placeholder="описание книги"></textarea>
                        </div>
                    </div>

                    <p></p>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">ДОБАВИТЬ</button>
                            <p></p>
                        </div>

                        <div class="col-6">
                            * оставьте поля пустыми если авторов < 3
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <script>
        function handleFileSelect(evt) {

            var file = evt.target.files; // FileList object
            var f = file[0];
            // Only process image files.
            if (!f.type.match('image.*')) {
                alert("Image only please....");
            }
            var reader = new FileReader();
            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                      // Render thumbnail.
                    var span = document.createElement('span');
                    span.innerHTML = ['<img class="thumb" width= "200px", title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
                    document.getElementById('output').insertBefore(span, null);
                };
            })(f);
            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
        document.getElementById('file').addEventListener('change', handleFileSelect, false);
    </script>

    <footer class="footer">
        <div class="container">
                <div class="row">
                    © 2020 Bohdan Dmytryshyn
                </div>
        </div>

    </footer>

</section>

</body>
HTML;

//if (isset($_SERVER['PHP_AUTH_USER'])) {
// echo $body;
//}
//
//else {
//
//    header('HTTP/1.1 401 Unauthorized');
//    header('WWW-Authenticate: Basic realm="Restricted Area"');
// require_once "../../app/components/login.php";

// if ($_SESSION["status"] == "ok") {
//     var_dump($_SESSION["status"]);
//     echo $body;
// }
// else {
//     echo "401 Unauthorized";
//}

?>