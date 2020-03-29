<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 3/29/20
 * Time: 10:17 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Hospitals extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'city', 'address'
    ];
}