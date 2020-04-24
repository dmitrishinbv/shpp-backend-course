<?php
require_once SITE_PATH . 'models/Database.php';
define('DB_TABLE_VERSIONS', 'versions');
//define('SQL_FILES_PATH', 'migrations');
define('SQL_FILES_PATH', 'migrations_next_level'); // use this version if you need upgrade your database to next product version
class Migrations
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // get a list of files for migrations
    function getMigrationFiles()
    {
        // find the folder with migrations
        $sqlFolder = str_replace('\\', DIRECTORY_SEPARATOR,
                realpath(dirname(__FILE__, 2)) . DIRECTORY_SEPARATOR) . SQL_FILES_PATH . DIRECTORY_SEPARATOR;
        // get a list of all sql files
        $allFiles = glob($sqlFolder . '*.sql');
        $tableName = DB_TABLE_VERSIONS;
        // Check if there is a version table
        // Since versions is created first, this is equivalent to the fact that the database is not empty
        if ($this->db->query("SHOW TABLES LIKE '$tableName'") == false) {
            return $allFiles;
        }

        // looking for existing migrations
        $versionsFiles = [];
        // select all file names from the versions table
        $query = sprintf('SELECT `name` FROM `%s`', DB_TABLE_VERSIONS);
        $data = $this->db->select($query, []);

        foreach ($data as $row) {
            array_push($versionsFiles, $sqlFolder . $row['name']);
        }

        // returns files that are not yet in the table versions
        return array_diff($allFiles, $versionsFiles);
    }


    // rolls the file migration
    function migrate($file)
    {
        $db_user = Model::getUserName();
        $db_host = Model::getHostName();
        $db_password = Model::getPass();
        $db_name = Model::getDbName();

        $command = sprintf('mysql -u%s -p%s -h %s -D %s < %s', $db_user, $db_password, $db_host, $db_name, $file);
        shell_exec($command);

        // pull out the file name, dropping the path
        $baseName = basename($file);
        // form a request for adding migration to the versions table
        $query = sprintf('insert into `%s` (`name`) values("%s")', DB_TABLE_VERSIONS, $baseName);
        $this->db->query($query);
    }

    function start()
    {
        $files = $this->getMigrationFiles();
        // check if there are new migrations
        if (empty($files)) {
            if (SHOW_MIGRATION_PROCESS_RESULTS) {
                echo 'Ваша база данных в актуальном состоянии';
            }

        } else {
            if (SHOW_MIGRATION_PROCESS_RESULTS) {
                echo 'Начинаем миграцию<br /><br />';
            }
            // roll migration for each file
            foreach ($files as $file) {
                $this->migrate($file);
                if (SHOW_MIGRATION_PROCESS_RESULTS) {
                    echo basename($file) . '<br />';
                }
            }

            if (SHOW_MIGRATION_PROCESS_RESULTS) {
                echo '<br />Миграция завершена';
            }
        }
    }
}