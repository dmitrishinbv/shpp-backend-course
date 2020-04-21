<?php
if(!isset($_SESSION)){
    session_start();
}
require_once 'connection.php';

if (isset($_SESSION['hash']) and isset($_COOKIE['user_id'])) {
    $id = $_COOKIE['user_id'];
    $hash = $_SESSION['hash'];
    $stmt = $pdo->prepare("SELECT * FROM users_list where id = ?");

    if ($stmt->execute([$id])) {
        $found = true;
        $row = $stmt->fetch();
        $found_hash = $row["hash"];
    }

    if (!$found) {
        showResult("401 Unauthorized");
    }

    if ($hash !== $found_hash) {
        setcookie("user_id", "", time() - 3600 * 24 * 30 * 12, "/");
        showResult("Session expired!");
    }

    showResult ("ok");

} else {
    showResult("401 Unauthorized");
}


function showResult ($message) {
    if ($message === "ok") {
        header("HTTP/1.1 200 OK");
        $_SESSION["status"] = "ok";
        echo json_encode(["ok" => true]);
    }

    else {
        $result = ["error" => $message];
        die (json_encode($result));
    }
}
?>