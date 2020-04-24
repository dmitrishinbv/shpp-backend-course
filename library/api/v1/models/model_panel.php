<?php

class Model_Panel
{

    private $limit = LIMIT_RES_ADMIN_PAGE;
    private $db;
    private $booksTable;

    public function __construct()
    {
        require_once(SITE_PATH . 'models/Database.php');
        $this->db = Database::getInstance();
        $this->booksTable = $this->db->getBooksTableName();
    }


    public function getEntries($page)
    {
        $starting_limit = ($page - 1) * $this->limit;
        return $this->db->select("SELECT * FROM $this->booksTable ORDER BY book_id DESC LIMIT
    $starting_limit, $this->limit", []);
    }

    public function getPages($page)
    {
        $pages['current'] = $page;
        $prevpage = ($page == 1) ? 1 : $page - 1;
        $pages += ['prev' => $prevpage];
        $nextpage = ($page == $this->getTotalPages()) ? $page : $page + 1;
        $pages += ['next' => $nextpage];
        unset($_SESSION['page']);
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