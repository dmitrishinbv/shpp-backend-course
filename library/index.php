<?php
error_reporting (E_ALL);

if ($_GET) {
    $uri = key($_GET);
    echo $uri;
}

// подключаем конфиг
include ('api/v1/config.php');

// подключаем ядро сайта
include (SITE_PATH. DS. 'core' . DS . 'core.php');

// Загружаем router
$router = new Router($registry);
// записываем данные в реестр
$registry->set ('router', $router);
// задаем путь до папки контроллеров.
$router->setPath (SITE_PATH . 'controllers');
// запускаем маршрутизатор
$router->start();


//
//else {
//require_once 'app/bootstrap.php';
//
//require "tpl/header.php";
//require "tpl/books-wrapper.php";
//require "tpl/footer.php";
//}


//$query = ($uri = key($_GET)) ? URL . $uri : URL."index.php";
//echo $query;


//(file_exists($fn)) ? require $fn : require 'li/404/index.php';


?>