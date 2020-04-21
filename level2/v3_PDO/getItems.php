<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once 'connection.php';

if (isset($_SESSION["hash"]) && $_SESSION["status"] === "ok") {
    $hash = $_SESSION["hash"];

    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt = $pdo->prepare("SELECT * FROM users_list where hash = ?");

    if ($stmt->execute([$hash])) {
        $result = $pdo->prepare("SELECT * FROM todo_list");
        $result->execute();
        $data = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $row["checked"] = ($row["checked"] == 0) ? false : true;
            $data[] = $row;
        }

        $data = ["items" => $data];
        echo json_encode($data);
    }
} else {
    $message = ["error" => "401 Unauthorized"];
    die (json_encode($message));
}
?>