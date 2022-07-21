<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class DepartmentModel extends Model
{
    protected $table = 'pacra_teams';
    protected  $fillable =['id', 'title','status', 'isActive', 'last_updated_by'];
    public $timestamps = true;
}
