<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once 'connection.php';

$errorStatuses = ["500 Internal Server Error", "400 Bad Request", "401 Unauthorized"];
$inputData = $_SESSION['data'];
$inputData = json_decode($inputData, true);

if (isset($_SESSION["status"]) && $_SESSION["status"] === "ok") {

    if (isset($inputData["id"]) and isset($inputData["text"]) and isset($inputData["checked"])) {
        $id = $inputData ["id"];
        $text = $inputData ["text"];
        $flag = (int)$inputData ["checked"];

    } else {
        showResult($errorStatuses[1], $conn);
    }

    if ((int)$id === 0 || !is_string($text)) {
        showResult($errorStatuses[1], $conn);
    }

    $found = $conn->query("SELECT 'id' FROM todo_list WHERE `id`= '$id'");
    $found = mysqli_fetch_array($found);

    if (!$found) {
        showResult($errorStatuses[1], $conn);
    }
}

else {
    showResult($errorStatuses[2], $conn);
}


$result = $conn->query("UPDATE todo_list SET `text` =  '$text',  `checked` =  '$flag'  WHERE `id`= '$id'");
showResult(null, $conn);

function showResult ($message, $conn) {
    $response = is_null($message) ? ["ok"=> true] : ["error" => $message];
    mysqli_close($conn);
    exit(json_encode([$response]));
}
?>