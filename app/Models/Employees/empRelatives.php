<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class empRelatives extends Model
{
    protected $table = 'pacra_emp_relatives';
    protected  $fillable =['id', 'name'];
    public $timestamps = true;
}
