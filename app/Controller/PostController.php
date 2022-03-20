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
//        var_dump($_GET);
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

    public function removePost(): View
    {
        $post_id = ($_POST['post_id']);
        $_SESSION['tab'] = self::POST_ACTION;

        if ($post_id && is_numeric($post_id) ) {
            $this->postModel->removePost($post_id);
            $this->commentModel->removeCommentByPostId($post_id);
            header('location: '.URLROOT.'admin');
            return $this->admin();
        } else {
            return $this->errorPage();
        }
    }

    public function createPost(): View
    {
        $_SESSION['tab'] = self::POST_ACTION;
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = ['body' => trim($_POST['body']),
                'title' => trim($_POST['title']),
                'user_id' => trim($_POST['user_id'])];
//            var_dump($data);

            if ($this->postModel->createPost($data)){

                header('location: '.URLROOT.'admin');
                return $this->admin();
            } else {
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
            if ($this->postModel->updatePost($data)){

                header('location: '.URLROOT.'admin');
                return $this->admin();

            } else {
                return View::make('admin/post/update');
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