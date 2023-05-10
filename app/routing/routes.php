<?php

$router = new AltoRouter;

$router->map('GET','/', 'App\controllers\IndexController@show','home');
$router->map('GET', '/featured', 'App\controllers\IndexController@featuredProducts', 'feature_product');

require_once __DIR__.'/admin_routes.php';