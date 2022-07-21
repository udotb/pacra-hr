<?php

namespace App\Models\Resignation;

use Illuminate\Database\Eloquent\Model;

class PacraSeparationCheckList extends Model
{
    protected $table = 'pacra_separationform_checklist';
    protected  $fillable =['id', 'attribute','checkList', 'isActive'];
    public $timestamps = true;
}
