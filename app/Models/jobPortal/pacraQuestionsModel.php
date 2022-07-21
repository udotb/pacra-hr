<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraQuestionsModel extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'pacra_quiz_questions';
    protected  $fillable =['id','quizID', 'question', 'isActive'];
    public $timestamps = true;



    public function options()
    {
        return $this->hasMany('App\Models\jobPortal\pacraQuestionOptionsModel', 'questionID', 'id');
    }


}


