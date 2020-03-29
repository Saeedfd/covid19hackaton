<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/29/20
 * Time: 9:12 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id', 'user_id'
    ];
}