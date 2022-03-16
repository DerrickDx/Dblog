<?php

declare(strict_types=1);

namespace App\Config;

use App\Attributes\Route;

class Router
{
    private array $routes;


    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

//    public function register(string $route, callable|array $action): self
//    {
//        $this->routes[$route] = $action;
//
//        return $this;
//    }

    public function get(string $route, callable|array $action): self
    {
//        echo 'route:' . $route .'<br/>';
//        print_r($action);
//        echo '<br/>';

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


//    public function resolve(string $requestUri)
//    {
//        $route = explode('?', $requestUri)[0];
//        print_r($route. '<br/>');
//        $action = $this->routes[$route] ?? null;
//        print_r('action: ' .$action. '<br/>');
//        if (! $action) {
//            throw new \Exception();
//        }
//
//        if (is_callable($action)) {
//            return call_user_func($action);
//        }
//
//        if (is_array($action)) {
//            [$class, $method] = $action;
//
//            if (class_exists($class)) {
//                $class = new $class();
//
//                if (method_exists($class, $method)) {
//                    return call_user_func_array([$class, $method], []);
//                }
//            }
//        }
//
//        throw new \Exception();
//    }

    public function resolve(string $requestUri, string $requestMethod)
    {
//        echo '<br/>';
//        echo '$requestMethod:' . $requestMethod .'<br/>';
        $route = explode('?', $requestUri)[0];
//        echo '$route:' . $route .'<br/>';
//        echo '$route:' . $this->routes[$requestMethod] .'<br/>';
        $action = $this->routes[$requestMethod][$route] ?? null;
//        echo 'action!!!: ' .'<br/>' ;
//        print_r($action );
        echo '<br/>';

        if (! $action) {
//            throw new \Exception();
//            throw new RouteNotFoundException();
            throw new CustomizedExceptions(EXC_MSG_ROUTE_NOT_FOUND);
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)) {
                $class = new $class();

                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }
        }

        throw new \Exception();
    }
}