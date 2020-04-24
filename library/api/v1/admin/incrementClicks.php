<?php
require_once 'bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    Server::responseCode(405);
}

$id = (!empty($_POST) && isset($_POST['click_id'])) ? $_POST['click_id'] : Server::responseCode(400);

$model = new Model_Books();
$model->incrementClicks($id);