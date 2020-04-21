<?php
// контролер
Class Controller_Index Extends Controller_Base {
	
	public $layouts = 'main_page';
	
	function index() {
        $model = new Model_Mainpage();
        $books= $model->getLibraryEntries();
        $this->template->vars('books', $books);
	    $this->template->view('index');
	}
	
}