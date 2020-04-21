<?php
if (!isset($_SESSION)) {
    session_start();
}
Class Controller_Search Extends Controller_Base {

    public $layouts = 'main_page';

    function index() {
    }

    function query() {
        $model = new Model_Search();
        $results = $model->getSearchResults();
        $this->template->vars('results', $results);
        $this->template->view('search_res');
    }
}
