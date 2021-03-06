<?php
if(!isset($_SESSION)){
    session_start();
}
require_once 'connection.php';

if (isset($_SESSION['hash']) and isset($_COOKIE['user_id'])) {
    $id = $_COOKIE['user_id'];
    $hash = $_SESSION['hash'];
    $query = mysqli_query($conn, "SELECT * FROM users_list WHERE `id`= '$id'");
    $userdata = mysqli_fetch_assoc($query);

    if (!$userdata["login"]) {
        $_SESSION["error"] = "Log in please!";
        $response = json_encode(["error" => "Log in please!"]);
    }

    if ($hash !== $userdata["hash"]) {
        setcookie("user_id", "", time() - 3600 * 24 * 30 * 12, "/");
        $response = json_encode(["error" => "Session expired!"]);
    }

    else {
        header("HTTP/1.1 200 OK");
        $response = json_encode(["ok" => true]);
        $_SESSION["status"] = "ok";
    }


} else {
    unset ($_SESSION["status"]);
    header("HTTP/1.1 401 Unathorized");
    $response = json_encode(["error" => "Log in please!"]);
    $_SESSION["error"] = "Log in please!";
}

    echo $response;
?>