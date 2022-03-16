<?php

namespace App\Controller;

use App\Model\User;
use App\View\View;

class UserController extends BaseController
{
    public function index() :View
    {

        $results = (new User())->getUserList();
        foreach ($results as $res) {
            print_r($res);
            print_r('<br />');
        }

//        return View::make('users/index', ['foo' => 'bar']);
        return View::make('users/index', $results);
    }
}