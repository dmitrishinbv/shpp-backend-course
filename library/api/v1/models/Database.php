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
        $this->connect()->exec("CREATE TABLE IF NOT EXISTS $tableName (
    `book_id` int(4) unsigned not null auto_increment,
    `name` varchar(400) not null,
    `authors` varchar(400),
    `description` text,
    `year` year (4),
    `image` longblob,
    `visits` INT(4) NOT NULL DEFAULT 0,
    `clicks` INT(4) NOT NULL DEFAULT 0,
    `delflag` BOOLEAN NOT NULL DEFAULT 0,
    primary key (book_id)
    )
    engine = innodb
    auto_increment = 21
    character set utf8
    collate utf8_general_ci;");

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