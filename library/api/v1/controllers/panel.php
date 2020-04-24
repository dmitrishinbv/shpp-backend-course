<?php
if (!isset($_SESSION)) {
    session_start();
}

Class Controller_Panel Extends Controller_Base
{

    public $layouts = 'panel'; // name of view-layout

    function index()
    {
        $model = new Model_Panel();
        $page = (empty($_SESSION['page']) ? 1 : $_SESSION['page']);
        $data = $model->getEntries($page);
        $totalPages = $model->getTotalPages();
        $pages = $model->getPages($page);
        $this->template->vars('panel', ['data' => $data, 'totalPages' => $totalPages, 'pages' => $pages]);
        $this->template->view('panel');
    }
}