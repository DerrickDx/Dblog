<?php

namespace App\Controller;

use App\Config\Route;
use App\Model\Comment;
use App\Model\Post;
use App\Model\User;
use App\View\View;


class BaseController
{

    public function __construct(
        protected User $userModel,
        protected Post $postModel,
        protected Comment $commentModel
    ) {

    }

    /**
     * Navigate to index page
     * @return View
     */
    #[Route('/', GET)]
    public function index() : View
    {
        return View::make('index');
    }

    /**
     * Navigate to error page
     * @return View
     */
    #[Route('/error', GET)]
    public function errorPage(): View {

        return View::make('not-found');
    }

    /**
     * Navigate to session expired notification  page
     * @return View
     */
    #[Route('/expired', GET)]
    public function sessionExpiredPage(): View {

        return View::make('expired');
    }


}