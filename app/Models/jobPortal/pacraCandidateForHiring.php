<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraCandidateForHiring extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'candidate_for_hiring';
    protected  $fillable =['id','userID', 'candidateID', 'jobID', 'decision'];
    public $timestamps = true;
}
