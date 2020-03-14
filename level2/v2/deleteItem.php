<?php
if (!isset($_SESSION)) {
    session_start();
}

$inputData = file_get_contents("php://input");
$inputData = json_decode($inputData, true);
$errors = ["500 Internal Server Error", "456 Unrecoverable Error", "401 Unauthorized", "400 Bad Request"];

require_once 'connection.php';

if (isset($_SESSION["status"]) && $_SESSION["status"] === "ok") {
    if (!isset ($inputData["id"]) || !is_numeric($inputData["id"])) {
        showError($errors[1]);
    }
    $id = $inputData ["id"];
    $result = $conn->query("DELETE FROM todo_list WHERE `id`= '$id'");

    if (!$result) {
        showError($errors[3]);
    } else {
        header("HTTP/1.1 200 OK");
        echo json_encode(["ok" => true]);
    }

} else {
    showError($errors[2]);
}

mysqli_close($conn);

function showError($message)
{
    header($message);
    die(json_encode(["error" => $message]));
}
?>