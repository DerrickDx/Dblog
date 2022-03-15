<?php

namespace App\Controller;

use App\Model\User;
use App\Service\UserService;
use App\Config\Database;

class UserController extends BaseController
{
    public function index()
    {

        $results = (new User())->getUserList();
        print_r($results);

    }
}