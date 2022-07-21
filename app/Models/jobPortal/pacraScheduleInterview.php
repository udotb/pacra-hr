<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraScheduleInterview extends Model
{

    protected $connection = 'jobportal';
    protected $table = 'candidate_for_interview';
    protected $fillable = ['id', 'userID', 'candidateID', 'jobID', 'interviewRound', 'interviewers', 'date',
        'time', 'interviewLocation', 'candidateEmailText', 'conductorEmailText', 'scannedTest', 'obtainedMarks',
        'miscellaneousDoc', 'status', 'interviewSheetHR', 'interviewSheetTL', 'interviewSheetUH'];
    public $timestamps = true;

}
