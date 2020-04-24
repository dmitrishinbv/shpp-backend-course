<?php
$command = sofDelete ();

function sofDelete () {
    $path_length = strrpos(dirname(__FILE__), DIRECTORY_SEPARATOR);
    $path = substr(__FILE__, 0, $path_length) . DIRECTORY_SEPARATOR;
    require_once $path . 'constants.php';
    require_once $path . 'models/Database.php';
    $db = Database::getInstance();
    $table = $db->getBooksTableName();
    $res = $db->update("DELETE FROM $table WHERE delflag = 1;", []);
    return $res;
}
