<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraQuestionOptionsModel extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'pacra_questions_options';
    protected  $fillable =['id','quizID', 'questionID', 'options', 'optionsTitle'];
    public $timestamps = true;
}
