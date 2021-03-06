<?php
if (!isset($_SESSION)) {
    session_start();
}

$userInfo = $_SESSION['data'];
$errors = ["Error 500. Internal Server Error",
    "Error 400. Bad Request",
    "Error. Such user not found!",
    "Error. Username and password don't match!"];

if ($userInfo) {
    $userInfo = json_decode($userInfo, true);

    if (count($userInfo) !== 2 or !isset($userInfo["login"]) or !isset($userInfo["pass"])) {
        showError ($errors[1]);
    }

    $login = $userInfo ["login"];
    $pass = $userInfo ["pass"];

} else {
    showError ($errors[0]);
}

require_once 'connection.php';

$stmt = $pdo->prepare("SELECT * FROM users_list where login = ?");

$stmt->execute([$login]);

if ($row = $stmt->fetch()) {
    $found_id = $row["id"];
    $found_login = $row["login"];
    $found_pass = $row["pass"];
    $found_hash = $row["hash"];
}

else {
    showError ($errors[2]);
}

if ($found_pass !== $pass) {
    showError ($errors[3]);
}

$hash = md5(generateCode(50));
$_SESSION['hash'] = $hash;

$stmt = $pdo->prepare("UPDATE users_list SET hash = ? WHERE login = ?");
$stmt->execute([$hash, $login]);

setcookie("user_id", $found_id, time() + 30 * 24 * 60 * 60);
$_COOKIE['user_id'] = $found_id;

include_once "checkAuth.php";

function generateCode($length)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $codeLength = strlen($chars) - 1;

    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0, $codeLength)];
    }

    return $code;
}

function showError ($message) {
    header("HTTP/1.1 .$message");
    exit(json_encode(["error" => $message]));
}
?>