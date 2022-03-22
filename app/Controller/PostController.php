<?php

namespace App\Controller;

use App\Config\Route;
use App\View\View;

class PostController extends BaseController
{
    #[Route('/blog', GET)]
    public function getBLogPostList() :View
    {
        $results = $this->postModel->getBLogPostList();
        return View::make('blog/index', $results);
    }

    #[Route('/blog/post', GET)]
    public function getBlogPost() :View
    {
        if ($_GET['id']) {
            $postId = $_GET['id'];
        } else if ($_POST['post_id']) {
            $postId = $_POST['post_id'];
        } else {
            return $this->errorPage();
        }

        $results = $this->postModel->getBlogPostById($postId);

        return View::make('blog/details', $results);
    }

    #[Route('/admin/removePost', POST)]
    public function removePost()
    {
        $post_id = ($_POST['post_id']);


        if ($post_id && is_numeric($post_id) ) {
            $this->setTab(POST_ACTION);

            $execResult = $this->postModel->removePost($post_id);
            if($this->checkExec($execResult)) {
                messageDisplay('Post Removed');
            } else {
                messageDisplay('Failed. '. $this->getExecInfo($execResult), 'err_msg');
            }
            $this->commentModel->removeCommentByPostId($post_id);
            header('location: '.URLROOT.'admin');
        } else {
            return $this->errorPage();
        }
    }

    #[Route('/admin/createPost', POST)]
    public function createPost()
    {
        if ($this->checkLogInStatus()) {

            if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_POST) {
                $this->setTab(POST_ACTION);
                $data = ['body' => trim($_POST['body']),
                    'title' => trim($_POST['title']),
                    'user_id' => trim($_POST['user_id'])];

                $execResult = $this->postModel->createPost($data);
                if($this->checkExec($execResult)) {
                    messageDisplay('Post Created');
                    header('location: '.URLROOT.'admin');
                } else {
                    messageDisplay('Failed. '. $this->getExecInfo($execResult), 'err_msg');
                    return View::make('admin/post/add');
                }
            } else {
                $userList = $this->userModel->getUserList();
                return View::make('admin/post/add', ['users' => $userList]);
            }
        } else {
            return $this->sessionExpiredPage();
        }
    }

    #[Route('/admin/post/add', GET)]
    public function addPost(): View
    {
        if ($this->checkLogInStatus()) {

            if($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_GET) {
                $this->setTab(POST_ACTION);

                $userList = $this->userModel->getUserList();
                return View::make('admin/post/add', ['users' => $userList]);
            } else {
                return $this->errorPage();
            }
        } else {
            return $this->sessionExpiredPage();
        }
    }

    #[Route('/admin/updatePost', POST)]
    public function updatePost()
    {
        if ($this->checkLogInStatus()) {

            if ($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_POST) {
                $this->setTab(POST_ACTION);
                $data = [
                    'body' => trim($_POST['body']),
                    'title' => trim($_POST['title']),
                    'id' => trim($_POST['post_id']),
                    'user_id' => trim($_POST['user_id'])
                ];

                $execResult = $this->postModel->updatePost($data);
                if ($this->checkExec($execResult)) {
                    messageDisplay('Post Updated');
                    header('location: ' . URLROOT . 'admin');

                } else {
                    messageDisplay('Failed. ' . $this->getExecInfo($execResult), 'err_msg');
                    $params = ['err_msg' => $this->getExecInfo($execResult)];
                    return View::make('admin/post/update', $params);
                }
            } else {

                return $this->errorPage();

            }
        } else {
            return $this->sessionExpiredPage();
        }
    }

    #[Route('/admin/post/edit', GET)]
    public function editPost(): View
    {
        if ($this->checkLogInStatus()) {

            if ($_SERVER['REQUEST_METHOD'] == HTTP_METHOD_GET) {
                $_SESSION['tab'] = POST_ACTION;
                $post_id = ($_GET['id']);
                if ($post_id && is_numeric($post_id)) {
                    $result = $this->postModel->getPostById($post_id);
                    $userList = $this->userModel->getUserList();
                    return View::make('admin/post/update', ["post" => $result, 'users' => $userList]);
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
}