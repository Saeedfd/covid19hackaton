<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/28/20
 * Time: 4:48 PM
 */

namespace App\Http\Controllers\Authentication\Actions;


use App\Http\Controllers\Traits\BaseAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DoLogin extends BaseAction
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function validation()
    {
        if (($errors = parent::validation()) !== true) {
            return $errors;
        }

        return true;
    }

    public function execute()
    {
        $email  =   $this->request->input('email');
        $password   =   $this->request->input('password');

        if(!Auth::attempt(['email' => $email, 'password' => $password])) {
            return [
                'error' => "Unauthorized",
                'message' => 'Wrong email or password',
            ];
        }

        $user = $this->request->user();

        $token = $user->createToken('covid19')->accessToken;

        return [
            'user_id'   => $user->id,
            'token' =>  $token,
            'name'  =>  $user->name,
            'set_password'  =>  $user->set_password
        ];
    }

    public function rules()
    {
        return [
            'email' =>  'required|string|exists:users,email',
            'password'  =>  'required|string'
        ];
    }
}