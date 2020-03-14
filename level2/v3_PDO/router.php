<?php
if (!isset($_SESSION)) {
    session_start();
}

$inputData = file_get_contents('php://input');
$action = $_GET["action"] ?? "";

$_SESSION['data'] = $inputData;
allowCors();

switch ($action) {
    case "register" :
        require "register.php";
        break;
    case "login" :
        require "login.php";
        break;
    case "logout" :
        require "logout.php";
        break;
    case "getItems" :
        require "getItems.php";
        break;
    case "addItem" :
        require "addItem.php";
        break;
    case "changeItem" :
        require "changeItem.php";
        break;
    case "deleteItem" :
        require "deleteItem.php";
        break;
     default :
         header("HTTP/1.1 400 Bad Request");
         die (json_encode(['error' => "400 Bad Request"]));
}


function allowCors() {

    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, HEAD, OPTIONS, PUT, DELETE");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
}
?>