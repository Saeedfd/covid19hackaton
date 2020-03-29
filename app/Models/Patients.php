<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/29/20
 * Time: 8:57 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'hospital_id', 'file_number'
    ];
}