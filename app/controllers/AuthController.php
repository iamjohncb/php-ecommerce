<?php

namespace App\controllers;

use App\classes\CSRFToken;
use App\classes\Redirect;
use App\classes\Request;
use App\classes\Session;
use App\classes\ValidateRequest;
use App\models\User;


class AuthController extends BaseController
{
    public function __construct()
    {
        if(isAuthenticated()){
            Redirect::to('/');
        }
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function register()
    {
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token)){
                $rules = [
                    'username' => ['required' => true, 'maxLength' => 20, 'string' => true, 'unique' => 'users'],
                    'email' => ['required' => true, 'email' => true, 'unique' => 'users'],
                    'password' => ['required' => true, 'minLength' => 6],
                    'fullname' => ['required' => true, 'minLength' => 6, 'maxLength' => 50],
                    'address' => ['required' => true, 'minLength' => 4, 'maxLength' => 500, 'mixed' => true]
                ];

                $validate = new ValidateRequest;
                $validate->abide($_POST, $rules);

                if($validate->hasError()){
                    $errors = $validate->getErrorMessages();
                    return view('register', ['errors' => $errors]);
                }

                //insert into database
                User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => password_hash($request->password, PASSWORD_BCRYPT),
                    'fullname' => $request->fullname,
                    'address' => $request->address,
                    'role' => 'user',
                ]);

                Request::refresh();
                return view('register', ['success' => 'Account created, please login']);
            }
            throw new \Exception('Token Mismatch');
        }
        return null;
    }

    public function login()
    {
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token)){
                $rules = [
                    'username' => ['required' => true],
                    'password' => ['required' => true],
                ];

                $validate = new ValidateRequest;
                $validate->abide($_POST, $rules);

                if($validate->hasError()){
                    $errors = $validate->getErrorMessages();
                    return view('login', ['errors' => $errors]);
                }

                /**
                 * Check if user exist in db
                 */
                $user = User::where('username', $request->username)
                    ->orWhere('email', $request->username)->first();

                if($user){
                    if(!password_verify($request->password, $user->password)){
                        Session::add('error', 'Incorrect password');
                        return view('login');
                    }else{
                        Session::add('SESSION_USER_ID', $user->id);
                        Session::add('SESSION_USER_NAME', $user->username);

                        if($user->role == 'admin'){
                            Redirect::to('/admin');
                        }else if($user->role == 'user' && Session::has('user_cart')){
                            Redirect::to('/cart');
                        }else{
                            Redirect::to('/');
                        }
                    }
                }else{
                    Session::add('error', 'User not found, please try again');
                    return view('login');
                }
            }else {
            throw new \Exception('Token Mismatch');
        }
            }
        return null;
    }

    public function logout()
    {
        if(isAuthenticated()){
            Session::remove('SESSION_USER_ID');
            Session::remove('SESSION_USER_NAME');

            if(!Session::has('user_cart')){
                session_destroy();
                session_regenerate_id(true);
            }
        }
        Redirect::to('/');
    }

}