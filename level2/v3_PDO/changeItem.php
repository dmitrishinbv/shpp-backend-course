<?php
if (!isset($_SESSION)) {
    session_start();
}

$errorStatuses = ["Error 500. Internal Server Error", "400 Bad Request", "401 Unauthorized"];

if (!isset($_SESSION['data'])) {
    showResult($errorStatuses[0]);
}

$inputData = $_SESSION['data'];
$inputData = json_decode($inputData, true);

if (isset($_SESSION["status"]) && $_SESSION["status"] === "ok") {
    if (isset($inputData["id"]) and isset($inputData["text"]) and isset($inputData["checked"])) {
        $id = $inputData ["id"];
        $text = $inputData ["text"];
        $flag = (int) $inputData ["checked"];

    } else {
        showResult($errorStatuses[1]);
    }


    if ((int)$id === 0) {
        showResult($errorStatuses[1]);
    }

    require_once 'connection.php';
    $stmt = $pdo->prepare("SELECT * FROM todo_list where id = ?");
    $stmt->execute([$id]);

    if ($row = $stmt->fetch()) {
        $changeEntry = $pdo->prepare("UPDATE todo_list SET text = ?, checked = ? WHERE id = ?");
        $changeEntry->execute([$text, $flag, $id]);
        showResult("ok");

    } else {
        showResult($errorStatuses[1]);
    }

} else {
    showResult($errorStatuses[2]);
}


function showResult($message)
{
    if ($message === "ok") {
        header("HTTP/1.1 200 OK");
        echo json_encode(["ok" => true]);

    } else {
        $result = ["error" => $message];
        die (json_encode($result));
    }
}
?>