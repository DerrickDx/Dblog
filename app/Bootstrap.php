<?php

use App\App;
use App\Config\Container;
use App\Config\Router;

require_once 'Config/Config.php';
require_once 'Config/Helper.php';
require_once __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('Australia/Adelaide');
session_start();
spl_autoload_register(function ($className) {
    $thepath =  dirname(__DIR__) . '/'  . lcfirst(str_replace('\\', '/', $className)) . '.php';
    require_once $thepath;
});

$container = new Container();
$router = new Router($container);


(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]

))->run();