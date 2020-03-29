<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/29/20
 * Time: 9:10 PM
 */

namespace App\Http\Controllers\Contacts\Actions;


use App\Http\Controllers\Traits\BaseAction;
use App\Models\Contacts;
use Illuminate\Http\Request;

class AddContact extends BaseAction
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
        $patientId  =   (isset($data['patient_id']))    ?   $data['patient_id'] :   $this->request->input('patient_id');
        $userId =   (isset($data['user_id']))  ?    $data['user_id']    :   $this->request->input('user_id');

        $contact    =   new Contacts();
        $contact->patient_id    =   $patientId;
        $contact->user_id   =   $userId;

        if($contact->save()) {
            return true;
        }

        return ['error' => 'Server Error'];
    }

    public function rules()
    {
        return [
            'patient_id'   =>  'required|numeric|exists:patients,id',
            'user_id'  =>  'required|numeric|exists:users,id',
        ];
    }
}