<?php

namespace App\Models\attendance;

use Illuminate\Database\Eloquent\Model;

class WorkFromHomeModel extends Model
{
    protected $table = 'pacra_workfromhome';
    protected  $fillable =['id', 'user_id', 'attribute', 'dates', 'reason', 'status', 'recommend_by', 'approved_by'];
    public $timestamps = true;
}
