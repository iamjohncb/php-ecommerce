<?php

namespace App\controllers;

use App\classes\Mail;

class IndexController extends BaseController
{
    public function show()
    {
        return view('home');
    }

}