<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/28/20
 * Time: 4:48 PM
 */

namespace App\Http\Controllers\Authentication\Actions;


use App\Http\Controllers\Traits\BaseAction;
use Illuminate\Http\Request;


class DoLogout extends BaseAction
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
        $this->request->user()->token()->revoke();
        return true;
    }

    public function rules()
    {
        return [

        ];
    }
}