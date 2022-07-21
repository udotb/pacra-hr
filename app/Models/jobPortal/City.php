<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //protected $connection = 'jobportal';
    protected $table = 'city';
    protected  $fillable =['id','city', 'country', 'province', 'coun_id'];
    public $timestamps = true;
}
