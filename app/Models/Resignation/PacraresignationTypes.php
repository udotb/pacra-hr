<?php

namespace App\Models\Resignation;

use Illuminate\Database\Eloquent\Model;

class PacraresignationTypes extends Model
{
    protected $table = 'pacra_resignation_type';
    protected  $fillable =['id', 'title', 'isActive'];
    public $timestamps = true;
}
