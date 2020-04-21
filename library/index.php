<?php
error_reporting (E_ALL);

// подключаем константы
require ('api/v1/bootstrap.php');

// Загружаем router
$router = new Router();

// задаем путь до папки контроллеров.
$router->setPath (SITE_PATH . 'controllers');

// запускаем маршрутизатор
$router->start();

// запускаем (если установленно USE_MIGRATION) миграции
if (USE_MIGRATION) {
    $migrations = new Migrations();
    $migrations->start();
}