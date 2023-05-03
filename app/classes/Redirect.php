<?php

namespace App\classes;

use http\Header;

class Redirect
{

    /**
     * Redirect to specific page
     * @param $page
     * @return void
     */
    public static function to($page){
        header("location: $page");
    }

    /**
     * Redirect to same page
     */
    public static function back(){
        $url = $_SERVER['REQUEST_URI'];
        header("location: $url");
    }

}