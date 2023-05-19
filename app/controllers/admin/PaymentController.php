<?php
namespace App\controllers\admin;

use App\classes\Redirect;
use App\classes\Role;
use App\controllers\BaseController;
use App\models\Payment;

class PaymentController extends BaseController
{
    private $table_name = 'payments';

    public function __construct()
    {
        if(!Role::middleware('admin')){
            Redirect::to('/login');
        }
    }

    public function show()
    {
        $total = Payment::all()->count();
        list($payments, $links) = paginate(7, $total, $this->table_name, new Payment);
        return view('admin/transactions/payments', compact('payments', 'links'));
    }
}