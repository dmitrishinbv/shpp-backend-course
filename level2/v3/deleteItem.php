<?php
if (!isset($_SESSION)) {
    session_start();
}

$errors = ["Error 500. Internal Server Error", "Error 400. Bad Request", "Error. Such entry not found!"];

if (!isset($_SESSION['data'])) {
    die (json_encode(["error" => "$errors[0]"]));
}
$data = json_decode($_SESSION['data'], true);

include_once "checkAuth.php";

if (!isset ($data["id"]) || (int)$data["id"] === 0) {
    die (json_encode(["error" => "$errors[1]"]));
}
$id = $data ["id"];

require_once 'connection.php';

$result = $conn->query("DELETE FROM todo_list WHERE `id`= '$id'");

!$result ? die (json_encode(["error" => "$errors[2]"])) : $data = json_encode(["ok" => true]);
mysqli_close($conn);
header("HTTP/1.1 200 OK");
echo $data;
?>