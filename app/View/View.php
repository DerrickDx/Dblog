<?php

declare(strict_types=1);

namespace App\View;

use App\Config\CustomizedExceptions;

class View
{
    public function __construct(protected string $view, protected array $params = [])
    {
    }

    public function renderPage(): string
    {
        $viewPath = VIEW_PATH . '/' . $this->view . '.php';
//        echo 'viewPath: ' . $viewPath;

        if (! file_exists($viewPath)) {
            echo $viewPath . ' does not exist';

            throw new CustomizedExceptions(EXC_MSG_VIEW_NOT_FOUND);
        }

//        foreach ($this->params as $k => $v) {
//            print_r('<br />');
////            print_r($v);
//            if (is_object($v)) {
////                echo "is object";
//            } else {
//                print_r($k . ' - ' . $v);
//                $$k = $v;
//            }
//        }
        ob_start();
        include $viewPath;

        return(string) ob_get_clean();
    }

    public static function make(string $view, array $params = [] ): static
    {
        return new static($view, $params);
    }


    public function __toString(): string
    {
        return $this->renderPage();
    }


    public function __get(string $name)
    {
        return $this->params[$name] ?? null;
    }
}