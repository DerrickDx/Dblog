<?php

namespace App\Controller;

use App\View\View;

class UserController extends BaseController
{
    public function createUser(): View
    {
        $_SESSION['tab'] = self::USER_ACTION;
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = ['username' => trim($_POST['username']), 'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT)];
            if (!$this->userModel->getUserByName($data['username'])) {
                if ($this->userModel->createUser($data)){
                    header('location: '.URLROOT.'admin');
                    return $this->admin();
                } else {
                    return View::make('admin/user/add');
                }
            } else {
                return View::make('admin/user/add');
            }
        } else {
            return View::make('admin/user/add');
        }
    }

    public function updateUser(): View
    {
        $_SESSION['tab'] = self::USER_ACTION;
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = ['username' => trim($_POST['username']),
                'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
                'id' => trim($_POST['user_id']),];
//            if (!$this->userModel->getUserByName($data['username'])) {
                if ($this->userModel->updateUser($data)) {
                    if ($_SESSION['user_id'] == trim($data['id'])) {
                        return $this->logout();
                    } else {
                        header('location: ' . URLROOT . 'admin');
                        return $this->admin();
                    }
                } else {

                    $result = $this->userModel->getUserById($data['id']);
                    return View::make('admin/user/update', ["user" =>$result]);
                }
//            }else {
//                $result = $this->userModel->getUserById($data['id']);
//                return View::make('admin/user/update', ["user" =>$result]);
//            }
        } else {
            $user_id = ($_GET['id']);
            if ($user_id && is_numeric($user_id) ) {
                $result = $this->userModel->getUserById($user_id);
                return View::make('admin/user/update', ["user" =>$result]);
            } else {
                return $this->errorPage();
            }
        }
    }


    public function removeUser(): View
    {
        $user_id = ($_POST['user_id']);
        $_SESSION['tab'] = self::USER_ACTION;
        if ($user_id && is_numeric($user_id) ) {
            $this->userModel->removeUser(intval($user_id));

            header('location: '.URLROOT.'admin');
            return $this->admin();
        } else {
            return $this->errorPage();
        }
    }


    public function admin() : View
    {
        if ($this->checkLogInStatus()) {
//            return View::make('admin/index', ['users' =>$userList]);
            return View::make('admin/index', $this->fetchAdminDisplayedData());
        }
//        echo "checkLogInStatus false <br>";

        return View::make('admin/login');
//        return View::make('admin/index', ['foo' => 'bar']);

    }

    public function logout(): View
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['tab']);
        header('location: '.URLROOT.'admin');
        return $this->admin();
    }

    public function createUserSession($data)
    {
        $_SESSION['user_id'] = $data->id;
        $_SESSION['user_name'] = $data->username;
        $_SESSION['tab'] = self::USER_ACTION;
    }

    public function checkLogInStatus() {
        return isset($_SESSION['user_id']);
    }

    public function login(): View
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
            header('location: '.URLROOT.'admin');
            return View::make('admin/index', $this->fetchAdminDisplayedData());
        }
//        return View::make('admin/login');
        header('location: '.URLROOT.'admin');
        return $this->admin();
    }


    public function fetchAdminDisplayedData(): array
    {
        $userList = $this->userModel->getUserList();
        $postList = $this->postModel->getPostList();
        $commentList = $this->commentModel->getCommentList();



        $data = ['users' => $userList, 'posts' => $postList, 'comments' => $commentList, 'source' => $_SESSION['tab']];
        return $data;
    }


}