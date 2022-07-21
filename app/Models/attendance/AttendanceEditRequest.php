<?php

namespace App\Models\attendance;

use Illuminate\Database\Eloquent\Model;

class AttendanceEditRequest extends Model
{
    protected $table = 'pacra_attendance_edit_request';
    protected  $fillable =['id', 'attendance_record', 'user_id', 'am_id', 'attendance_edit_reason','old_punch_in', 'new_punch_in',
        'attachment','status', 'recommendBy', 'approvedBy'];
    public $timestamps = true;
}
