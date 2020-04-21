<?php
$host = "localhost:3307"; 
$user = "root"; 
$password = "admin"; 
$database = "todo";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);

} catch(PDOException $e) {
    die ($e->getMessage());
}

if ($pdo->query('SHOW TABLES LIKE "todo_list"')->rowCount() === 0 ||
    $pdo->query('SHOW TABLES LIKE "users_list"')->rowCount() === 0) {
    require_once "createTables.php";
}

?>