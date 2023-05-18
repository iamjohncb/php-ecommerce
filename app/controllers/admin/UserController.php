<?php

namespace App\controllers\admin;

use App\classes\CSRFToken;
use App\classes\Redirect;
use App\classes\Request;
use App\classes\Role;
use App\classes\ValidateRequest;
use App\controllers\BaseController;
use App\models\User;

class UserController extends BaseController
{

    private $table_name = 'users';
    public function __construct()
    {

        if (!Role::middleware('admin')){
            Redirect::to('/login');
        }

    }

    public function show(){
        $users = User::all()->count();
        list($users, $links) = paginate(7, $users, $this->table_name, new User);
        return view('admin/users', compact('users', 'links'));
    }

    public function edit($id)
    {
        if (Request::has('post')) {
            $request = Request::get('post');
            $extra_errors = [];

            if (CSRFToken::verifyCSRFToken($request->token, false)) {
                $rules = [
                    'role' => ['required' => true]
                ];

                $validate = new ValidateRequest;
                $validate->abide($_POST, $rules);

                if ($validate->hasError()) {
                    $errors = $validate->getErrorMessages();
                    header('HTTP/1.1 422 Unprocessable Entity', true, 422);
                    echo json_encode($errors);
                    exit;
                }

                User::where('id', $id)->update(['role' => $request->role]);
                echo json_encode(['success' => 'Role Updated Successfully']);
                exit;
            }

            throw new \Exception('Token mismatch');
        }

        return null;
    }

}