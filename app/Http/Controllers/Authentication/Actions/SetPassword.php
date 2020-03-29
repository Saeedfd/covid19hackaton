<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/29/20
 * Time: 11:52 PM
 */

namespace App\Http\Controllers\Authentication\Actions;


use App\Http\Controllers\Traits\BaseAction;
use App\User;
use Illuminate\Http\Request;

class SetPassword extends BaseAction
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
        $password   =   $this->request->input('password');

        $user   =   User::where('id', $this->request->user()->id)->first();
        $user->password =   bcrypt($password);
        $user->set_password =   "0";

        if($user->save()) {
            return true;
        }

        return ['error' => 'Server Error'];
    }

    public function rules()
    {
        return [
            'password'  =>  'required|string|min:6,max:100',
        ];
    }
}