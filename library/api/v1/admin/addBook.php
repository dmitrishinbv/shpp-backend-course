<?php
require_once '../constants.php';
require_once SITE_PATH . '/models/model_books.php';
require_once SITE_PATH . '/core/server.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    Server::responseCode(405);
}

if (!empty($_POST)) {
    $bookName = trim(htmlentities($_POST['bookName']));
    $payLoadList['bookName'] = $bookName;

    if (empty($bookName)) {
        Server::responseCode(402);
    }

    if (!empty(trim($_POST['bookAuthor1']))) {
        $authors = trim(htmlentities($_POST['bookAuthor1']));
    }

    if (!empty(trim($_POST['bookAuthor2']))) {
        $author = trim(htmlentities($_POST['bookAuthor2']));
        $authors .= ', ' . $author;
    }

    if (!empty($_POST['bookAuthor3'])) {
        $author = trim(htmlentities($_POST['bookAuthor3']));
        $authors .= ', ' . $author;
    }

    if (!empty($authors)) {
        $payLoadList += ['bookAuthors' => $authors];
    }

    if (!empty($_POST['bookYear'])) {
        $year = trim(htmlentities($_POST['bookYear']));
        if ((int)$year < 1900 || (int)$year > 2020) {
            Server::responseCode(402);
        }
        $payLoadList += ['bookYear' => $year];
    }

    if (!empty($_POST['bookDescription'])) {
        $description = trim(htmlentities($_POST['bookDescription']));
        $payLoadList += ['bookDescription' => $description];
    }

    if (!empty($_FILES['bookImage']['tmp_name'])) {
        $img = file_get_contents(htmlentities($_FILES['bookImage']['tmp_name']));
        $payLoadList += ['bookImage' => $img];
    }

} else {
    Server::responseCode(500);
}

$model = new Model_Books();
$model->addBook($payLoadList);