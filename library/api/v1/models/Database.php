<?php

class Database
{
    private $booksTableName = BOOKS_TABLE_NAME;
    private $usersTableName = USERS_TABLE_NAME;
    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function insert($sql, $param)
    {
        $query = $this->connect()->prepare($sql);
        $query->execute($param);
        if (!$query) {
            Server::responseCode(500);
        }
        return true;
    }


    public function getBooksTableName()
    {
        return $this->booksTableName;
    }


    public function getUsersTableName()
    {
        return $this->usersTableName;
    }


    public function select($sql, $param)
    {
        $query = $this->connect()->prepare($sql);
        $query->execute($param);
        if (!$query) {
            Server::responseCode(500);
        }
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    public function query($sql)
    {
        return $this->connect()->query($sql);

    }

    public function update($sql, $param)
    {
        $query = $this->connect()->prepare($sql);
        $query->execute($param);
        if (!$query) {
            Server::responseCode(500);
        }
        return true;
    }

    /**
     * creates database table with books (if table not exists and migration process not used)
     */
    public function install()
    {
        $tableName = $this->booksTableName;
        if ($this->connect()->query("SHOW TABLES LIKE '$tableName'") == false) {
            $booksListColumns = "book_id INT(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL, authors VARCHAR(400), description TEXT, year YEAR(4), image LONGBLOB,
            visits INT(3) NOT NULL DEFAULT 0, clicks INT(3) NOT NULL DEFAULT 0, inuse BOOLEAN NOT NULL DEFAULT 0,
            delflag BOOLEAN NOT NULL DEFAULT 0";
            $query = $this->connect()->exec("CREATE TABLE $tableName ($booksListColumns)
ENGINE=MyISAM DEFAULT CHARSET=utf8");
            if (!$query) {
                Server::responseCode(500);
            }
        }
        return true;
    }

    private function connect()
    {
        require_once 'model.php';
        $conn = Model::connect();
        if (!$conn) {
            Server::responseCode(500);
        }
        return $conn;
    }
}