<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraAppointmentLetterModel extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'appointment_letter';
    protected  $fillable =['id','userID', 'jobID', 'candidateID', 'refrence', 'date','doj', 'designation',
    'candidateEmpNo', 'candidategrade', 'candidateName', 'candidateEmail',
    'candidatePhone', 'probBasicSalary', 'probEOBIEmployer', 'probEOBIEmployee', 'confirmationSalary',
    'confirmationEOBIEmployer', 'confirmationEOBIEmployee', 'status' ];
    public $timestamps = true;
}
