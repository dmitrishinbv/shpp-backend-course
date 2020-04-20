<?php

define ('DS', DIRECTORY_SEPARATOR); // разделитель для путей к файлам
$sitePath = realpath(dirname(__FILE__) . DS) . DS;
define ('SITE_PATH', $sitePath); // путь к корневой папке сайта

$host = "localhost:3307";
$user = "root";
$password = "admin";
$database = "library";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);

} catch(PDOException $e) {
    die ($e->getMessage());
}