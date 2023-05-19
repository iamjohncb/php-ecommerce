<?php
$router->map('POST', '/cart', 'App\controllers\CartController@addItem', 'add_cart_item');
$router->map('GET', '/cart', 'App\controllers\CartController@show', 'view_cart');
$router->map('GET', '/cart/items', 'App\controllers\CartController@getCartItems', 'get_cart_items');

$router->map('POST', '/cart/update-qty', 'App\controllers\CartController@updateQuantity', 'update_cart_qty');
$router->map('POST', '/cart/remove-item', 'App\controllers\CartController@removeItem', 'remove_cart_item');

$router->map('POST', '/cart/empty', 'App\controllers\CartController@emptyCart', 'empty_cart');
$router->map('POST', '/cart/payment', 'App\controllers\CartController@checkout', 'handle_payment');

$router->map('POST', '/paypal/create-payment',
    'App\controllers\CartController@paypalCreatePayment', 'paypal_create_payment');
$router->map('POST', '/paypal/execute-payment',
    'App\controllers\CartController@paypalExecutePayment', 'paypal_execute_payment');