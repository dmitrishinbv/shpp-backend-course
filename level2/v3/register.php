<?php

define("MIN_PASS_SYMBOLS", 3);
define("MAX_PASS_SYMBOLS", 30);
define("MAX_LOGIN_SYMBOLS", 40);

if(!isset($_SESSION)){
    session_start();
}
require_once 'connection.php';

$userInfo = $_SESSION['data'];
$userInfo = json_decode($userInfo, true);

$errors = ["Error 500. Internal Server Error",
    "Error 400. Bad Request", "Error. User with this name is already registered!",
    "Error. Password length is incorrect! 
     The password length must be from " . MIN_PASS_SYMBOLS . " to " . MAX_PASS_SYMBOLS . " symbols",
    "Error. Max login length is " . MAX_LOGIN_SYMBOLS . " symbols"];

if (count($userInfo) !== 2 or !isset($userInfo["login"]) or !isset($userInfo["pass"])) {
    showError($errors[1]);
}

$login = $userInfo ["login"];
$pass = $userInfo ["pass"];

if (strlen($pass) < MIN_PASS_SYMBOLS or strlen($pass) > MAX_PASS_SYMBOLS) {
    showError($errors[3]);
}


checkUserInfo($login, $conn, $errors);

$hash = password_hash($pass, PASSWORD_DEFAULT);
$query = mysqli_query($conn, "INSERT INTO users_list (login, pass, hash) VALUES ('$login', '$pass', '$hash')");

require_once 'logout.php';

mysqli_close($conn);


function checkUserInfo($login, $conn, $errors)
{
    $found = mysqli_query($conn, "SELECT * FROM users_list WHERE `login`= '$login'");
    $found = mysqli_fetch_assoc($found);

    if ($found["login"] != null) {
        showError($errors[2]);
    }

    if (strlen($login) > MAX_LOGIN_SYMBOLS) {
        showError($errors[4]);
    }
}

function showError ($status) {
    header("HTTP/1.1 .'$status'");
    $message = ["error" => $status];
    die (json_encode($message));
}
?>