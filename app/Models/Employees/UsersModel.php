<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    protected $table = 'og_users';
    protected  $fillable =['id', 'company_id','employee_id', 'fname', 'lname', 'username',
        'email', 'pemail', 'doj', 'grade','department', 'sub_dpt', 'cnic','phone', 'emergency_contact',
        'emg_name', 'emg_relation', 'birthday', 'nationality', 'religion', 'marital_status',
        'address', 'gender', 'display_name', 'avatar_file','created_by_id',
        'updated_by_id', 'can_see_all_ratings', 'can_approve_ppl', 'can_approve_nl', 'can_view_model_db', 'can_view_op_mapping',
        'can_approve_assessment_format', 'can_approve_op_mapping', 'can_upload_sector_study',
        'can_manage_configuration', 'can_upload_criteria', 'can_view_op_transfer', 'can_manage_reports', 'can_manage_time',
        'can_add_mail_accounts', 'auto_assign', 'default_billing_id', 'designation_id', 'team_id', 'can_manage_mm', 'am_id',
        'is_active', 'password', 'display_name2', 'display_designation', 'fit_proper', 'fit_proper_date',
        'newu_id', 'can_view_update_sectors', 'can_upload_happiness', 'can_view_taskq', 'can_approve_info',
        'can_view_portfolio_assignment', 'can_approve_mandate', 'can_approve_ss', 'can_view_bd_grid', 'can_approve_policy',
        'can_add_policy', 'rights', 'employment_status', 'confirmation_date', 'linkedin', 'profile_on_web', 'cv',
        'last_qualification','exp_outside_pacra', 'exp_in_pacra', 'last_employer','status'];
    public $timestamps = true;
}
