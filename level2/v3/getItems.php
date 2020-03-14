<?php
if (!isset($_SESSION)) {
    session_start();
}

$errorStatuses = ["500 Internal Server Error", "400 Bad Request", "401 Unauthorized"];
require_once 'connection.php';

if (isset($_SESSION["hash"]) && $_SESSION["status"] === "ok") {
    $hash = $_SESSION["hash"];

    $found = $conn->query("SELECT * FROM users_list WHERE `hash`= '$hash'");
    $found = mysqli_fetch_array($found);

    if ($found !== null && $found["id"]) {
        $result = $conn->query("SELECT * FROM todo_list", MYSQLI_STORE_RESULT);
        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        $data = ["items" => $data];
        echo json_encode($data);
    }

    else {
        showError ($errorStatuses[0]);
    }

}

else {
    showError ($errorStatuses[2]);
}


function showError ($status) {
    $message = ["error" => $status];
    die (json_encode($message));
}

mysqli_close($conn);
?>