<?php

namespace App\controllers\admin;

use App\classes\CSRFToken;
use App\classes\Request;
use App\models\Category;

class ProductCategoryController
{
    public function show(){
        $categories = Category::all();
        return view('admin/products/categories',compact('categories'));
    }

    public function store(){
        if(Request::has('post')){
            $request = Request::get('post');

            if(CSRFToken::verifyCSRFToken($request->token)){
                //process form data
                Category::create([
                    'name' => $request->name,
                    'slug' => slug($request->name)
                ]);
                $categories = Category::all();
                $message = 'Category created';
                return view('admin/products/categories',compact('categories','message'));
            }
            throw new \Exception('Token mismatch');
        }
        return null;
    }

}