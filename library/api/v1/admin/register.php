<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    Server::responseCode(405);
}
require_once '../constants.php';
require_once SITE_PATH . '/models/model_books.php';
require_once SITE_PATH . '/core/server.php';
require_once SITE_PATH . '/models/Database.php';

$db = Database::getInstance();
$table = $db->getUsersTableName();

if (!empty($_POST)) {
    if (empty($_POST['nickName']) || empty($_POST['pass'])) {
        Server::responseCode(402);
    }
    $login = trim(htmlentities($_POST['nickName']));
    $pass = trim(htmlentities($_POST['pass']));
    $row = $db->select('SELECT * FROM $table where login = (:login)', ['login' => $login]);

    if (count($row) > 0) {
        echo "<script> alert ('Пользователь с таким именем уже зарегистрирован!');
        window.location ='../../../public/register.html'</script>";
    }

    $passWithHash = password_hash($pass, PASSWORD_BCRYPT);

} else {
    Server::responseCode(500);
}

$db->insert('INSERT INTO ' . $table . ' (login, pass) VALUES (:user_name, :user_pass);',
    ['user_name' => $login, 'user_pass' => $passWithHash]);
$Htuserfile = "/home/dmitrishinbv/library/.htpasswd";
$command = "htpasswd -db $Htuserfile $login $pass";
$res = shell_exec($command);
var_dump($res);
    echo "<script> alert ('Новый пользователь успешно зарегистрирован!');
        window.location ='../../../public/register.html'</script>";