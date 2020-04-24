<?php
if (!isset($_SESSION)) {
    session_start();
}
Class Controller_Index Extends Controller_Base {
	
	public $layouts = 'main_page'; // name of view-layout
	
	function index() {
        $model = new Model_Mainpage();
        $page = (empty($_SESSION['index_page']) ? 1 : $_SESSION['index_page']);
        $data= $model->getLibraryEntries($page);
        $totalPages = $model->getTotalPages();
        $pages = $model->getPages($page);
        $this->template->vars('index', ['data' => $data, 'totalPages' => $totalPages, 'pages' => $pages]);
	    $this->template->view('index');
	}
	
}