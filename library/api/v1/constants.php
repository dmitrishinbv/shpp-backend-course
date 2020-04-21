<?php
$sitePath = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
$adminPath = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR) . '/admin/';
define ('SITE_PATH', $sitePath); // путь к корневой папке api v1 сайта
define ('ADMIN_PATH', $adminPath); // путь к папке api/v1/admin сайта
define ('ADMIN_URL', 'api/v1/admin/'); // url путь к api/v1/admin
define ('BOOKS_TABLE_NAME', 'books');
define ('USERS_TABLE_NAME', 'users');
define ('CONN_CONFIG_FILE', $sitePath. '/config.json'); // конфигурационный файл для настройки подключения базы данных mysql
define('LIMIT_RES_ADMIN_PAGE', 5); // вывод количества книг на одну страницу в админпанеле
define('LIMIT_RES_MAIN_PAGE', 18); // вывод количества книг на одну страницу сайта
define ('USE_MIGRATION', true); // запускать миграции при загрузке главной страницы сайта
define ('DISPLAY_MIGRATION_PROCESS_RESULTS', true); // показать результат выполнения процесса миграций (будет выведено ниже футера главной страницы)