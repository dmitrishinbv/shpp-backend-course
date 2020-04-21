<?php
if (!isset($_SESSION)) {
    session_start();
}

$errorStatuses = ["Error 500. Internal Server Error", "Error 400. Bad Request", "401 Unauthorized"];

if (!isset($_SESSION["status"]) || $_SESSION["status"] !== "ok") {
    showResult($errorStatuses[2]);
}

if (!isset($_SESSION['data'])) {
    showResult($errorStatuses[0]);
}

$inputData = $_SESSION['data'];
$inputData = json_decode($inputData, true);

if (!isset ($inputData["id"]) || !(int)$inputData["id"] === 0) {
    showResult($errorStatuses[1]);
}

$id = $inputData ["id"];
require_once 'connection.php';
$del = $pdo->prepare("DELETE FROM todo_list where id = ?");
$del->execute([$id]);
$count = $del->rowCount();
$count > 0 ? showResult("ok") : showResult($errorStatuses[1]);


function showResult($message)
{
    if ($message === "ok") {
        header("HTTP/1.1 200 OK");
        echo (json_encode(["ok" => true]));

    } else {
        $result = ["error" => $message];
        die (json_encode($result));
    }
}
?>