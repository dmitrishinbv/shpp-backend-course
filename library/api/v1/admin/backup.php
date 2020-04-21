<?php
require_once '../constants.php';
require_once SITE_PATH. '/models/Database.php';
require_once SITE_PATH. '/models/model.php';

$db = Database::getInstance();
$db_user = Model::getUserName();
$db_name = Model::getDbName();
$db_password = Model::getPass();

if (is_null($db) || is_null($db_user) || is_null($db_name) || is_null($db_password)) {
    Server::responseCode(500);
}

$backup_folder = '/home/'.$db_user.'/site_backups';    // куда будут сохранятся файлы
$backup_name = 'my_site_backup_' . date("Y-m-d");    // имя архива
$dir =  '/home/'.$db_user.'/library';    // что бэкапим
$delay_delete = 30 * 24 * 3600;    // время жизни архива (в секундах)

$deleteOld = deleteOldArchives($backup_folder, $delay_delete);    // удаляем старые архивы
$doBackupFiles = backupFiles($backup_folder, $backup_name, $dir);    // делаем бэкап файлов
$doBackupDB = backupDB($backup_folder, $backup_name, $db_user, $db_name, $db_password);


function backupFiles($backup_folder, $backup_name, $dir)
{
    $fullFileName = $backup_folder . '/' . $backup_name . '.tar.gz';
    shell_exec("tar -cvf " . $fullFileName . " " . $dir . '/'. " 2>&1");
    return $fullFileName;
}

function backupDB($backup_folder, $backup_name, $db_user, $db_name, $db_password)
{
    $fullFileName = $backup_folder . '/' . $backup_name . '.sql';
    $command = 'mysqldump -u' . $db_user . ' -p' . $db_password . ' ' . $db_name . ' > ' . $fullFileName.' 2>&1';
    shell_exec($command);
    return $fullFileName;
}

function deleteOldArchives($backup_folder, $delay_delete)
{
    $this_time = time();
    $files = glob($backup_folder . '/'.'*.tar.gz*');
    $deleted = [];
    foreach ($files as $file) {
        if ($this_time - filemtime($file) > $delay_delete) {
            array_push($deleted, $file);
            unlink($file);
        }
    }
    return $deleted;
}
