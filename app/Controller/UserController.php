<?php

namespace App\Controller;

use App\Config\Route;

use App\View\View;

class UserController extends BaseController
{

    /**
     * Navigate to admin page
     * @return View
     */
    #[Route('/admin', GET)]
    public function admin() : View
    {
        return $this->adminRedirect();
    }


    /**
     * Create an admin user
     */
    #[Route('/admin/createUser', POST)]
    public function createUser()
    {
        if (checkLogInStatus()) {

            if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_POST) {
               setTab(USER_ACTION);
                $data = ['username' => trim($_POST['username']), 'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT)];
                $checkNameRes = $this->userModel->getUserByName($data['username']);
                if (checkExec($checkNameRes)) {
                    $execResult = $this->userModel->createUser($data);
                    if (checkExec($execResult)){
                        messageDisplay('User ' . $data['username']. ' Created');
                        redirect('location: '.URLROOT.'admin');
                    } else {
                        messageDisplay('Failed. '. getExecInfo($execResult), 'err_msg');
                        return View::make('admin/user/add');
                    }
                } else {
                    $params = ['err_msg' => getExecInfo($checkNameRes)];
                    return View::make('admin/user/add', array_merge($params, $_POST));
                }
            } else {
                return $this->errorPage();
            }
        } else {
            return $this->sessionExpiredPage();
        }
    }

    /**
     * Navigate to the page for creating an admin user
     * @return View
     */
    #[Route('/admin/user/add', GET)]
    public function addeUser(): View
    {
        if (checkLogInStatus()) {
            if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_GET) {
               setTab(USER_ACTION);
                return View::make('admin/user/add');
            } else {
                return $this->errorPage();
            }
        }else {
            return $this->sessionExpiredPage();
        }
    }

    /**
     * Update an admin user
     */
    #[Route('/admin/updateUser', POST)]
    public function updateUser()
    {
        if (checkLogInStatus()) {
            if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_POST) {
                setTab(USER_ACTION);
                $data = [
                    'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
                    'id' => trim($_POST['user_id'])];
                $execResult = $this->userModel->updateUser($data);
                if (checkExec($execResult)) {
                    // If editing the logged-in user themselves, navigate to the login page
                    if ($_SESSION['user_id'] == trim($data['id'])) {
                        removeUserSession();
                        $params = ['msg' => 'User ' . trim($_POST['username']). ' Updated <br/> Please Log In Again'];
                        return View::make('admin/login', $params);
                    } else {
                        messageDisplay('User ' . trim($_POST['username']). ' Updated');
                        redirect('location: ' . URLROOT . 'admin');
                    }
                } else {
                    messageDisplay('Failed. '. getExecInfo($execResult), 'err_msg');
                    $result = $this->userModel->getUserById($data['id']);
                    return View::make('admin/user/update', ["user" =>$result]);
                }
            } else {
                return $this->errorPage();
            }
        } else {
            return $this->sessionExpiredPage();
        }
    }

    /**
     * Navigate to the page for editing an admin user
     * @return View
     */
    #[Route('/admin/user/edit', GET)]
    public function editUser(): View
    {
        if (checkLogInStatus()) {
            if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_GET) {
                setTab(USER_ACTION);
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

    /**
     * Remove an admin user
     */
    #[Route('/admin/removeUser', POST)]
    public function removeUser()
    {
        $user_id = ($_POST['user_id']);
        if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_POST) {
           setTab(USER_ACTION);
            if ($user_id && is_numeric($user_id) ) {
               $execResult = $this->userModel->removeUser(intval($user_id));
               if(checkExec($execResult)) {
                   messageDisplay('User Removed');
               } else {
                   messageDisplay('Failed. '. getExecInfo($execResult), 'err_msg');
               }

                redirect('location: '.URLROOT.'admin');
            } else {
                return $this->errorPage();
            }
        } else {
            return $this->errorPage();
        }
    }

    /**
     * Login to the admin
     * Navigate to user login page
     * @return View
     */
    #[Route('/admin/login', POST)]
    #[Route('/admin/login', GET)]
    public function login(): View
    {
        if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_POST) {
            if (checkLogInStatus()) {
                return View::make('admin/index');
            }
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $loginData = ['username' => trim($_POST['username']), 'password' => trim($_POST['password'])];
            $loginResult = $this->userModel->login($loginData);
            if (checkExec($loginResult)) {
                redirect('location: ' . URLROOT . 'admin');
                createUserSession(getExecInfo($loginResult));
                return View::make('admin/index', $this->fetchAdminDisplayedData());
            }

            $params = ['err_msg' => getExecInfo($loginResult)];
            return View::make('admin/login', array_merge($params, $loginData));
        } else if ($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_GET){
            return View::make('admin/login');
        } else {
            return $this->errorPage();
        }
    }

    #[Route('/admin/logout', GET)]
    public function logout(): View
    {
        removeUserSession();
        return $this->admin();
    }

    /**
     * Redirect to pages depending on the login status
     * @param $params
     * @return View
     */
    public function adminRedirect($params = null): View
    {
        if (checkLogInStatus()) {
            return View::make('admin/index', $this->fetchAdminDisplayedData());
        } else {
            redirect('location: '.URLROOT.'admin/login');
            if (is_null( $params)) {
                return View::make('admin/login');
            }
            return View::make('admin/login', $params);
        }

    }


    /**
     * Fetch the data to display in the admin page
     * @return array
     */
    public function fetchAdminDisplayedData(): array
    {

        $userList = $this->userModel->getUserList();
        $postList = $this->postModel->getPostList();
        $commentList = $this->commentModel->getCommentList();

        return  ['users' => getExecInfo($userList), 'posts' => getExecInfo($postList), 'comments' => getExecInfo($commentList), 'source' => $_SESSION['tab']];
    }

}