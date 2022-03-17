<?php

namespace App\Controller;

use App\Model\Post;
//require_once 'PostController.php';
use App\Controller\PostController;
use App\Model\Comment;
use App\View\View;

class CommentController extends BaseController
{
    public function index() :View
    {

        $results = (new Post())->getPostList();

        return View::make('posts/index', $results);
    }

    public function addComment()
    {
        if ($_POST['post_id']) {
            $postId = $_POST['post_id'];
        } else {
            return $this->errorPage();
        }

        (new Comment())->addComment($_POST);
//        echo 'aaa';
//        echo '<br />' . $postId . '<br />';
//        $postId = 1;
        $results = (new Post())->getPostById($postId);


//        return View::make('posts/details', $results);

//        return (new PostController())->getSinglePost();
        header('location: '.URLROOT.'posts/details?id=' . $postId);
    }



}