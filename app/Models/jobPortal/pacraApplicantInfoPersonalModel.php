<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraApplicantInfoPersonalModel extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'applicant_info_personal';
    protected  $fillable =['id', 'userID', 'cnic', 'gender',  'nationality', 'religion', 'maritalStatus', 'status' ];
    public $timestamps = true;
}
