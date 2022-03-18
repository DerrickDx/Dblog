<?php

namespace App\Controller;

use App\Model\Comment;
use App\Model\Post;

use App\View\View;

class BlogController extends BaseController
{
    protected Post $postModel;
    protected Comment $commentModel;

    public function __construct()
    {
        $this->postModel = new Post();
        $this->commentModel = new Comment();
    }

    public function index() :View
    {
//        $results = (new Post())->getPostList();
        $results = $this->postModel->getPostList();
//        foreach ($results as $res) {
//            print_r($res);
//            print_r('<br />');
//        }

//        return View::make('admin/index', ['foo' => 'bar']);
        return View::make('blog/index', $results);
    }

    public function getPostList()
    {
        $results = $this->postModel->getPostList();
//        return View::make('admin/index', ['posts' => $results]);
        return json_encode($results);
//        return $results;
//        return View::make('admin/index', ['posts' => $results]);
    }

    public function getSinglePost() :View
    {
//        var_dump($_GET);
        if ($_GET['id']) {
            $postId = $_GET['id'];
        } else if ($_POST['post_id']) {
            $postId = $_POST['post_id'];
        } else {
            return $this->errorPage();
        }
//        echo 'aaa';
//        echo '<br />' . $postId . '<br />';
//        $postId = 1;
//        $results = (new Post())->getPostById($postId);
        $results = $this->postModel->getPostById($postId);
//        foreach ($results as $k => $v) {
////            print_r($k . '   -   '. $v);
//            print_r($k);
//            print_r('<br /><br /><br /><br /><br /><br /><br />');
//        }
//        print_r($results);
//        return View::make('admin/index', ['foo' => 'bar']);
//        echo $results['post']->post_created_at . '<br>';

        return View::make('blog/details', $results);
    }

    public function addComment()
    {
        if ($_POST['post_id']) {
            $postId = $_POST['post_id'];
        } else {
            return $this->errorPage();
        }

        $this->commentModel->addComment($_POST);
//        echo 'aaa';
//        echo '<br />' . $postId . '<br />';
//        $postId = 1;
        $results = $this->postModel->getPostById($postId);


//        return View::make('blog/details', $results);

//        return (new BlogController())->getSinglePost();
        header('location: '.URLROOT.'blog/post?id=' . $postId);
    }



}