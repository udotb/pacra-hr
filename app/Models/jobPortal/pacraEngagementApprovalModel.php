<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraEngagementApprovalModel extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'engagement_approval';
    protected  $fillable =['id','userID', 'jobID', 'candidateID', 'reference', 'department',
    'engagementPeriodType', 'engagementPeriod', 'candidateName', 'designation',
    'grade', 'doj', 'probSalary', 'afterProbSalary', 'benifits', 'status' ];
    public $timestamps = true;
}
