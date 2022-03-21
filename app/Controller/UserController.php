<?php

namespace App\Controller;

use App\View\View;
use function Sodium\add;

class UserController extends BaseController
{
    public function createUser(): View
    {
        $_SESSION['tab'] = self::USER_ACTION;
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = ['username' => trim($_POST['username']), 'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT)];
            if (!$this->userModel->getUserByName($data['username'])) {
                $execResult = $this->userModel->createUser($data);
                if ($this->checkExec($execResult)){

                    messageDisplay('User ' . $data['username']. ' Created');
                    header('location: '.URLROOT.'admin');
//                    return $this->admin();
                } else {
                    messageDisplay(message:'Failed. '. $this->getExecInfo($execResult), name:'err_msg');
                    return View::make('admin/user/add');
                }
            } else {
                $params = ['err_msg' => 'User already exits'];
                return View::make('admin/user/add', array_merge($params, $_POST));
            }
        } else {
            return View::make('admin/user/add');
        }
    }

    public function updateUser(): View
    {
        $_SESSION['tab'] = self::USER_ACTION;
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
                'id' => trim($_POST['user_id'])];
            $execResult = $this->userModel->updateUser($data);
            if ($this->checkExec($execResult)) {
                messageDisplay('User ' . trim($_POST['username']). ' Updated');
                if ($_SESSION['user_id'] == trim($data['id'])) {
                    return $this->logout();
                } else {
                    header('location: ' . URLROOT . 'admin');
                }
            } else {
                messageDisplay(message:'Failed. '. $this->getExecInfo($execResult), name:'err_msg');
                $result = $this->userModel->getUserById($data['id']);
                return View::make('admin/user/update', ["user" =>$result]);
            }
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


    public function removeUser()
    {
        $user_id = ($_POST['user_id']);
        $_SESSION['tab'] = self::USER_ACTION;
        if ($user_id && is_numeric($user_id) ) {
           $execResult = $this->userModel->removeUser(intval($user_id));
           if($this->checkExec($execResult)) {
               messageDisplay('User Removed');
           } else {
               messageDisplay(message:'Failed. '. $this->getExecInfo($execResult), name:'err_msg');
           }

            header('location: '.URLROOT.'admin');
        } else {
            return $this->errorPage();
        }
    }


    public function admin() : View
    {
        return $this->adminRedirect();
    }

    public function adminRedirect($params = null): View
    {
        if ($this->checkLogInStatus()) {
            return View::make('admin/index', $this->fetchAdminDisplayedData());
        } else {
            header('location: '.URLROOT.'admin/login');
            if (is_null( $params)) {
                return View::make('admin/login');
            }
            return View::make('admin/login', $params);
        }

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
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->checkLogInStatus()) {
                return View::make('admin/index');
            }
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $loginData = ['username' => trim($_POST['username']), 'password' => trim($_POST['password'])];
            $loginResult = $this->userModel->login($loginData);

            if ($this->checkExec($loginResult)) {
                header('location: ' . URLROOT . 'admin');
                $this->createUserSession($this->getExecInfo($loginResult));
                return View::make('admin/index', $this->fetchAdminDisplayedData());
            }
            $params = ['err_msg' => $loginResult['info']];
            return View::make('admin/login', array_merge($params, $loginData));
        } else {
            return View::make('admin/login');
        }
    }

    public function logout(): View
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['tab']);
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