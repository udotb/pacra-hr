<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraApplicantProfileModel extends Model
{

    protected $connection = 'jobportal';
    protected $table = 'applicant_profile';
    protected  $fillable =['id', 'userID', 'fname', 'lname',  'email', 'dob', 'contactNumber', 'linkedin',
                            'address', 'image', 'cv','status' ];
    public $timestamps = true;
}
