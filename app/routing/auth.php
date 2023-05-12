<?php

$router->map('GET','/register', 'App\controllers\AuthController@showRegisterForm','register');
$router->map('POST','/register', 'App\controllers\AuthController@register','register_me');

$router->map('GET','/login', 'App\controllers\AuthController@showLoginForm','login');
$router->map('POST','/login', 'App\controllers\AuthController@login','login_me');

$router->map('GET', '/logout', 'App\controllers\AuthController@logout', 'logout');