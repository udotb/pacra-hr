<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraApplicantEducationModel extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'applicant_education';
    protected  $fillable =['id', 'userID', 'institution',  'subject', 'startingDate',
        'completeDate', 'degree', 'grade' ,'status' ];
    public $timestamps = true;
}
