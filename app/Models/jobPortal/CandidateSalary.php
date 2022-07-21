<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class CandidateSalary extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'candidate_salary';
    protected  $fillable =['id','userID', 'jobID', 'candidateID','doj',
    'candidateName', 'probBasicSalaryMin', 'probBasicSalary',  'confirmationSalaryMin', 'confirmationSalary',
     'status' ];
    public $timestamps = true;
}
