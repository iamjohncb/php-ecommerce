<?php

namespace App\controllers\admin;

use App\classes\Session;
use App\controllers\BaseController;
use App\classes\Request;

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

    public function get(){

        Request::refresh();
        $data = Request::old('post','product');
        var_dump($data);

        /*
        if(Request::has('post')){
            $request = Request::get('post');
            var_dump($request->product);
        }else {
            var_dump('posting doesnt exist');
        }
        */
    }

}