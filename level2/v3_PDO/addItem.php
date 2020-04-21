<?php
if(!isset($_SESSION)){
    session_start();
}

require_once 'connection.php';
$errorStatuses = ["500 Internal Server Error", "400 Bad Request", "401 Unauthorized"];

$inputData = $_SESSION['data'];
$inputData = json_decode($inputData, true);
//$inputData = json_decode(file_get_contents("input.json"), true);

if (isset($_SESSION["status"]) && $_SESSION["status"] === "ok") {

    if (isset($inputData["text"])) {
        $text = $inputData["text"];
        $stmt = $pdo->prepare("INSERT INTO todo_list (text) VALUES (:text)");
        $stmt -> bindParam(':text', $text);
        $stmt -> execute();

        $id = $pdo->lastInsertId();

        if (!$id !== 0) {
            header("HTTP/1.1 200 OK");
            echo json_encode(["id" => $id]);
         //   exit();

        } else {
            showError("Sorry, it is not possible to add this record to the table!");
        }
    }

    else {
        showError($errorStatuses[1]);
    }
}

else {
    showError($errorStatuses[2]);
}

function showError ($message) {
    header("HTTP/1.1 .'$message'");
    exit(json_encode(["error" => $message]));
}
?>