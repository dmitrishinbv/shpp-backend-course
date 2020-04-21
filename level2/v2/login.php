<?php
define("HASH_LENGTH", 50);

if (!isset($_SESSION)) {
    session_start();
}
$userInfo = file_get_contents("php://input");
//$userInfo = file_get_contents("user.json");
$errors = ["500 Internal Server Error", "400 Bad Request", "456 Unrecoverable Error", "Error. Such user not found!",
    "Error. Username and password don't match!"];


if ($userInfo) {
    $userInfo = json_decode($userInfo, true);

    if (count($userInfo) !== 2 || !isset($userInfo["login"]) || !isset($userInfo["pass"])) {
        showError($errors[1]);
}
        $login = $userInfo ["login"];
        $pass = $userInfo ["pass"];

} else {
    showError($errors[0]);
}

require_once 'connection.php';

$found = $conn->query("SELECT * FROM users_list WHERE `login`= '$login'");
$found = mysqli_fetch_array($found);

if (!$found) {
    showError($errors[3]);
}

if ($found['pass'] !== $pass) {
    showError($errors[4]);
}

$hash = md5(generateCode(HASH_LENGTH));
$setHash = $conn->query("UPDATE users_list SET `hash`='$hash' WHERE `login`= '$login'");
$_SESSION['hash']= $hash;

if ($found["id"]) {
    setcookie("user_id", $found['id'], time() + 30 * 24 * 60 * 60);
    $_COOKIE['user_id'] = $found['id'];
}

    include_once "check.php";


function generateCode($length) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $codeLength = strlen($chars) - 1;

    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$codeLength)];
    }

    return $code;
}


function showError($message)
{
    header($message);
    die(json_encode(["error" => $message]));
}

mysqli_close($conn);
?>