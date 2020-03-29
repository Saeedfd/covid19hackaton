<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/29/20
 * Time: 8:56 PM
 */

namespace App\Http\Controllers\Patients\Actions;


use App\Http\Controllers\Authentication\Actions\DoRegister;
use App\Http\Controllers\Contacts\Actions\AddContact;
use App\Http\Controllers\Traits\BaseAction;
use App\Models\Patients;
use App\User;
use Illuminate\Http\Request;

class AddPatient extends BaseAction
{
    protected $register;
    protected $addContact;
    public function __construct(Request $request, DoRegister $doRegister, AddContact $contact)
    {
        parent::__construct($request);

        $this->register = $doRegister;
        $this->addContact   =   $contact;
    }

    public function validation()
    {
        if (($errors = parent::validation()) !== true) {
            return $errors;
        }

        $beforeAdded = Patients::where('hospital_id', $this->request->input('hospital_id'))
                                ->where('file_number', $this->request->input('file_number'))
                                ->first();

        if(isset($beforeAdded)) {
            return ['message' => 'Duplicate patient.'];
        }

        return true;
    }

    public function execute()
    {
        $name   =   $this->request->input('name');
        $hospitalId  =   $this->request->input('hospital_id');
        $fileNumber =   $this->request->input('file_number');
        $contact    =   $this->request->input('contact');
        $contactId  =   null;

        //validate Contact
        $contactIsRegistered    =   User::where('email', $contact)->first();

        if(isset($contactIsRegistered->id)) {
            $contactId = $contactIsRegistered->id;
        } else {
            //register Contact
            $data['email']  =   $contact;
            $data['name']   =   $name   .   "'s Contact";
            $data['password']   =   "123456";
            $data['role']   =   "contact";
            $registeredContact  =   $this->register->execute($data);
            $contactId  =   $registeredContact['user_id'];
        }

        $patient    =   new Patients();
        $patient->name  =   $name;
        $patient->hospital_id   =   $hospitalId;
        $patient->file_number   =   $fileNumber;

        if($patient->save()) {

            //Adding Contact
            $contactData['patient_id']  =   $patient->id;
            $contactData['user_id'] =   $contactId;
            if($this->addContact->execute($contactData) == true) {
                return [
                    'id'    =>  $patient->id,
                    'name'  =>  $patient->name,
                    'contact'   =>  $contact
                ];
            }
        }

        return ['error' => 'Server Error'];
    }

    public function rules()
    {
        return [
            'hospital_id'   =>  'required|numeric|exists:hospitals,id',
            'file_number'   =>  'required|numeric',
            'name'  =>  'required|string|max:100',
            'contact'   =>  'required|string|max:200'
        ];
    }
}