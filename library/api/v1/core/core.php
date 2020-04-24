<?php
// class loading "on the fly"
spl_autoload_register(function ($className) {
    $filename = strtolower($className) . '.php';
    $expArr = explode('_', $className);

    if (empty($expArr[1]) || $expArr[1] == 'Base') {
        $folder = 'classes';

    } else {
        switch (strtolower($expArr[0])) {
            case 'controller':
                $folder = 'controllers';
                break;

            case 'model':
                $folder = 'models';
                break;

            default:
                $folder = 'classes';
                break;
        }
    }
    $file = SITE_PATH . $folder . DIRECTORY_SEPARATOR . $filename;

    if (file_exists($file) == false) {
        return false;
    }
    include($file);
});