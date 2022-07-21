<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class ApplicantAboutYourself extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'applicant_about_yourself';
    public $timestamps = true;
}
