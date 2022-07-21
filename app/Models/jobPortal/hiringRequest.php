<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class hiringRequest extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'hiring_request';
    protected  $fillable =['id','hiringType', 'location', 'vacancies', 'engagementPeriodType',
    'engagementPeriod', 'grade', 'department', 'sub_department',
     'title', 'description', 'requirements', 'jobExpectations', 'jobBenefits', 'experience',
        'salary', 'requestBy','amID' ,'approvedBy', 'authenticateBy', 'status','jobPostingDate', 'lastDate', 'policy_grade', 'last_updated_by'];
    public $timestamps = true;
}
