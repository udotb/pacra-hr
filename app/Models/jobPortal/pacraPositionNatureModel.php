<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraPositionNatureModel extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'positions_nature';
    protected  $fillable =['id','title'];
    public $timestamps = true;
}
