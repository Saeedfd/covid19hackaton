<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/29/20
 * Time: 8:56 PM
 */

namespace App\Http\Controllers\Patients;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Patients\Actions\AddPatient;
use App\Http\Controllers\Patients\Actions\GetSinglePatient;
use App\Http\Controllers\Traits\Returner;

class PatientsController extends Controller
{
    protected $returner;

    public function __construct(Returner $returner)
    {
        $this->returner = $returner;
    }

    public function AddPatient(AddPatient $patient)
    {
        // Do Validating
        if (($errors = $patient->validation()) !== true) {
            return $this->returner->failureReturner(
                400,
                20001,
                $errors,
                "Invalid inputs"
            );
        }

        $result = $patient->execute();

        if(isset($result['error'])) {
            return $this->returner->failureReturner(
                400,
                20002,
                $result['error'],
                null
            );
        }

        return $this->returner->successReturner(
            200,
            $result,
            'Successfully patient added.'
        );
    }

    public function GetSinglePatient(GetSinglePatient $patient)
    {
        // Do Validating
        if (($errors = $patient->validation()) !== true) {
            return $this->returner->failureReturner(
                400,
                20003,
                $errors,
                "Invalid inputs"
            );
        }

        $result = $patient->execute($errors);

        if(isset($result['error'])) {
            return $this->returner->failureReturner(
                400,
                20004,
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