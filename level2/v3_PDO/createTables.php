<?php
require_once 'connection.php';

define ("DATA_TABLE_NAME", "todo_list");
define ("USERS_TABLE_NAME", "users_list");
define ("MAX_LOGIN_SYMBOLS", 40);
define ("MAX_PASS_SYMBOLS", 30);

$todoListColumns = "id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
text text,
checked BOOLEAN DEFAULT FALSE";

$createTable = $pdo->exec("CREATE TABLE IF NOT EXISTS $database.".DATA_TABLE_NAME." ($todoListColumns)");

$usersListColumns = "id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
login VARCHAR(".MAX_LOGIN_SYMBOLS.") NOT NULL, 
pass VARCHAR(".MAX_PASS_SYMBOLS.") NOT NULL DEFAULT '',
hash text";

$createTable = $pdo->exec("CREATE TABLE IF NOT EXISTS $database.".USERS_TABLE_NAME." ($usersListColumns)");
?>