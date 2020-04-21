<?php

class Model_Search
{
    public function getSearchResults() {
        require_once(SITE_PATH . 'models/Database.php');
        if (!empty($_SESSION) && isset($_SESSION['searchText'])) {
            $queryText = strtolower(htmlentities($_SESSION['searchText']));
        }
        $db = Database::getInstance();
        $table = $db->getBooksTableName();

        return $db->select("SELECT * FROM $table WHERE `name` LIKE ? OR `authors` LIKE ? AND `delflag` = 0",
            ['%'.$queryText.'%', '%'.$queryText.'%']);
    }

}