<?php
require_once '../constants.php';
require_once SITE_PATH. '/models/Database.php';
require_once SITE_PATH. '/models/model.php';

$db = Database::getInstance();
$db_user = Model::getUserName();
$db_name = Model::getDbName();
$db_password = Model::getPass();
$backup_folder = '/home/'.$db_user.'/site_backups';    // where will the files be saved
$backup_name = 'my_site_backup_' . date("Y-m-d");    // archive file name
$dir =  '/home/'.$db_user.'/library';    // what backup
$delay_delete = 30 * 24 * 3600;    // archive lifetime (in seconds)

$deleteOld = deleteOldArchives($backup_folder, $delay_delete);
$doBackupFiles = backupFiles($backup_folder, $backup_name, $dir);
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
    // find file paths matching the pattern
    $files = glob($backup_folder . '/'.'*.tar.gz*');
    $deleted = [];
    foreach ($files as $file) {
        if ($this_time - filemtime($file) > $delay_delete) {
            array_push($deleted, $file);
            unlink($file); //delete file
        }
    }
    return $deleted;
}
