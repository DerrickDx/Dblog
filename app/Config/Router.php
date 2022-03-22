<?php

declare(strict_types=1);

namespace App\Config;

use App\Controller\BaseController;
use App\Controller\CommentController;
use App\Controller\PostController;
use App\Controller\UserController;

class Router
{
    private array $routes;

    public function __construct(private Container $container)
    {
//        $this->registerRoutes();
        $this->registerRoutesFromAttributes(
            [
                BaseController::class,
                PostController::class,
                UserController::class,
                CommentController::class
            ]
        );
    }

    public function registerRoutesFromAttributes(array $controllers)
    {
        foreach ($controllers as $controller) {
            // The ReflectionClass class reports information about a class
            $reflectionController = new \ReflectionClass($controller);
            foreach ($reflectionController->getMethods() as $method) {
                $attrs = $method->getAttributes(Route::class);
                foreach($attrs as $attr) {
                    $route = $attr->newInstance();

                    $this->register($route->method, $route->routePath, [$controller, $method->getName()]);
                }
            }
        }

    }

    public function register(string $requestMethod, string $route, array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }



    public function get(string $route, callable|array $action): self
    {
        return $this->register('GET', $route, $action);
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register('POST', $route, $action);
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];

        $action = $this->routes[$requestMethod][$route] ?? null;


        if (! $action) {

            return call_user_func_array([new BaseController(), 'errorPage'], []);
        }

        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)) {

//                $class = new $class();
                $class = $this->container->get($class);

                if (method_exists($class, $method)) {

                    return call_user_func_array([$class, $method], []);
                }
            }
        }

        throw new \Exception();
    }

    public function registerRoutes()
    {
        $this->get('/', [BaseController::class, 'index']);
        $this->get('/blog', [PostController::class, 'getBLogPostList']);
        $this->get('/blog/post', [PostController::class, 'getBlogPost']);
        $this->post('/blog/addComment', [CommentController::class, 'addBlogComment']);
        $this->get('/admin', [UserController::class, 'admin']);
        $this->get('/admin/login', [UserController::class, 'login']);
        $this->post('/admin/userLogin', [UserController::class, 'userLogin']);
        $this->get('/admin/logout', [UserController::class, 'logout']);
        $this->get('/admin/createUser', [UserController::class, 'createUser']);
        $this->post('/admin/user/add', [UserController::class, 'addeUser']);
        $this->get('/admin/updateUser', [UserController::class, 'updateUser']);
        $this->post('/admin/user/edit', [UserController::class, 'editUser']);
        $this->post('/admin/removeUser', [UserController::class, 'removeUser']);
        $this->get('/admin/post/add', [PostController::class, 'addPost']);
        $this->post('/admin/createPost', [PostController::class, 'createPost']);
        $this->get('/admin/updatePost', [PostController::class, 'updatePost']);
        $this->post('/admin/post/edit', [PostController::class, 'editPost']);
        $this->post('/admin/removePost', [PostController::class, 'removePost']);
        $this->post('/admin/removeComment', [CommentController::class, 'removeComment']);
        $this->post('/admin/updateComment', [CommentController::class, 'updateComment']);
    }
}