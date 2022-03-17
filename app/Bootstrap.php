<?php

use App\Config\Router;
use App\Controller\BaseController;
use App\Controller\CommentController;
use App\Controller\PostController;
use App\Controller\UserController;

require_once 'Config/Config.php';
require_once 'Config/Helper.php';


//echo "Boostrap! <br />";
date_default_timezone_set('Australia/Adelaide');

spl_autoload_register(function ($className) {
//    echo 'At spl_autoload_register' . '<br />';

    $thepath =  dirname(__DIR__) . '/'  . lcfirst(str_replace('\\', '/', $className)) . '.php';
//    echo $thepath . '<br />';
//    echo 'className: '. $className . '<br />';
    require_once $thepath;
//    require_once 'Config/'. $className . '.php';
});

$router = new Router();
//
$router
    ->get('/', [BaseController::class, 'index'])
    ->get('/users', [UserController::class, 'index'])
    ->get('/posts', [PostController::class, 'index'])
    ->get('/posts/details', [PostController::class, 'getSinglePost'])
    ->post('/comments/add', [CommentController::class, 'addComment']);


//print_r('REQUEST_URI: ' . $_SERVER['REQUEST_URI']. '<br/>');
echo $router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
