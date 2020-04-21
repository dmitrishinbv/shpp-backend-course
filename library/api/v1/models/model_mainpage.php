<?php
if (!isset($_SESSION)) {
    session_start();
}

class Model_Mainpage
{
    public function getLibraryEntries(){
        require_once(SITE_PATH . 'models/Database.php');
        $db = Database::getInstance();
        $table = $db->getBooksTableName();
        if (is_null($db) || is_null($table)) { Server::responseCode(500); }
        $limit = LIMIT_RES_MAIN_PAGE;
        $page = empty($_SESSION['index_page']) ? 1 : $_SESSION['index_page'];
        $startingLimit = ($page - 1) * $limit;
        $query = "SELECT count(*) FROM $table";
        $res = $db->query($query);

        if ($res) {
            $totalResults = $res->fetchColumn();
            $totalPages = ceil($totalResults / $limit);

        } else $totalPages = 0;

        $_SESSION['total_pages'] = $totalPages;
        return $db->select("SELECT * FROM $table ORDER BY book_id ASC LIMIT $startingLimit, $limit", []);
    }
}