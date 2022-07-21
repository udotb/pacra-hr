<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraScheduleTest extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'candidate_for_test';
    protected  $fillable =['id','userID', 'candidateID', 'jobID', 'testConductors', 'testDate',
        'testTime', 'candidateEmailText', 'conductorEmailText'];
    public $timestamps = true;
}
