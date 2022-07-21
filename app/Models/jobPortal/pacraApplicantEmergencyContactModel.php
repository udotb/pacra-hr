<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraApplicantEmergencyContactModel extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'applicant_emg_contact';
    protected  $fillable =['id', 'userID', 'contactNameOne',  'relationshipOne', 'phoneOne',
        'contactNameTwo', 'relationshipTwo', 'phoneTwo' ,'status' ];
    public $timestamps = true;
}
