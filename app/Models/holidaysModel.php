<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class holidaysModel extends Model
{
    protected $table = 'pacra_holidays';
    protected  $fillable =['id', 'holiday_name','holiday_type', 'from_date', 'to_date', 'status'];
    public $timestamps = true;
}
