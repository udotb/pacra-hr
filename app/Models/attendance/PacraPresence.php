<?php

namespace App\Models\attendance;

use Illuminate\Database\Eloquent\Model;

class PacraPresence extends Model
{
    protected $table = 'pacra_presence';
    protected  $fillable =['id', 'user_id', 'date', 'reason'];
    public $timestamps = true;
}
