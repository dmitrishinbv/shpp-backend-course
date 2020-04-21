<?php

allowCors();

if (!isset($_SESSION)) {
    session_start();
}


function allowCors() {

    if (isset($_SERVER['HTTP_ORIGIN'])) {
        var_dump($_SERVER['HTTP_ORIGIN']);
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86500');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        var_dump($_SERVER['REQUEST_METHOD']);

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, HEAD, OPTIONS, PUT, DELETE");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
}

//header('Access-Control-Allow-Origin: http://idea.localhost/api/v2/');

require_once 'connection.php';

$errors = ["401 Unauthorized", "400 Bad Request"];

if (isset($_SESSION["hash"]) && $_SESSION["status"] === "ok") {
    $hash = $_SESSION["hash"];

    $found = $conn->query("SELECT * FROM users_list WHERE `hash`= '$hash'");
    $found = mysqli_fetch_array($found);

    if ($found !== null && $found["id"]) {
        $result = $conn->query("SELECT * FROM todo_list", MYSQLI_STORE_RESULT);
        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $row["checked"] = ($row["checked"] == 0) ? false: true;
             $data[] = $row;
        }

//        header("Access-Control-Allow-Origin: http://www.idea.localhost");
//        header("Access-Control-Allow-Headers: Content-Type, Authorization");
//        header ("Access-Control-Allow-Methods: *");
//        header("Access-Control-Allow-Credentials: true");
        header("HTTP/1.1 200 OK");
        $data = ["items" => $data];
        echo json_encode($data);

    } else {
        showError($errors[1]);
    }

} else {
    showError($errors[0]);
}



function showError($message)
{
//    header("Access-Control-Allow-Origin: http://www.idea.localhost");
//    header("Access-Control-Allow-Headers: Content-Type, Authorization");
//    header("Access-Control-Allow-Credentials: true");
//    header ("Access-Control-Allow-Methods: *");
    header($message);
    die(json_encode(["error" => $message]));
}

mysqli_close($conn);
?>