<?php
define("HASH_LENGTH", 50);

if(!isset($_SESSION)){
    session_start();
}

$userInfo = $_SESSION['data'];
$errors = ["Error 500. Internal Server Error", "Error 400. Bad Request", "Error. Such user not found!",
    "Error. Username and password don't match!"];


if ($userInfo) {
    $userInfo = json_decode($userInfo, true);

    if (count($userInfo) !== 2 or !isset($userInfo["login"]) or !isset($userInfo["pass"])) {
        header("HTTP/1.1 .'$errors[1]'");
        showResult($errors[1]);
    }
    $login = $userInfo ["login"];
    $pass = $userInfo ["pass"];

} else {
    header("HTTP/1.1 .'$errors[0]'");
    showResult($errors[0]);
}

require_once 'connection.php';

$found = $conn->query("SELECT * FROM users_list WHERE `login`= '$login'");
$found = mysqli_fetch_array($found);


if (!$found) {
    header("HTTP/1.1 .'$errors[2]'");
    showResult($errors[2]);
}

if ($found['pass'] !== $pass) {
    header("HTTP/1.1 .'$errors[3]'");
    showResult($errors[3]);
}

$hash = md5(generateCode(HASH_LENGTH));
$setHash = $conn->query("UPDATE users_list SET `hash`='$hash' WHERE `login`= '$login'");

$_SESSION['hash'] = $hash;

if ($found["id"]) {
    setcookie("user_id", $found['id'], time() + 30 * 24 * 60 * 60);
    $_COOKIE['user_id'] = $found['id'];
    $session_id = generateSessionId(8);
    setcookie("session_id", $session_id, time() + 30 * 24 * 60 * 60);
    $_COOKIE['session_id'] = $session_id;
}

include_once "checkAuth.php";


function generateCode($length) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $codeLength = strlen($chars) - 1;

    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$codeLength)];
    }

    return $code;
}


function generateSessionId($length) {
    $chars = "0123456789";
    $code = "";
    $codeLength = strlen($chars) - 1;

    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$codeLength)];
    }

    return (int)$code;
}

function showResult ($message) {
    $response = is_null($message) ? ["ok"=> true] : ["error" => $message];
    exit(json_encode([$response]));
}

?>