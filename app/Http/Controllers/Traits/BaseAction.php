<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/28/20
 * Time: 4:40 PM
 */

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class BaseAction
{
    protected $request;
    protected $errors = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    abstract protected function rules();

    public function errors()
    {
        return (array) $this->errors;
    }

    public function validation()
    {
        $validatorRules = Validator::make(
            $this->request->all(),
            $this->rules()
        );

        if($validatorRules->passes()) {
            return true;
        }

        $errors = $validatorRules->getMessageBag()->messages();

        $this->errors = array_merge($this->errors(), $errors);

        return $this->errors;
    }

    abstract public function execute();
}