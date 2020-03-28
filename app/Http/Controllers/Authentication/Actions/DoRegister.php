<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/28/20
 * Time: 6:26 PM
 */

namespace App\Http\Controllers\Authentication\Actions;


use App\Http\Controllers\Traits\BaseAction;
use App\User;
use Illuminate\Http\Request;

class DoRegister extends BaseAction
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

    public function execute($data = null)
    {
        $name   =   (isset($data['name']))  ?:  $this->request->input('name');
        $email  =   (isset($data['email']))    ?:  $this->request->input('email');
        $password   =   (isset($data['password']))  ?:  $this->request->input('password');
        $role   =   (isset($data['role']))  ?:  $this->request->input('role');


        $user   =   new User();
        $user->name =   $name;
        $user->email    =   $email;
        $user->password =   bcrypt($password);
        $user->role = $role;

        if($user->save()) {
            $token = $user->createToken('covid19')->accessToken;
            return [
                'user_id'   => $user->id,
                'role'  =>  $user->role,
                'name'  =>  $user->name,
                'token' =>  $token
            ];
        }

        return ['error' => 'Server Error'];
    }

    public function rules()
    {
        return [
            'email' =>  'required|string|unique:users|max:255',
            'password'  =>  'required|string|min:6,max:100',
            'name'  =>  'required|string|max:100',
            'role'  =>  'required|string|in:nurse,contact,admin'
        ];
    }
}