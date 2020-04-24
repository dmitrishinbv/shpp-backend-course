<?php
$sitePath = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
$adminPath = realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR) . '/admin/';
define('SITE_PATH', $sitePath); // root path for "api/v1"
define('ADMIN_PATH', $adminPath); // root path for "api/v1/admin"
define('ADMIN_URL', 'api/v1/admin/'); // url path for "api/v1/admin"
define('BOOKS_TABLE_NAME', 'books');
define('USERS_TABLE_NAME', 'users');
define('CONN_CONFIG_FILE', $sitePath . '/config.json'); // configuration file to configure the database connection mysql
define('LIMIT_RES_ADMIN_PAGE', 5); // output of the number of books per page in the admin panel
define('LIMIT_RES_MAIN_PAGE', 18); // output of the number of books on one page of the site
define('USE_MIGRATION', false); // start migrations when loading the main page of the site
// show the result of the migration process (will be displayed below the footer)
define('SHOW_MIGRATION_PROCESS_RESULTS', false);