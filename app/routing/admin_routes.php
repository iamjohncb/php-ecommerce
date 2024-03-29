<?php
//for admin routes
$router->map('GET','/admin','App\controllers\admin\DashboardController@show','admin_dashboard');
$router->map('GET','/admin/charts','App\controllers\admin\DashboardController@getChartdata','admin_dashboard_charts');

//product management
$router->map('GET','/admin/product/categories','App\controllers\admin\ProductCategoryController@show','product_category');

$router->map('POST','/admin/product/categories','App\controllers\admin\ProductCategoryController@store','create_product_category');
$router->map('POST','/admin/product/categories/[i:id]/edit','App\controllers\admin\ProductCategoryController@edit','edit_product_category');
$router->map('POST','/admin/product/categories/[i:id]/delete','App\controllers\admin\ProductCategoryController@delete','delete_product_category');

//subcategory
$router->map('POST','/admin/product/subcategory/create','App\controllers\admin\SubCategoryController@store','create_subcategory');
$router->map('POST','/admin/product/subcategory/[i:id]/edit','App\controllers\admin\SubCategoryController@edit','edit_subcategory');
$router->map('POST','/admin/product/subcategory/[i:id]/delete','App\controllers\admin\SubCategoryController@delete','delete_subcategory');

//products
$router->map('GET','/admin/category/[i:id]/selected','App\controllers\admin\ProductController@getSubcategories','selected_category');

$router->map('GET','/admin/product/create','App\controllers\admin\ProductController@showCreateProductForm','create_product_form');
$router->map('POST','/admin/product/create','App\controllers\admin\ProductController@store','create_product');

$router->map('GET','/admin/products','App\controllers\admin\ProductController@show','show_products');

$router->map('GET', '/admin/product/[i:id]/edit',
    'App\controllers\admin\ProductController@showEditProductForm', 'edit_product_form');
$router->map('POST', '/admin/product/edit',
    'App\controllers\admin\ProductController@edit', 'edit_product');

$router->map('GET', '/admin/transactions/orders',
    'App\controllers\admin\OrderController@show', 'dashboard_transactions_orders');
$router->map('GET', '/admin/transactions/payments',
    'App\controllers\admin\PaymentController@show', 'dashboard_transactions_payments');

$router->map('GET', '/admin/users',
    'App\controllers\admin\UserController@show', 'show_users');

$router->map('POST', '/admin/users/[i:id]/edit', 'App\controllers\admin\UserController@edit', 'edit_user_role');