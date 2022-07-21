<?php

namespace App\Models\Resignation;

use Illuminate\Database\Eloquent\Model;

class Pacraresignations extends Model
{
    protected $table = 'pacra_resignations';
    protected  $fillable =['id', 'user_id', 'am_id', 'uh_id', 'resignation_type', 'resignation_date',
        'last_working_day', 'leave_balance', 'inRC', 'total_period_served', 'notice_period_days', 'address', 'phone', 'email', 'reason', 'status'];
    public $timestamps = true;
}
