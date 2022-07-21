<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrTrainingsTable extends Model
{
    protected $table = 'hr_trainings';
    protected $fillable = ['date', 'title', 'duration', 'attendees', 'areas'];
}
