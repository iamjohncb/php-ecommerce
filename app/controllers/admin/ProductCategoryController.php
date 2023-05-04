<?php

namespace App\controllers\admin;

use App\classes\CSRFToken;
use App\classes\Request;
use App\classes\ValidateRequest;
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
                $rules = [
                    'name' => ['required' => true, 'maxLength' => 5, 'string' => true, 'unique' => 'categories']
                ];

                $validate =  new ValidateRequest;
                $validate->abide($_POST, $rules);

                if($validate->hasError()){
                    var_dump($validate->getErrorMessages());
                    exit;
                }
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