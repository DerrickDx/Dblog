<?php

namespace App\Controller;

use App\Model\Comment;
use App\Model\Post;
use App\Model\User;
use App\View\View;


class BaseController
{

    protected User $userModel;
    protected Post $postModel;
    protected Comment $commentModel;

    const USER_ACTION = 'user';
    const POST_ACTION = 'post';
    const COMMENT_ACTION = 'comment';

    public function __construct()
    {
        $this->userModel = new User();
        $this->postModel = new Post();
        $this->commentModel = new Comment();
    }

    public function index() : View
    {
        return View::make('index');
    }


    public function errorPage(): View {

        return View::make('404');
    }

    public function checkExec($res)
    {
        return $res['succeeded'];
    }

    public function getExecInfo($res)
    {
        return $res['info'];
    }
}