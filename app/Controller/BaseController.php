<?php

namespace App\Controller;

use App\Config\Route;
use App\Model\Comment;
use App\Model\Post;
use App\Model\User;
use App\View\View;


class BaseController
{

//    protected User $userModel;
//    protected Post $postModel;
//    protected Comment $commentModel;
//    public function __construct()
//    {
//        $this->userModel = new User();
//        $this->postModel = new Post();
//        $this->commentModel = new Comment();
//    }

    public function __construct(
        protected User $userModel,
        protected Post $postModel,
        protected Comment $commentModel)
    {

    }

    #[Route('/', GET)]
    public function index() : View
    {
        return View::make('index');
    }


    public function errorPage(): View {

        return View::make('not-found');
    }

    public function sessionExpiredPage(): View {

        return View::make('expired');
    }

    public function checkExec($res)
    {
        return $res['succeeded'];
    }

    public function getExecInfo($res)
    {
        return $res['info'];
    }

    public function checkLogInStatus(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function setTab($tab)
    {
        $_SESSION['tab'] = $tab;
    }


}