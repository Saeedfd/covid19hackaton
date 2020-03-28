<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/28/20
 * Time: 4:39 PM
 */

namespace App\Http\Controllers\Traits;


class Returner
{
    /**
     * Generate a success response
     *
     * @param integer       $code       HTTP status code (2XX)
     * @param null|string   $message    Message to showing to the client
     * @param null|array    $data       Array of data to be return to the user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function successReturner($code, $data = null, $message = null)
    {
        $result = [];
        $message AND $result['message']  =   $message;
        $data AND $result['data'] =   $data;

        return $this->stateReturn($result, $code);
    }

    /**
     * Generate a failed response
     *
     * @param integer       $code       HTTP status code (2XX)
     * @param null|string   $message    Message to showing to the client
     * @param null|array    $data       Array contain information about errors occurred
     * @param null|integer  $errorCode  Error code for exploring detail of this error
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function failureReturner($code, $errorCode, $data = null, $message = null)
    {
        $result = [];
        $message AND $result['message']  =   $message;
        $data AND $result['data'] =   $data;
        $errorCode AND $result['error_code'] = $errorCode;

        return $this->stateReturn($result, $code);
    }

    /**
     * @param integer   $code   HTTP status code
     * @param array     $data   general data to return
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function stateReturn($data, $code)
    {
        return Response()->json($data, $code);
    }
}