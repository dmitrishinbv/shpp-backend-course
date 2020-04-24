<?php
require_once 'bootstrap.php';

$db = Database::getInstance();
$table = $db->getUsersTableName();
$data = getUserInfo($db, $table);

if ($data) {
    addUserToDb ($data, $db, $table);
}

function getUserInfo($db, $table)
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        Server::responseCode(405);
    }

    if (!empty($_POST)) {
        if (empty($_POST['nickName']) || empty($_POST['pass'])) {
            Server::responseCode(402);
        }

        $login = trim(htmlentities($_POST['nickName']));
        $pass = trim(htmlentities($_POST['pass']));
        $row = $db->select("SELECT * FROM $table where login = (:login)", ['login' => $login]);

        if (count($row) > 0) {
            echo "<script> alert ('Пользователь с таким именем уже зарегистрирован!');
        window.location ='../../../public/register.html'</script>";
        }

    } else {
        Server::responseCode(500);
    }

    return ['login'=>$login, 'pass'=>$pass];
}

function addUserToDb ($data, $db, $table)
{
    $login = $data['login'];
    $pass = $data['pass'];
    $passWithHash = password_hash($pass, PASSWORD_BCRYPT);

    $db->insert('INSERT INTO ' . $table . ' (login, pass) VALUES (:user_name, :user_pass);',
        ['user_name' => $login, 'user_pass' => $passWithHash]);
    $Htuserfile = "/home/dmitrishinbv/library/.htpasswd";
    $command = "htpasswd -db $Htuserfile $login $pass";
    shell_exec($command);

    echo "<script> alert ('Новый пользователь успешно зарегистрирован!');
        window.location ='../../../public/register.html'</script>";

}