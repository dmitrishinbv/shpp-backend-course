<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'connection.php';

$errors = ["401 Unauthorized", "400 Bad Request"];

if (isset($_SESSION["hash"]) && $_SESSION["status"] === "ok") {
    $hash = $_SESSION["hash"];

    $found = $conn->query("SELECT * FROM users_list WHERE `hash`= '$hash'");
    $found = mysqli_fetch_array($found);

    if ($found !== null && $found["id"]) {
        $result = $conn->query("SELECT * FROM todo_list", MYSQLI_STORE_RESULT);
        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["checked"] == 0) {
                $row["checked"] = false;
            }
            if ($row["checked"] == 1) {
                $row["checked"] = true;
            }
            $data[] = $row;
        }

        header("HTTP/1.1 200 OK");
        $data = ["items" => $data];
        echo json_encode($data);

    } else {
        showError($errors[1]);
    }

} else {
    showError($errors[0]);
}


function showError($message)
{
    header($message);
    die(json_encode(["error" => $message]));
}

mysqli_close($conn);
?>