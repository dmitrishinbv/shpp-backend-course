<?php
if (!isset($_SESSION)) {
    session_start();
}

Class Controller_Panel Extends Controller_Base {

    public $layouts = 'panel';

    function index() {
        $model = new Model_Panel();
        $page = (empty($_SESSION['page']) ? 1 : $_SESSION['page']);
        $entries = $model->getEntries($page);
        $totalPages = $model->getTotalPages();
        $this->template->vars('panel', ['entries' => $entries, 'totalPages'=> $totalPages]);
        $this->template->view('panel');
    }
}