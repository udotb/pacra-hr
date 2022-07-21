<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class jobTitles extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'job_titles';
    protected  $fillable =['id', 'title', 'description', 'requirements', 'jobExpectations', 'jobBenefits',
        'salary'];
    public $timestamps = true;

}
