<?php

namespace App\Controller;

use App\View\View;

class BaseController
{

    public function __construct(
//        protected InvoiceService $invoiceService,
    )
    {
//        echo "At BaseController <br />";
    }

    public function index() : View
    {
        echo "At BaseController index <br />";
        return View::make('index');
//        return (new View('index'))->renderPage();
    }

    public function form(): View {
        echo "At BaseController form <br />";
        return View::make('users/create');
//        return (new View('users/create'))->renderPage();
    }

}