<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/30/20
 * Time: 12:16 AM
 */

namespace App\Http\Controllers\Users;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Returner;
use App\Http\Controllers\Users\Actions\GetMyInformation;

class UsersController extends Controller
{
    protected $returner;

    public function __construct(Returner $returner)
    {
        $this->returner = $returner;
    }

    public function getMyInformation(GetMyInformation $user)
    {
        // Do Validating
        if (($errors = $user->validation()) !== true) {
            return $this->returner->failureReturner(
                400,
                30001,
                $errors,
                "Invalid inputs"
            );
        }

        $result = $user->execute();

        if(isset($result['error'])) {
            return $this->returner->failureReturner(
                400,
                30002,
                $result['error'],
                null
            );
        }

        return $this->returner->successReturner(
            200,
            $result,
            'Success'
        );
    }
}