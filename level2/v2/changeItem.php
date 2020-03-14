<?php
if (!isset($_SESSION)) {
    session_start();
}

$errors = ["500 Internal Server Error", "456 Unrecoverable Error", "401 Unauthorized", "400 Bad Request"];
$inputData = file_get_contents("php://input");
$inputData = json_decode($inputData, true);

if (isset($_SESSION["status"]) && $_SESSION["status"] === "ok") {

    if (isset($inputData["id"]) and isset($inputData["text"]) and isset($inputData["checked"])) {
        $id = $inputData ["id"];
        $text = $inputData ["text"];
        $flag = $inputData ["checked"];

    } else {
        showError($errors[1]);
    }

    if (!is_numeric($id) || !is_string($text)) {
        showError($errors[1]);
    }

} else {
    showError($errors[2]);
}

require_once 'connection.php';
$found = $conn->query("SELECT `id` FROM todo_list WHERE `id`= '$id'");

if (mysqli_num_rows($found) <= 0) {
    showError($errors[3]);
}

if (!$flag) {
    $flag = "0";
}

$result = $conn->query("UPDATE todo_list SET `text` =  '$text',  `checked` =  '$flag'  WHERE `id`= '$id'");

if ($result) {
    header("HTTP/1.1 200 OK");
    echo json_encode(["ok" => true]);
}

else {
    showError($errors[0]);
}

mysqli_close($conn);

function showError ($message) {
    header($message);
    die(json_encode(["error" => $message]));
}
?>