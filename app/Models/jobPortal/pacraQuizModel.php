<?php

namespace App\Models\jobPortal;

use Illuminate\Database\Eloquent\Model;

class pacraQuizModel extends Model
{
    protected $connection = 'jobportal';
    protected $table = 'pacra_quiz';
    protected  $fillable =['id','title', 'marks', 'time', 'description', 'status', 'isActive'];
    public $timestamps = true;




    public function questions()
    {
        return $this->hasMany('App\Models\jobPortal\pacraQuestionsModel', 'quizID', 'id');
    }
}


