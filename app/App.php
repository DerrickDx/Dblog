<?php

namespace App;

use App\Config\Container;
use App\Config\Database;
use App\Config\Router;
use App\Model\Comment;
use App\Model\Post;
use App\Model\User;
use App\View\View;
use Exception;

class App
{
    private static Database $db;
    private static Container $container;
    public function __construct(protected Router $router, protected array $request)
    {
        static::$db = new Database();
        static::$container = new Container();
//        $this->container->set(User::class, Post::class, Comment::class);
        static::$container->set(User::class, Post::class, Comment::class);
    }

    public static function db(): Database
    {
        return static::$db;
    }

    public function run()
    {
        try {
            echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (Exception $e) {

            print_r($e->getMessage());
            http_response_code(404);

            echo View::make('error/404');
        }
    }


}