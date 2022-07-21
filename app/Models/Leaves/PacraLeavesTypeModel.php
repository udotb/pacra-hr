<?php

namespace App\Models\Leaves;

use Illuminate\Database\Eloquent\Model;

class PacraLeavesTypeModel extends Model
{
    protected $table = 'pacra_leaves_type';
    protected  $fillable =['id', 'name', 'isActive'];
    public $timestamps = true;
}
