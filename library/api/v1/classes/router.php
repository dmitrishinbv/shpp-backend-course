<?php

Class Router
{

    private $path;
    private $args = [];

    function __construct()
    {
    }

    // задаем путь до папки с контроллерами
    function setPath($path)
    {
        $path .= DIRECTORY_SEPARATOR;
        // если путь не существует, сигнализируем об этом
        if (is_dir($path) == false) {
            throw new Exception ('Invalid controller path: `' . $path . '`');
        }
        $this->path = $path;
    }

    // определение контроллера и экшена
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

        $uri = (!empty($_POST) && !empty($_POST['search'])) ? 'search' : $parts[1];
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
        $file = $cmd_path . $controller . '.php';
        $this->args = $parts;
    }


    function start()
    {
        // Анализируем путь
        $this->getController($file, $controller, $action, $args);
        // Проверка существования файла, иначе 404
        if (!file_exists($file) || !is_readable($file)) {
            Server::responseCode(404);
        }

        // Подключаем файл
        include($file);

        // Создаём экземпляр контроллера
        $class = 'Controller_' . $controller;
        $controller = new $class();

        // Если экшен не существует - 404
        if (is_callable(array($controller, $action)) == false) {
            echo "is_callable $action";
            Server::responseCode(404);
        }

        $controller->$action();
    }
}
