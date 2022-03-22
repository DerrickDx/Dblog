<?php

namespace App\Controller;

use App\Config\Route;
use App\Model\Comment;
use App\Model\Post;
use App\Model\User;
use App\View\View;
use function Sodium\add;

class UserController extends BaseController
{

    #[Route('/admin', GET)]
    public function admin() : View
    {
        return $this->adminRedirect();
    }

    #[Route('/admin/userLogin', POST)]
    public function userLogin(): View
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
            return $this->errorPage();
        }
    }

    #[Route('/admin/login', GET)]
    public function login(): View
    {
        return View::make('admin/login');
    }

    #[Route('/admin/logout', GET)]
    public function logout(): View
    {
        $this->removeUserSession();

        return $this->admin();
    }

    #[Route('/admin/createUser', POST)]
    public function createUser()
    {
        if ($this->checkLogInStatus()) {

            if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_POST) {
                $this->setTab(USER_ACTION);
                $data = ['username' => trim($_POST['username']), 'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT)];
                if (!$this->userModel->getUserByName($data['username'])) {
                    $execResult = $this->userModel->createUser($data);
                    if ($this->checkExec($execResult)){

                        messageDisplay('User ' . $data['username']. ' Created');
                        header('location: '.URLROOT.'admin');

    //                    return $this->admin();
                    } else {
                        messageDisplay('Failed. '. $this->getExecInfo($execResult), 'err_msg');
                        return View::make('admin/user/add');
                    }
                } else {
                    $params = ['err_msg' => 'User already exits'];
                    return View::make('admin/user/add', array_merge($params, $_POST));
                }
            } else {
                return View::make('admin/user/add');
            }
        } else {
            return $this->sessionExpiredPage();
        }
    }

    #[Route('/admin/user/add', GET)]
    public function addeUser(): View
    {
        if ($this->checkLogInStatus()) {
            if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_GET) {
                $this->setTab(USER_ACTION);
                return View::make('admin/user/add');
            } else {
                return $this->errorPage();
            }
        }else {
            return $this->sessionExpiredPage();
        }
    }

    #[Route('/admin/updateUser', POST)]
    public function updateUser()
    {
        if ($this->checkLogInStatus()) {

            if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_POST) {
                $this->setTab(USER_ACTION);
                $data = [
                    'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
                    'id' => trim($_POST['user_id'])];
                $execResult = $this->userModel->updateUser($data);
                if ($this->checkExec($execResult)) {

                    if ($_SESSION['user_id'] == trim($data['id'])) {
                        messageDisplay('User ' . trim($_POST['username']). ' Updated <br/> Please Log In Again');
                        return $this->logout();
                    } else {
                        messageDisplay('User ' . trim($_POST['username']). ' Updated');
                        header('location: ' . URLROOT . 'admin');
                    }
                } else {
                    messageDisplay('Failed. '. $this->getExecInfo($execResult), 'err_msg');
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
        } else {
            return $this->sessionExpiredPage();
        }
    }

    #[Route('/admin/user/edit', GET)]
    public function editUser(): View
    {
        if ($this->checkLogInStatus()) {
            if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_GET) {
                $this->setTab(USER_ACTION);
                $user_id = ($_GET['id']);
                if ($user_id && is_numeric($user_id) ) {
                    $result = $this->userModel->getUserById($user_id);
                    return View::make('admin/user/update', ["user" =>$result]);
                } else {
                    return $this->errorPage();
                }
            } else {
                return $this->errorPage();
            }
        } else {
            return $this->sessionExpiredPage();
        }
    }

    #[Route('/admin/removeUser', POST)]
    public function removeUser()
    {
        $user_id = ($_POST['user_id']);
        if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_POST) {
            $this->setTab(USER_ACTION);
            if ($user_id && is_numeric($user_id) ) {
               $execResult = $this->userModel->removeUser(intval($user_id));
               if($this->checkExec($execResult)) {
                   messageDisplay('User Removed');
               } else {
                   messageDisplay('Failed. '. $this->getExecInfo($execResult), 'err_msg');
               }

                header('location: '.URLROOT.'admin');
            } else {
                return $this->errorPage();
            }
        } else {
            return $this->errorPage();
        }
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
        $_SESSION['tab'] = USER_ACTION;
    }


    public function removeUserSession()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['tab']);
        unset($_SESSION['msg']);
    }

    public function fetchAdminDisplayedData(): array
    {
        $userList = $this->userModel->getUserList();
        $postList = $this->postModel->getPostList();
        $commentList = $this->commentModel->getCommentList();

        return  ['users' => $userList, 'posts' => $postList, 'comments' => $commentList, 'source' => $_SESSION['tab']];
    }

}