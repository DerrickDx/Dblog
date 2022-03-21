<?php

namespace App\Controller;

use App\View\View;

class PostController extends BaseController
{

    public function getBLogPostList() :View
    {
        $results = $this->postModel->getBLogPostList();
        return View::make('blog/index', $results);
    }

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

    public function removePost()
    {
        $post_id = ($_POST['post_id']);
        $_SESSION['tab'] = self::POST_ACTION;

        if ($post_id && is_numeric($post_id) ) {


            $execResult = $this->postModel->removePost($post_id);
            if($this->checkExec($execResult)) {
                messageDisplay('Post Removed');
            } else {
                messageDisplay(message:'Failed. '. $this->getExecInfo($execResult), name:'err_msg');
            }
            $this->commentModel->removeCommentByPostId($post_id);
            header('location: '.URLROOT.'admin');
        } else {
            return $this->errorPage();
        }
    }

    public function createPost()
    {
        $_SESSION['tab'] = self::POST_ACTION;
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = ['body' => trim($_POST['body']),
                'title' => trim($_POST['title']),
                'user_id' => trim($_POST['user_id'])];

            $execResult = $this->postModel->createPost($data);
            if($this->checkExec($execResult)) {
                messageDisplay('Post Created');
                header('location: '.URLROOT.'admin');
            } else {
                messageDisplay(message:'Failed. '. $this->getExecInfo($execResult), name:'err_msg');
                return View::make('admin/post/add');
            }
        } else {
            $userList = $this->userModel->getUserList();
            return View::make('admin/post/add', ['users' => $userList]);
        }
    }

    public function updatePost(): View
    {
        $_SESSION['tab'] = self::POST_ACTION;
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = ['body' => trim($_POST['body']),
                'title' => trim($_POST['title']),
                'id' => trim($_POST['post_id']),
                'user_id' => trim($_POST['user_id'])];

            $execResult = $this->postModel->updatePost($data);
            if ($this->checkExec($execResult)){
                messageDisplay('Post Updated');
                header('location: '.URLROOT.'admin');

            } else {
                messageDisplay(message:'Failed. '. $this->getExecInfo($execResult), name:'err_msg');
                $params = ['err_msg' => $this->getExecInfo($execResult)];
                return View::make('admin/post/update', $params);
            }
        } else {
            $post_id = ($_GET['id']);
            if ($post_id && is_numeric($post_id) ) {
                $result = $this->postModel->getPostById($post_id);
                $userList = $this->userModel->getUserList();
                return View::make('admin/post/update', ["post" =>$result, 'users' => $userList]);
            } else {
                return $this->errorPage();
            }
        }
    }

}