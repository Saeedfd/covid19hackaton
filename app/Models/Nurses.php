<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/29/20
 * Time: 10:55 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Nurses extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hospital_id', 'user_id'
    ];
}