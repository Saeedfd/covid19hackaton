<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/29/20
 * Time: 10:53 PM
 */

namespace App\Http\Controllers\Patients\Actions;


use App\Http\Controllers\Traits\BaseAction;
use App\Models\Nurses;
use App\Models\Patients;
use Illuminate\Http\Request;

class GetSinglePatient extends BaseAction
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
        //Check if nurse and patient is the same hospital
        $nurse  =   Nurses::where('user_id', $this->request->user()->id)->first();
        $patient    =   Patients::where('file_number', $this->request->input('file_number'))
            ->where('hospital_id', $this->request->input('hospital_id'))->first();

        if(!isset($nurse) or $nurse->hospital_id  !== $patient->hospital_id) {
            return ['message' => 'File number is not from you hospital.'];
        }

        return [
            'name'  =>  $patient->name,
            'id'    =>  $patient->id
        ];
    }

    public function rules()
    {
        return [
            'file_number'   =>  'required|numeric|exists:patients,file_number',
            'hospital_id'   =>  'required|numeric|exists:hospitals,id'
        ];
    }
}