<?php

Class Controller_Book Extends Controller_Base {

    public $layouts = 'main_page';

    function index() {
    }

    function id() {
        $model = new Model_Books();
        $id = (!empty($_SESSION) && isset($_SESSION['book_id'])) ?
            $_SESSION['book_id'] : Server::responseCode(500);
        $bookInfo = $model->getBookById($id);
        $this->template->vars('info', $bookInfo);
        $this->template->view('bookpage');
    }
}