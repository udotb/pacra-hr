<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'institutes';
    protected  $fillable =['id','title', 'city', 'province', 'isActive'];
    public $timestamps = true;
}
