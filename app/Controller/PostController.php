<?php

namespace App\Controller;

use App\Model\Post;

use App\View\View;

class PostController extends BaseController
{
    public function index() :View
    {

        $results = (new Post())->getPostList();
//        foreach ($results as $res) {
//            print_r($res);
//            print_r('<br />');
//        }

//        return View::make('users/index', ['foo' => 'bar']);
        return View::make('posts/index', $results);
    }

    public function getSinglePost() :View
    {
        $postId = 1;
        $results = (new Post())->getPostById($postId);
//        foreach ($results as $k => $v) {
//            print_r($k . '   -   '. $v);
//            print_r('<br /><br /><br /><br /><br /><br /><br />');
//        }
//        print_r($results);
//        return View::make('users/index', ['foo' => 'bar']);
        return View::make('posts/details', $results);
    }
}