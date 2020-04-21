<?php

class Model
{
    public $conn;

    public function __construct()
    {
        $this->conn = Model::connect();
    }

    public static function connect()
    {
        $conn = json_decode(file_get_contents(CONN_CONFIG_FILE), true);
        $host = htmlentities($conn['host']);
        $user = htmlentities($conn['user']);
        $userPassword = htmlentities($conn['password']);
        $databaseName = htmlentities($conn['database']);
        $charset = htmlentities($conn['charset']);

        $pdo = new PDO("mysql:host=$host; charset=$charset", $user, $userPassword);

        try {
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$databaseName` DEFAULT CHARSET=utf8;
            CREATE USER '$user'@'$host' IDENTIFIED BY '$userPassword';
            GRANT ALL ON `$databaseName`.* TO '$user'@'$host'; FLUSH PRIVILEGES;")
            or die(print_r($pdo->errorInfo(), true));

        } catch (PDOException $e) {
            die('500 Internal Server Error. DB ERROR: ' . $e->getMessage());
        }

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$databaseName; charset=$charset", $user, $userPassword);

        } catch (PDOException $e) {
            die('502 Bad Gateway ' . $e->getMessage());
        }

        return $pdo;
    }

    public static function getUserName()
    {
        $conn = json_decode(file_get_contents(CONN_CONFIG_FILE), true);
        return htmlentities($conn['user']);
    }

    public static function getDbName()
    {
        $conn = json_decode(file_get_contents(CONN_CONFIG_FILE), true);
        return htmlentities($conn['database']);
    }

    public static function getPass()
    {
        $conn = json_decode(file_get_contents(CONN_CONFIG_FILE), true);
        return htmlentities($conn['password']);
    }


    public static function getHostName()
    {
        $conn = json_decode(file_get_contents(CONN_CONFIG_FILE), true);
        return htmlentities($conn['host']);
    }


}