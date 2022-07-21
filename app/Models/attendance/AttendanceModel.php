<?php


namespace App\Models\Attendance;

use App\Models\Employees\UsersModel;
use Illuminate\Database\Eloquent\Model;
use Session;

class AttendanceModel extends Model
{

    protected $table = 'pacra_attendance';
    protected $appends = ['count_late', 'count_absent', 'count_leave', 'count_holiday', 'count_time'];
    protected $fillable = ['id', 'user_id', 'date', 'log_in_time', 'log_out_time', 'ip_address_login', 'ip_address_logout', 'status', 'office_hours', 'punch_out_status'];
    public $timestamps = true;

    public function getCountLateAttribute()
    {
        // dd($this->count_late);
        // if($this->status == 1)
        // {
        return AttendanceModel::callQuery($this->user_id, 1);
        // }

    }

    public function getCountTimeAttribute()
    {
        // if($this->status == 2)
        // {
        return AttendanceModel::callQuery($this->user_id, 2);
        // }
    }

    public function getCountLeaveAttribute()
    {
        // if($this->status == 3)
        // {
        return AttendanceModel::callQuery($this->user_id, 3);
        // }

    }

    public function getCountAbsentAttribute()
    {
        // if($this->status == 4)
        // {
        return AttendanceModel::callQuery($this->user_id, 4);
        // }

    }

    public function getCountHolidayAttribute()
    {
        // if($this->status == 6)
        // {
        return AttendanceModel::callQuery($this->user_id, 6);
        // }

    }

    public function callQuery($user_id, $status)
    {
        return AttendanceModel::where('user_id', $user_id)->whereBetween('date', [Session::get('from'), Session::get('to')])->where('status', $status)->count();
    }

    public function user()
    {
        return $this->hasOne(UsersModel::class, 'id', 'user_id');
    }
}
