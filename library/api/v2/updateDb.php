<?php
require_once '../v1/constants.php';
require_once SITE_PATH. '/models/Database.php';
require_once SITE_PATH. '/models/model.php';

$db = Database::getInstance();

$authorsTableName = 'authors';
$sql = 'BadTableToGoodTable()';
$query = $db->query($sql);
var_dump($query);
