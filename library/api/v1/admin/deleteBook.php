<?php
require_once 'bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    Server::responseCode(405);
}

if (!empty($_POST) && isset($_POST['id'])) {
    $model = new Model_Books();
    $model -> deleteBook( htmlentities($_POST['id']));

} else {
    Server::responseCode(500);
}