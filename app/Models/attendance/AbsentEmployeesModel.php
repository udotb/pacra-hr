<?php

namespace App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;

class AbsentEmployeesModel extends Model
{
    protected $table = 'pacra_absent_employees';
    protected  $fillable =['id', 'user_id', 'date'];
    public $timestamps = true;
}
