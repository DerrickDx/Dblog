<?php
require_once 'Config/Config.php';

spl_autoload_register(function ($className) {
//    echo 'At spl_autoload_register' . '<br />';

    $thepath =  dirname(__DIR__) . '/'  . lcfirst(str_replace('\\', '/', $className)) . '.php';
//    echo $thepath . '<br />';
    require_once $thepath;
});


