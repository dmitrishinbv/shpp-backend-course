<?php

define("MIN_PASS_SYMBOLS", 3);
define("MAX_PASS_SYMBOLS", 30);
define("MAX_LOGIN_SYMBOLS", 40);

require_once 'connection.php';

$userInfo = $_SESSION['data'];
$userInfo = json_decode($userInfo, true);

$errors = ["Error 400. Bad Request",
    "Error. User with this name is already registered!",
    "Error. Password length is incorrect! The password length must be from " . MIN_PASS_SYMBOLS .
     " to " . MAX_PASS_SYMBOLS . " symbols",
    "Error. Max login length is " . MAX_LOGIN_SYMBOLS . " symbols"];


if (count($userInfo) !== 2 or !isset($userInfo["login"]) or !isset($userInfo["pass"])) {
    showError ($errors[0]);
}

$login = $userInfo ["login"];
$pass = $userInfo ["pass"];

if (strlen($pass) < MIN_PASS_SYMBOLS or strlen($pass) > MAX_PASS_SYMBOLS) {
    showError ($errors[2]);
}


checkUserInfo($login, $pdo, $errors);
$hash = password_hash($pass, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users_list (login, pass, hash) VALUES (:name, :pass, :hash)");

$stmt -> bindParam(':name', $login);
$stmt -> bindParam(':pass', $pass);
$stmt -> bindParam(':hash', $hash);
$stmt -> execute();
require_once 'logout.php';


function checkUserInfo($login, $pdo, $errors)
{
    $stmt = $pdo->prepare("SELECT * FROM users_list where login = ?");

    if ($stmt->execute([$login])) {
        $row = $stmt->fetch();
        if($row) {
            showError ($errors[1]);
        }
    }

    if (strlen($login) > MAX_LOGIN_SYMBOLS) {
        showError ($errors[3]);
    }
}

function showError ($status) {
    header("HTTP/1.1 .'$status'");
    $message = ["error" => $status];
    die (json_encode($message));
}
?>