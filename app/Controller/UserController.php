<?php

namespace App\Controller;

use App\Model\User;
use App\View\View;

class UserController extends BaseController
{
    protected User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }


    public function index() : View
    {

        if ($this->checkLogInStatus()) {
            $userList = $this->userModel->getUserList();
            return View::make('admin/index', ['users' =>$userList]);
        }
//        echo "checkLogInStatus false <br>";

        return View::make('admin/login');
//        return View::make('admin/index', ['foo' => 'bar']);

    }

    public function login()
    {

        if ($this->checkLogInStatus()) {
            return View::make('admin/index');
        }
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $loginData = ['username' => trim($_POST['username']), 'password' => trim($_POST['password'])];
//        $pwd_hash = password_hash($loginData['password'], PASSWORD_DEFAULT);
//        $loginData['password'] = $pwd_hash;
        $loginResult = $this->userModel->login($loginData);
        if($loginResult){

//            echo $pwd_hash . '<br>';
            $this->createUserSession($loginResult);
            $userList = $this->userModel->getUserList();
            header('location: '.URLROOT.'admin');
            return View::make('admin/index', ['users' =>$userList]);
        }
//        return View::make('admin/login');
        header('location: '.URLROOT.'admin');
        return $this->index();
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        header('location: '.URLROOT.'admin');
        return $this->index();
    }

    public function createUserSession($data)
    {
        $_SESSION['user_id'] = $data->id;
        $_SESSION['user_name'] = $data->username;
    }

    public function checkLogInStatus() {
        return isset($_SESSION['user_id']);
    }

//    public function checkLogInStatus() {
//        if(isset($_SESSION['user_id'])){
//            echo '<br>';
//            print_r($_SESSION);
//            echo '<br>';
//            return true;
//        } else {
//            return false;
//        }
//    }
}