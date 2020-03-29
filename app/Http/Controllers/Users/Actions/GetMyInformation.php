<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/30/20
 * Time: 12:19 AM
 */

namespace App\Http\Controllers\Users\Actions;


use App\Http\Controllers\Traits\BaseAction;
use App\Models\Contacts;
use App\Models\Hospitals;
use App\User;
use Illuminate\Http\Request;

class GetMyInformation extends BaseAction
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
        $user   =   User::where('id', $this->request->user()->id)->first();

        switch ($user->role) {
            case "admin":
                $description    =   "Admin";
                break;
            case "nurse":
                $hospital    =   Hospitals::select('hospitals.name AS name')
                                        ->join('nurses', 'nurses.hospital_id', '=', 'hospitals.id')
                                        ->where('nurses.user_id', $this->request->user()->id)
                                        ->first();
                $description    = $hospital->name   . " Hospital";
                break;
            case "contact":
                $patient    =   Contacts::select('patients.name AS name')
                                        ->join('patients', 'patients.id', '=', 'contacts.patient_id')
                                        ->where('user_id', $this->request->user()->id)
                                    ->first();
                $description    =   $patient->name  .   "'s Contact";
                break;
            default:
                $description = null;
        }


        return [
            'user_id' => $user->id,
            'name'  =>  $user->name,
            'role'  =>  $user->role,
            'set_password'  =>  $user->set_password,
            'description'   =>  $description
        ];
    }

    public function rules()
    {
        return [

        ];
    }
}