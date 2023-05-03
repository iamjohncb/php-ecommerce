<?php

namespace App\controllers\admin;

use App\classes\Session;
use App\controllers\BaseController;

class DashboardController extends BaseController
{

    public function show(){

        Session::add('admin','You are welcome, admin user');

        if(Session::has('admin')){
            $msg=Session::get('admin');
        }else{
            $msg='Not defined';
        }

        return view('admin/dashboard',['admin' => $msg]);

    }

}