<?php

namespace App\controllers\admin;

use App\classes\Redirect;
use App\controllers\BaseController;
use App\models\Order;
use App\models\Payment;
use App\models\Product;
use App\models\User;
use Illuminate\Database\Capsule\Manager as Capsule;

class DashboardController extends BaseController
{

    public function show(){
        //$orders = Capsule::table('orders')->count(Capsule::raw('DISTINCT order_no'));
        $orders = Order::all()->count();
        $products = Product::all()->count();
        $users = User::all()->count();
        $payments = Payment::all()->sum('amount') / 100;
        return view('admin/dashboard', compact('orders', 'products', 'payments', 'users'));
    }

    /**
     * Get specific request type
     * @return void
     */
    public function getChartData()
    {
        $revenue = Capsule::table('payments')->select(
            Capsule::raw('sum(amount) / 100 as `amount`'),
            Capsule::raw("DATE_FORMAT(created_at, '%m-%Y') as new_date"),
            Capsule::raw('YEAR(created_at) as year, Month(created_at) as month')
        )->groupBy('year', 'month', 'new_date')->get();

        $orders = Capsule::table('orders')->select(
            Capsule::raw('count(id) as `count`'),
            Capsule::raw("DATE_FORMAT(created_at, '%m-%Y') as new_date"),
            Capsule::raw('YEAR(created_at) as year, Month(created_at) as month')
        )->groupBy('year', 'month', 'new_date')->get();

        echo json_encode([
            'revenues' => $revenue,
            'orders' => $orders
        ]);
    }


}