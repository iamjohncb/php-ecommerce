<?php
namespace App\controllers\admin;

use App\classes\Redirect;
use App\classes\Role;
use App\controllers\BaseController;
use App\models\Order;

class OrderController extends BaseController
{
    private $table_name = 'orders';

    public function __construct()
    {
        if(!Role::middleware('admin')){
            Redirect::to('/login');
        }
    }

    public function show()
    {
        $total = Order::all()->count();
        list($orders, $links) = paginate(10, $total, $this->table_name, new Order);
        return view('admin/transactions/orders', compact('orders', 'links'));
    }
}