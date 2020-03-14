<?php
session_start();
$inputData = file_get_contents("php://input");
$inputData = json_decode($inputData, true);
$errors = ["500 Internal Server Error", "456 Unrecoverable Error", "401 Unauthorized"];

if (isset($_SESSION["status"]) && $_SESSION["status"] === "ok") {

    if (isset($inputData["text"])) {
        $text = $inputData["text"];
        require_once 'connection.php';
        $query = mysqli_query($conn, "INSERT INTO todo_list (text) VALUES ('$text')");
        if (!$query) {
            showError($errors[0]);
        }

        $id = mysqli_insert_id($conn);
        if (!$id !== 0) {
            header("HTTP/1.1 200 OK");
            echo json_encode(["id" => $id]);

        } else {
            showError($errors[1]);
        }

    } else {
        showError($errors[1]);
    }

} else {
    showError($errors[2]);
}

mysqli_close($conn);

function showError ($message) {
    header($message);
    die(json_encode(["error" => $message]));
}
?>