<?php
spl_autoload_register('autoLoader');

function autoLoader($className) {
    $path = 'classes/';
    $extension = '.class.php';
    $fileName = $path . $className . $extension;

    if(!file_exists($fileName)) {
        return false;
    }

    include_once $path . $className . $extension;
}