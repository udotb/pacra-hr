<?php

namespace App\Models\attendance;

use Illuminate\Database\Eloquent\Model;

class attendanceActivityModel extends Model
{

    protected $table = 'pacra_attendance_activity';
    protected  $fillable =['id', 'user_id', 'date', 'time', 'activity'];
    public $timestamps = true;

}