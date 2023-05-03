<?php

namespace App\controllers;

use App\classes\Mail;

class IndexController extends BaseController
{


    public function show(){

        //echo "Inside Homepage from controller class";

        $mail = new Mail();
        $data =[
          'to' => 'cebotari.john@gmail.com',
          'subject' => 'Welcome to acme store',
          'view' => 'welcome',
          'name' => 'John Doe',
          'body' => "Testing email template"
        ];

        if($mail->send($data)){
            echo "Email send successfully";
        } else{
            echo "Email sending failure";
        }

    }



}