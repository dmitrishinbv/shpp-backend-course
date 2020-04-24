<?php

Class Router
{

    private $path;
    private $args = [];

    function __construct()
    {
    }

    // set the path to the folder with the controllers
    function setPath($path)
    {
        $path .= DIRECTORY_SEPARATOR;
        // if the path does not exist, signal this
        if (is_dir($path) == false) {
            throw new Exception ('Invalid controller path: `' . $path . '`');
        }
        $this->path = $path;
    }

    // controller and action definition
    private function getController(&$file, &$controller, &$action, &$args)
    {
        $parts = explode('/', $_SERVER['REQUEST_URI']);
        // delete from url first part - "library"
        array_shift($parts);
        $cmd_path = $this->path;
        $fullpath = $cmd_path . $parts[1];

        if (is_dir($fullpath)) {
            $cmd_path .= $parts[1];
        }
        // used for search page
        $uri = (!empty($_POST) && !empty($_POST['search'])) ? 'search' : $parts[1];
        // used for page "/"
        if (empty ($uri)) {
            $controller = $action = 'index';
        }
        else {
            switch ($uri) {
                case ('index.php'):
                    $controller = $action = 'index';
                    break;
                case 'book':
                    $controller = 'book';
                    $action = 'id';
                    $_SESSION['book_id'] = (int)htmlentities($parts[2]);
                    break;
                case 'search':
                    $controller = 'search';
                    $action = 'query';
                    $_SESSION['searchText'] = htmlentities($_POST['search']);
                    unset($_POST['search']);
                    break;
                case 'admin':
                    $controller = 'panel';
                    $action = 'index';
                    break;
                default:
                    Server::responseCode(404);
            }
         }
        // get the full path to the php-file with the controller
        $file = $cmd_path . $controller . '.php';
        $this->args = $parts;
    }


    function start()
    {
        // analyze the way
        $this->getController($file, $controller, $action, $args);
        // check file existence, otherwise 404
        if (!file_exists($file) || !is_readable($file)) {
            Server::responseCode(404);
        }

        include($file);
        $class = 'Controller_' . $controller; // create an instance of the controller
        $controller = new $class();

        // if the action does not exist - 404
        if (is_callable(array($controller, $action)) == false) {
            echo "is_callable $action";
            Server::responseCode(404);
        }

        $controller->$action();
    }
}
