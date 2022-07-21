<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class PacraSignTable extends Model
{
    protected $table = 'sign';
    protected $fillable = ['name', 'designation', 'sign', 'u_id'];
    public $timestamps = true;
}
