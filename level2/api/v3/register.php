<?php

define("MIN_PASS_SYMBOLS", 3);
define("MAX_PASS_SYMBOLS", 30);
define("MAX_LOGIN_SYMBOLS", 40);
require 'connection.php';

$userInfo = $_SESSION['data'];
$userInfo = json_decode($userInfo, true);

//$userInfo = file_get_contents("php://input");
//$userInfo = file_get_contents("input.json");

$errors = ["Error 500. Internal Server Error",
    "Error 400. Bad Request", "Error. User with this name is already registered!",
    "Error. Password length is incorrect! 
     The password length must be from " . MIN_PASS_SYMBOLS . " to " . MAX_PASS_SYMBOLS . " symbols",
    "Error. Max login length is " . MAX_LOGIN_SYMBOLS . " symbols"];


if (count($userInfo) !== 2 or !isset($userInfo["login"]) or !isset($userInfo["pass"])) {
    mysqli_close($conn);
    header("HTTP/1.1 .'$errors[1]'");
    die (json_encode(["error" => "$errors[1]"]));
}

$login = $userInfo ["login"];
$pass = $userInfo ["pass"];

if (strlen($pass) < MIN_PASS_SYMBOLS or strlen($pass) > MAX_PASS_SYMBOLS) {
    mysqli_close($conn);
    header("HTTP/1.1 .'$errors[3]'");
    die (json_encode(["error" => "$errors[3]"]));
}


checkUserInfo($login, $conn, $errors);
$hash = password_hash($pass, PASSWORD_DEFAULT);
$query = mysqli_query($conn, "INSERT INTO users_list (login, pass, hash) VALUES ('$login', '$pass', '$hash')");
require 'logout.php';
mysqli_close($conn);


/**
 * @param $login
 * @param $pass
 * @param $conn
 * @param $errors
 */
function checkUserInfo($login, $conn, $errors)
{
    $found = mysqli_query($conn, "SELECT * FROM users_list WHERE `login`= '$login'");
    $found = mysqli_fetch_assoc($found);

    if ($found["login"] != null) {
        header("HTTP/1.1 .'$errors[2]'");
        echo json_encode(["error" => "$errors[2]"]);
        mysqli_close($conn);
        exit();
    }

    if (strlen($login) > MAX_LOGIN_SYMBOLS) {
        header("HTTP/1.1 .'$errors[4]'");
        echo json_encode(["error" => "$errors[4]"]);
        mysqli_close($conn);
        exit();
    }
}

?>