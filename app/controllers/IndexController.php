<?php

namespace App\controllers;

use App\models\Product;

class IndexController extends BaseController
{
    public function show()
    {
        return view('home');
    }

    public function featuredProducts()
    {
        $products = Product::where('featured', 1)->inRandomOrder()->limit(4)->get();
        echo json_encode(['featured' => $products]);
    }

}