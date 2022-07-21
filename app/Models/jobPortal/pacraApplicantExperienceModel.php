<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraApplicantExperienceModel extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'applicant_experience';
    protected  $fillable =['id', 'userID', 'companyName',  'jobPosition', 'periodFrom',
        'periodTo','status' ];
    public $timestamps = true;
}
