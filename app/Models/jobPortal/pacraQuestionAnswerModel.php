<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraQuestionAnswerModel extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'pacra_question_answers';
    protected  $fillable =['id','quizID', 'questionID', 'correctAnswer'];
    public $timestamps = true;
}
