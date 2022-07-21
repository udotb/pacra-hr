<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraJobsCandidateModel extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'job_candidates';
    protected  $fillable =['id','userID', 'jobID', 'applyDate', 'candidateStatus', 'rejection_comment'];
    public $timestamps = true;
}
