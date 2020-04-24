<?php

class Model_Mainpage
{

    private $limit = LIMIT_RES_MAIN_PAGE;
    private $db;
    private $booksTable;

    public function __construct()
    {
        require_once(SITE_PATH . 'models/Database.php');
        $this->db = Database::getInstance();
        $this->booksTable = $this->db->getBooksTableName();
    }

    public function getLibraryEntries($page)
    {
        $startingLimit = ($page - 1) * $this->limit;
        return $this->db->select("SELECT * FROM $this->booksTable WHERE `delflag` = 0 
ORDER BY book_id ASC LIMIT $startingLimit, $this->limit", []);
    }


    public function getPages($page)
    {
        $pages['current'] = $page;
        $prevpage = ($page == 1) ? 1 : $page - 1;
        $pages += ['prev' => $prevpage];
        $nextpage = ($page == $this->getTotalPages()) ? $page : $page + 1;
        $pages += ['next' => $nextpage];
        unset($_SESSION['index_page']);
        return $pages;
    }


    function getTotalPages()
    {

        $query = "SELECT count(*) FROM $this->booksTable";
        $res = $this->db->query($query);

        if ($res) {
            $total_results = $res->fetchColumn();
            return ceil($total_results / $this->limit);

        } else return 0;
    }
}