<?php

use App\Config\Router;
use App\Controller\BaseController;
use App\Controller\CommentController;
use App\Controller\BlogController;
use App\Controller\UserController;

require_once 'Config/Config.php';
require_once 'Config/Helper.php';



date_default_timezone_set('Australia/Adelaide');
session_start();
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
    ->get('/blog', [BlogController::class, 'index'])
    ->get('/blog/post', [BlogController::class, 'getSinglePost'])
    ->post('/blog/post/addCommand', [BlogController::class, 'addComment'])
    ->get('/admin', [UserController::class, 'index'])
    ->post('/admin/login', [UserController::class, 'login'])
    ->get('/admin/logout', [UserController::class, 'logout'])
    ->get('/admin/getPosts', [BlogController::class, 'getPostList']);


//print_r('REQUEST_URI: ' . $_SERVER['REQUEST_URI']. '<br/>');
echo $router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
