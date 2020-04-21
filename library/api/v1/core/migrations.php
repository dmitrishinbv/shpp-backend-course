<?php
require_once SITE_PATH . 'models/Database.php';
define('DB_TABLE_VERSIONS', 'versions');
define('SQL_FILES_PATH', 'migrations');
error_reporting(E_ALL);

class Migrations
{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Получаем список файлов для миграций
    function getMigrationFiles()
    {
        // Находим папку с миграциями
        $sqlFolder = str_replace('\\', DIRECTORY_SEPARATOR,
                realpath(dirname(__FILE__, 2)) . DIRECTORY_SEPARATOR) . SQL_FILES_PATH . DIRECTORY_SEPARATOR;
         // Получаем список всех sql-файлов
        $allFiles = glob($sqlFolder . '*.sql');
        $tableName = DB_TABLE_VERSIONS;
        // Проверяем, есть ли таблица versions
        // Так как versions создается первой, то это равносильно тому, что база не пустая
        if ($this->db->query("SHOW TABLES LIKE '$tableName'") == false) {
            // Первая миграция, возвращаем все файлы из папки sql
            return $allFiles;
        }

        // Ищем уже существующие миграции
        $versionsFiles = [];
        // Выбираем из таблицы versions все названия файлов
        $query = sprintf('SELECT `name` FROM `%s`', DB_TABLE_VERSIONS);
        $data = $this->db->select($query, []);
        // Загоняем названия в массив $versionsFiles
        // Не забываем добавлять полный путь к файлу
        foreach ($data as $row) {
            array_push($versionsFiles, $sqlFolder . $row['name']);
        }

        // Возвращаем файлы, которых еще нет в таблице versions
        return array_diff($allFiles, $versionsFiles);
    }


    // Накатываем миграцию файла
    function migrate($file)
    {
        $db_user = Model::getUserName();
        $db_host =  Model::getHostName();
        $db_password = Model::getPass();
        $db_name = Model::getDbName();

        // Формируем команду выполнения mysql-запроса из внешнего файла
        $command = sprintf('mysql -u%s -p%s -h %s -D %s < %s', $db_user, $db_password, $db_host, $db_name, $file);
        // Выполняем shell-скрипт
        shell_exec($command);

        // Вытаскиваем имя файла, отбросив путь
        $baseName = basename($file);
        // Формируем запрос для добавления миграции в таблицу versions
        $query = sprintf('insert into `%s` (`name`) values("%s")', DB_TABLE_VERSIONS, $baseName);
        // Выполняем запрос
        $this->db->query($query);
    }

    function start()
    {
        $files = $this->getMigrationFiles();
        // Проверяем, есть ли новые миграции
        if (empty($files)) {
            if (DISPLAY_MIGRATION_PROCESS_RESULTS) {
                echo 'Ваша база данных в актуальном состоянии';
            }

        } else {
            if (DISPLAY_MIGRATION_PROCESS_RESULTS) {
                echo 'Начинаем миграцию<br /><br />';
            }
            // Накатываем миграцию для каждого файла
            foreach ($files as $file) {
                $this->migrate($file);
                // Выводим название выполненного файла
                if (DISPLAY_MIGRATION_PROCESS_RESULTS) {
                    echo basename($file) . '<br />';
                }
            }

            if (DISPLAY_MIGRATION_PROCESS_RESULTS) {
                echo '<br />Миграция завершена';
            }
        }
    }
}