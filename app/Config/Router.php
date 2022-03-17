<?php

declare(strict_types=1);

namespace App\Config;

use App\Attributes\Route;
use App\Controller\BaseController;

class Router
{
    private array $routes;


    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }



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

    public function resolve(string $requestUri, string $requestMethod)
    {
//        var_dump($_GET);
//        echo '<br/>';
//        var_dump($_POST);
//
//        $params = [];
//        if ($_GET) {
//            $params = $_GET;
//        } else if ($_POST){
//            $params = $_POST;
//        }
//        var_dump($params);
//        echo '$requestMethod:' . $requestMethod .'<br/>';
//        echo '$requestUri:' . $requestUri .'<br/>';
        $route = explode('?', $requestUri)[0];
//        echo '  ! route:  ' . $route .'<br/>';
//        print_r($route);
//        echo '<br/>';
////        echo '$route - RequestMethod:  ' . $this->routes[$requestMethod] .'<br/>';
//        print_r($this->routes[$requestMethod] );
//        echo '<br/>';
        $action = $this->routes[$requestMethod][$route] ?? null;
//        echo 'action!!!: ' .'<br/>' ;
//        print_r($action );
//        echo '<br/>';

        if (! $action) {

//            throw new \Exception();
//            throw new RouteNotFoundException();
//            throw new CustomizedExceptions(EXC_MSG_ROUTE_NOT_FOUND);
//            echo EXC_MSG_ROUTE_NOT_FOUND;
            return call_user_func_array([new BaseController(), 'errorPage'], []);
        }

        if (is_callable($action)) {
            echo '<br/>';

            return call_user_func($action);
        }

        if (is_array($action)) {
            [$class, $method] = $action;
//            print_r($action);
//            echo '<br/>';
//            print_r($class);
//            echo '<br/>';
//            print_r($method);
//            echo '<br/>';
            if (class_exists($class)) {
                $class = new $class();

                if (method_exists($class, $method)) {
//                    print_r($class);
//                    echo '<br/>';
//                    print_r($method);
//                    echo '<br/>';
//                    echo '<br /> params:';
//                    print_r($params);
//                    print_r($params['id']);
                    return call_user_func_array([$class, $method], []);
                }
            }
        }

        throw new \Exception();
    }
}