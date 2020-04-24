<?php
if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    Server::responseCode(405);
}
// save in session number of page for admin panel pagination
$_SESSION['page'] = (!empty($_POST) && isset($_POST['page'])) ? $_POST['page'] : 1;
// save in session number of page for index.php pagination
$_SESSION['index_page'] = (!empty($_POST) && isset($_POST['index_page'])) ? $_POST['index_page'] : 1;

