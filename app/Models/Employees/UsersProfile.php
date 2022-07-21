<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class UsersProfile extends Model
{
    protected $table = 'pacra_users_profile';
    protected  $fillable =['id', 'user_id', 'fname', 'lname', 'uname', 'display_name', 'email', 'pemail', 'emp_id', 'doj',
        'c_date', 'fnp_date',
        'dpt', 'sub_dpt', 'desg', 'grade', 'cnic','phone','emp_phone','emp_relation','emp_name','dob',
        'nationality','religion','gender','marital','report_to','linkedin','web_check','last_qualification',
        'exp_outside_pacra','exp_in_pacra','last_employer','address','status', 'reason', 'cv', 'avatar_file', 'created_by_id',
        'sign'
        ];
    public $timestamps = true;
}
