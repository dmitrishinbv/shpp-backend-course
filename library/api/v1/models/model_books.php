<?php
if (!isset($_SESSION)) {
    session_start();
}

class Model_Books
{
    private $db;
    private $table;

    public function __construct()
    {
        require_once(SITE_PATH . 'models/Database.php');
        $this->db = Database::getInstance();
        $this->table = $this->db->getBooksTableName();
    }


    public function addBook($payLoadList)
    {
        $bookName = $payLoadList ['bookName'];
        $authors = (isset($payLoadList['bookAuthors'])) ? $payLoadList['bookAuthors'] : NULL;
        $description = (isset($payLoadList['bookDescription'])) ? $payLoadList['bookDescription'] : NULL;
        $year = (isset($payLoadList['bookYear'])) ? $payLoadList['bookYear'] : NULL;
        $img = (isset($payLoadList['bookImage'])) ? $payLoadList['bookImage'] : NULL;

        $query = $this->db->insert('INSERT INTO ' . $this->table . '
         (`name`, `authors`, `description`, `year`, `image`) 
    VALUES (:book_name, :authors, :description, :book_year, :book_img);',
            ['book_name' => $bookName,
                'authors' => $authors,
                'description' => $description,
                'book_year' => $year,
                'book_img' => $img]);

        if (!$query) {
            Server::responseCode(403);
        }
        return true;
    }

    public function deleteBook($id)
    {
        $currentFlag = $this->db->select("SELECT * FROM  $this->table WHERE book_id = ?;", [$id]);
        if ($currentFlag[0]['delflag'] == 0) {
            $this->db->update("UPDATE  $this->table SET delflag = 1 WHERE book_id = ?;", [$id]);

        } else {
            // if delflag was 1 and admin choice this book to undo delete operation return their delflag to value 0
            $this->db->update("UPDATE  $this->table SET delflag = 0 WHERE book_id = ?;", [$id]);
        }
        return true;
    }


    public function incrementClicks($id)
    {
        $book = $this->db->select("SELECT clicks FROM $this->table WHERE book_id = ?", [$id]);
        if (count($book) != 0) {
            $clicks = htmlentities(++$book[0]['clicks']);
            $query = $this->db->update("UPDATE $this->table SET `clicks`='$clicks' WHERE book_id = ?", [$id]);

            if (!$query) {
                Server::responseCode(500);
            }
        } else {
            Server::responseCode(500);
        }
        return true;
    }


    private function calcVisits($book)
    {
        $visits = htmlentities(++$book[0]['visits']);
        $this->db->update("UPDATE $this->table SET `visits`='$visits' WHERE book_id = ?", [$book[0]['book_id']]);
        return true;
    }


    public function getBookById($id)
    {
        $book = $this->db->select("SELECT * FROM $this->table WHERE book_id = ?", [$id]);
        if (count($book) > 0) {
            $this->calcVisits($book);
        } else {
            Server::responseCode(400);
        }
        return $book;
    }
}