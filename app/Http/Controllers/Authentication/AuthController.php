<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/28/20
 * Time: 4:48 PM
 */

namespace App\Http\Controllers\Authentication;


use App\Http\Controllers\Authentication\Actions\DoLogin;
use App\Http\Controllers\Authentication\Actions\DoLogout;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Returner;

class AuthController extends Controller
{
    protected $returner;

    public function __construct(Returner $returner)
    {
        $this->returner = $returner;
    }

    public function login(DoLogin $user)
    {
        // Do Validating
        if (($errors = $user->validation()) !== true) {
            return $this->returner->failureReturner(
                400,
                10003,
                $errors,
                "Invalid inputs"
            );
        }

        $result = $user->execute();

        if(isset($result['error'])) {
            return $this->returner->failureReturner(
                400,
                10004,
                $result['message'],
                null
            );
        }

        return $this->returner->successReturner(
            200,
            $result,
            'Successfully logged in'
        );
    }

    public function logout(DoLogout $user)
    {
        // Do Validating
        if (($errors = $user->validation()) !== true) {
            return $this->returner->failureReturner(
                400,
                10005,
                $errors,
                "Invalid inputs"
            );
        }

        $result = $user->execute();

        if(isset($result['error'])) {
            return $this->returner->failureReturner(
                400,
                10006,
                $result['error'],
                null
            );
        }

        return $this->returner->successReturner(
            200,
            $result,
            'Successfully logged out'
        );
    }
}