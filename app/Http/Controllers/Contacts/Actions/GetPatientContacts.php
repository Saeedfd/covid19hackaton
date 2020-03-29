<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/30/20
 * Time: 1:37 AM
 */

namespace App\Http\Controllers\Contacts\Actions;


use App\Http\Controllers\Traits\BaseAction;
use App\Models\Contacts;
use Illuminate\Http\Request;

class GetPatientContacts extends BaseAction
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
        $patient    =   Contacts::where('user_id', $this->request->user()->id)->first();
        if(isset($patient)) {
            return  Contacts::select('name', 'email', 'users.id AS user_id')
                ->join('users', 'users.id', '=', 'contacts.user_id')
                ->where('contacts.patient_id', $patient->id)
                ->get();
        }

        return null;
    }

    public function rules()
    {
        return [

        ];
    }
}