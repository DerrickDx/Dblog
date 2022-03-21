<?php

use App\Config\Router;
use App\Controller\BaseController;
use App\Controller\CommentController;
use App\Controller\PostController;
use App\Controller\UserController;

require_once 'Config/Config.php';
require_once 'Config/Helper.php';

date_default_timezone_set('Australia/Adelaide');
session_start();
spl_autoload_register(function ($className) {

    $thepath =  dirname(__DIR__) . '/'  . lcfirst(str_replace('\\', '/', $className)) . '.php';
    require_once $thepath;
});

$router = new Router();
//
$router
    ->get('/', [BaseController::class, 'index'])
    ->get('/blog', [PostController::class, 'getBLogPostList'])
    ->get('/blog/post', [PostController::class, 'getBlogPost'])
    ->post('/blog/post/addCommand', [CommentController::class, 'addBlogComment'])
    ->get('/admin', [UserController::class, 'admin'])
    ->get('/admin/login', [UserController::class, 'login'])
    ->post('/admin/login', [UserController::class, 'login'])
    ->get('/admin/logout', [UserController::class, 'logout'])
    ->get('/admin/createUser', [UserController::class, 'createUser'])
    ->post('/admin/createUser', [UserController::class, 'createUser'])
    ->get('/admin/updateUser', [UserController::class, 'updateUser'])
    ->post('/admin/updateUser', [UserController::class, 'updateUser'])
    ->post('/admin/removeUser', [UserController::class, 'removeUser'])
    ->get('/admin/createPost', [PostController::class, 'createPost'])
    ->post('/admin/createPost', [PostController::class, 'createPost'])
    ->get('/admin/updatePost', [PostController::class, 'updatePost'])
    ->post('/admin/updatePost', [PostController::class, 'updatePost'])
    ->post('/admin/removePost', [PostController::class, 'removePost'])
    ->post('/admin/removeCommand', [CommentController::class, 'removeComment'])
    ->post('/admin/updateCommand', [CommentController::class, 'updateComment']);


//print_r('REQUEST_URI: ' . $_SERVER['REQUEST_URI']. '<br/>');
echo $router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
