<?php
if(!isset($_SESSION)){
    session_start();
}

require_once 'connection.php';
$errorStatuses = ["500 Internal Server Error", "400 Bad Request", "401 Unauthorized"];
$inputData = $_SESSION['data'];
$inputData = json_decode($inputData, true);

if (isset($_SESSION["status"]) && $_SESSION["status"] === "ok") {
    if (isset($inputData["text"])) {
        $text = $inputData["text"];
        $query = mysqli_query($conn, "INSERT INTO todo_list (text) VALUES ('$text')");
        $id = mysqli_insert_id($conn);

        if (!$id !== 0) {
            header("HTTP/1.1 200 OK");
            echo json_encode(["id" => $id]);
            exit();

        } else {
            showResult ("Sorry, it is not possible to add this record to the table!", $conn);
        }
    }

    else {
        header("HTTP/1.1 .'$errorStatuses[1]'");
        showResult ($errorStatuses[1], $conn);
    }
}

else {
    header("HTTP/1.1 .'$errorStatuses[2]'");
    showResult ($errorStatuses[2], $conn);
}

function showResult ($message, $conn) {
    mysqli_close($conn);
    exit(json_encode(["error" => $message]));
}
?>